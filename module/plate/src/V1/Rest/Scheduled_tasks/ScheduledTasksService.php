<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 03.06.2017
 * Time: 20:03
 */

namespace plate\V1\Rest\Scheduled_tasks;


use plate\EntityServicesSupport\EntitiesUtils;
use plate\EntityServicesSupport\EntityService;
use plate\EntitySupport\Collection;
use plate\EntitySupport\Entity;
use plate\V1\Rest\Dev2grp\Dev2grpResource;
use plate\V1\Rest\Devices\DevicesResource;
use plate\V1\Rest\Devices\DevicesService;
use plate\V1\Rest\DevicesAcl\DevicesAclResource;
use plate\V1\Rest\Groups\GroupsResource;
use plate\V1\Rest\Groups\GroupsService;
use plate\V1\Rest\Scheduled_tasks_dev_grp\Scheduled_tasks_dev_grpResource;
use plate\V1\Rest\Scheduled_tasks_timetable\Scheduled_tasks_timetableResource;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Join;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use ZF\ApiProblem\ApiProblem;

class ScheduledTasksService extends EntityService
{
    const WEEKDAYS = ['MONDAY','TUESDAY','WEDNESDAY','THURSDAY','FRIDAY','SATURDAY','SUNDAY'];
    const SCHEDULED_TIMETABLE_TIMEFORMAT = "Y-m-d H:i:s";
    const TURNS = ['on', 'off'];

    protected $entitiesUtils;

    /**
     * @var DevicesService
     */
    protected $devicesService;

    /**
     * @var GroupsService
     */
    protected $groupsService;

    public function create($data, $retrievedData)
    {
        /**
         * Время, на которое должны быть установлены элементы расписания
         */
        if($retrievedData['time'] != ""){
            $time = $retrievedData['time'];
            unset($retrievedData['time']);
        }

        /**
         * Пометки (для еженедельных задач - SUNDAY, MONDAY, TUESDAY, ...)
         */
        if(
            $retrievedData['stamps'] != "" &&
            preg_match_all("/(([0-9a-zA-Z]+)(\\s)*(,(\\s)*|$))/", $retrievedData['stamps'], $m)
        ){
            unset($retrievedData['stamps']);
            $stamps = $m[2];
        }

        /**
         * Id устройств, которые нужно включить в задание
         */
        if(
            $retrievedData['devices_ids'] != "" &&
            preg_match_all("/(([0-9a-zA-Z]+)(\\s)*(,(\\s)*|$))/", $retrievedData['devices_ids'], $m)
        ){
            unset($retrievedData['devices_ids']);
            $devices_ids = $m[2];
        }

        /**
         * Id групп, которые нужно включить в задание
         */
        if(
            $retrievedData['groups_ids'] != "" &&
            preg_match_all("/(([0-9a-zA-Z]+)(\\s)*(,(\\s)*|$))/", $retrievedData['groups_ids'], $m)
        ){
            unset($retrievedData['groups_ids']);
            $groups_ids = $m[2];
        }

        if(isset($devices_ids)) foreach ($devices_ids as $device_id){
            if(!$this->getDevicesService()->checkRightsToDevice($this->getAuthUtils()->getClientId(), $device_id)){
                return new ApiProblem(403, "Нет доступа к устройству #" . $device_id);
            }
        }

        if(isset($groups_ids)) foreach ($groups_ids as $group_id){
            if(!$this->getGroupsService()->checkRightsToGroup($this->getAuthUtils()->getClientId(), $group_id)){
                return new ApiProblem(403, "Нет доступа к группе #" . $group_id);
            }
        }

        /**
         * Создаем задание и получем на него права
         */
        unset($retrievedData['groups_ids']);
        unset($retrievedData['devices_ids']);
        if(isset($time)){
            $retrievedData['common_time'] = $time;
        }
        $scheduledTask = $this->getTableMapper()->create($retrievedData);
        $this->addRightsToScheduledTask($scheduledTask->id);

        /**
         * Добавляем устройства
         */
        if(isset($devices_ids)) foreach ($devices_ids as $device_id) {
            $scheduledTask_dev_grp = [
                'scheduled_task_id' => $scheduledTask->id,
                'dev_grp_type' => 'DEVICE',
                'id_device' => $device_id
            ];

            $this->getScheduledTasksDevGrpTableMapper()->create($scheduledTask_dev_grp);
        }

        /**
         * Добавляем группы
         */
        if(isset($groups_ids)) foreach ($groups_ids as $group_id) {
            $scheduledTask_dev_grp = [
                'scheduled_task_id' => $scheduledTask->id,
                'dev_grp_type' => 'GROUP',
                'id_group' => $group_id
            ];

            $this->getScheduledTasksDevGrpTableMapper()->create($scheduledTask_dev_grp);
        }

        if(
            isset($time) &&
            isset($stamps) &&
            !empty(array_intersect($stamps, self::WEEKDAYS))
        ){
            foreach ($stamps as $weekday) if(in_array($weekday, self::WEEKDAYS)){
                $times = explode(":", $time);

                $date = new \DateTime('next ' . strtolower($weekday));
                $date->setTime($times[0], $times[1], isset($times[2])? $times[2] : "00");
                $nextDTM = date(self::SCHEDULED_TIMETABLE_TIMEFORMAT, $date->getTimestamp());

                $scheduledTask_timetable = [
                    'begin_dtm' => $nextDTM,
                    'repeat_period' => 3600*24*7,
                    'state' => 'ACTIVE',
                    'next_dtm' => $nextDTM,
                    'special_stamp' => $weekday,
                    'scheduling_task_id' => $scheduledTask->id,
                    'name' => 'TIMETABLE_scheduledTask(' . $scheduledTask->id . ")_" .$weekday
                ];

                $this->getScheduledTasksTimeTableMapper()->create($scheduledTask_timetable);
            }
        }

        return $this->fetch($scheduledTask->id);
    }

    /**
     * @param $id
     * @return bool|\ZF\ApiProblem\ApiProblem
     */
    public function delete($id)
    {
        if(!$this->checkPrivilegesById($id))
            return $this->notAllowed();

        return $this->getTableMapper()->delete($id);
    }

    /**
     * Проверка полномочий на работу с назначенным заданием
     * @param $id
     * @return bool
     */
    protected function checkPrivilegesById($id)
    {

        if($this->getAuthUtils()->checkAdminPrivileges()){
            return true;
        }

        $params = [
            "scheduled_task_id" => $id,
            "client_id" => $this->getAuthUtils()->getClientId()
        ];

        return ($this->getUserAccessListMapper()->fetchAll($params)->getCurrentItemCount() !== 0);
    }

    protected function getUserAccessListMapper(){
        return $this->getITableService()->getTableMapperByKey(DevicesAclResource::class);
    }

    /**
     * @param $id
     * @return \plate\EntitySupport\Entity|\ZF\ApiProblem\ApiProblem
     */
    public function fetch($id)
    {
        if(!$this->checkPrivilegesById($id))
            return $this->notAllowed();

        $select = $this->getScheduledTasksSelectSpecialFormat(false);
        $select->where("st.id = " . $id);

        $adapter = new Adapter(
            $this->getTableMapper()->getTable()->getAdapter()->getDriver(),
            $this->getTableMapper()->getTable()->getAdapter()->getPlatform()
        );

        //die($select->getSqlString($this->getTableMapper()->getTable()->getAdapter()->getPlatform()));

        $dbSelect = new ScheduledDbSelect($this->getEntitiesUtils(), $select, $adapter);
        return $dbSelect->fetch($this->getTableMapper(), $id);
    }

    /**
     * См. аннотацию к fetchAllToArray()
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params)
    {
        $dbSelect = $this->fetchAllToArray($params);
        if(isset($params['room_id'])){
            $collection = new Collection($dbSelect);
            $collection->setItemCountPerPage(-1);
            return $collection;
        }
        return new Collection($dbSelect);
    }

    /**
     * Fetch all or a subset of resources
     * Для администраторов выбираются все записи
     * Для остальных - те записи, которым соответствуют разрешения в devices_acl
     *
     * Если в параметрах передан room_id, то это особый случай
     * Нужно вернуть задания, которые ассоциированы с комнатой (через устройство или группу)
     * Как обычный пользователь, так и администратор получают список в особом формате -
     * с указанием времени срабатывания первого элемента расписания задания,
     * а также со списком всех устройств и групп, включенных в задание.
     *
     * Если запросить список устройств без параметров от обычного пользователя,
     * список вернется также в особом формате
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAllToArray($params){
        $adapter = new Adapter(
            $this->getTableMapper()->getTable()->getAdapter()->getDriver(),
            $this->getTableMapper()->getTable()->getAdapter()->getPlatform()
        );

        /**
         * Особый случай - передан room_id
         */
        if(isset($params['room_id'])){
            $select = $this->getScheduledTasksSelectByRoomIdSpecialFormat($params['room_id']);
            $dbSelect = new ScheduledDbSelect($this->getEntitiesUtils(), $select, $adapter);
            return $dbSelect;
        }

        if($this->getAuthUtils()->checkAdminPrivileges()){
            /**
             * Администратор получает список всех объектов в обычном формате
             */
            // todo проверить правильность!!!!
            $select =  $this->getScheduledTasksSelectSpecialFormat();
            $dbSelect = new ScheduledDbSelect($this->getEntitiesUtils(), $select, $adapter);
            return $dbSelect;
            //return $this->getTableMapper()->fetchAll($params);
        }


        $select = $this->getScheduledTasksSelectSpecialFormat();
        $dbSelect = new ScheduledDbSelect($this->getEntitiesUtils(), $select, $adapter);
        return $dbSelect;
    }

    protected function getScheduledTasksSelect(){
        $stdgTableName = $this->getScheduledTasksDevGrpTableName();
        $sttTableName = $this->getScheduledTasksTimeTableName();

        $select = new Select();
        $select->from(
            ['st' => $this->getTableName()]
        )
            ->join(
                ['stdg' => $stdgTableName],
                "stdg.scheduled_task_id = st." . $this->getIdFieldName(),
                [

                ],
                Join::JOIN_INNER
            );

        /**
         * Колонки включают в себя список пометок special_stamp в элементах расписания
         * (для еженедельных расписаний это соответствует перечню дней недели),
         * а также время запуска первого элемента расписания.
         */
        $select
            ->columns(
                [
                    'scheduled.id' => 'id',
                    'scheduled.name' => 'name',
                    'scheduled.state' => 'state',
                    'scheduled.command' => 'command',
                    'scheduled.period_type' => 'period_type',
                    'scheduled.stamps' => new Expression("
                        (
                            select
                            group_concat(special_stamp)
                            from " . $sttTableName . " stt
                            where stt.scheduling_task_id = st." . $this->getIdFieldName() . "
                        )    
                    "),
                    'scheduled.time' => 'common_time'
                        /*new Expression("
                        (
                            select time(
                                substring_index(
                                    group_concat(
                                        cast(begin_dtm as CHAR) ORDER BY id), ',', 1
                                    )
                                )
                                from " . $sttTableName . " stt
                                where stt.scheduling_task_id = st." . $this->getIdFieldName() . "
                            )               
                        ")*/
                ]
            );

        return $select;
    }

    /**
     * Селектор для списка заданий в обычном формате
     * @return Select
     */
    protected function getScheduledTasksAclSelect(){
        $select = $this->getScheduledTasksSelect();
        /**
         * Для обычного пользователя выбираем то, что ему принадлежит
         */
        if(!$this->getAuthUtils()->checkAdminPrivileges()){
            $select->join(
                ['acl' => 'devices_acl'],
                "acl.scheduled_task_id = st." . $this->getIdFieldName(),
                [],
                Join::JOIN_INNER
            );
            $select->where("acl.client_id = '" . $this->getAuthUtils()->getClientId() . "'");
        }

        return $select;
    }

    /**
     * Селектор для списка заданий в обычном формате
     * @param bool $withAcl
     * @return Select
     */
    protected function getScheduledTasksSelectSpecialFormat($withAcl = true){
        $devicesTableName = $this->getDevicesTableName();
        $devicesIdField = $this->getDevicesIdFieldName();

        $groupsTableName = $this->getGroupsTableName();
        $groupsIdField = $this->getGroupsIdFieldName();

        $select = $withAcl? $this->getScheduledTasksAclSelect() : $this->getScheduledTasksAclSelect();
        $select->join(
            ['d' => $devicesTableName],
            "stdg.id_device = d." . $devicesIdField,
            [
                'device.id' => 'id',
                'device.mac' => 'mac',
                'device.ip' => 'ip',
                'device.channel' => 'channel',
                'device.description' => 'description',
                'device.room_id' => 'room_id',
                'device.type' => 'type',
                'device.max_amp' => 'max_amp',
                'device.connection_type' => 'connection_type',
                'device.last_command' => 'last_command'
            ],
            Join::JOIN_LEFT
        )
            ->join(
                ['g' => $groupsTableName],
                "stdg.id_group = g." . $groupsIdField,
                [
                    'group.id' => 'id',
                    'group.name' => 'name',
                    'group.last_command' => 'last_command'
                ],
                Join::JOIN_LEFT
            );

        return $select;
    }

    /**
     * Селектор для списка заданий, ассоциированных с комнатой, в особом формате
     * @param $room_id
     * @return Select
     */
    protected function getScheduledTasksSelectByRoomIdSpecialFormat($room_id)
    {
        $select = $this->getScheduledTasksSelectSpecialFormat();
        $select
        ->where("
            (
                exists(select * from devices dev where dev.room_id = " . $room_id . " and dev.id =
                  ANY(select id_device from scheduled_tasks_dev_grp stdg2 where stdg2.scheduled_task_id = st.id )
                )
                OR
                exists(
                    select * from dev2grp dg inner join devices dev on dg.device_id = dev.id
                    where dev.room_id = " . $room_id . " and dg.group_id =
                  ANY(select stdg2.id_group from scheduled_tasks_dev_grp stdg2 where stdg2.scheduled_task_id = st.id )
                )
            )
        ");


        return $select;
    }

    protected function getScheduledTasksDevGrpTableName(){
        return $this->getScheduledTasksDevGrpTableMapper()->getTable()->table;
    }

    /**
     * @return DevicesService
     */
    public function getDevicesService()
    {
        return $this->devicesService;
    }

    /**
     * @param DevicesService $devicesService
     */
    public function setDevicesService($devicesService)
    {
        $this->devicesService = $devicesService;
    }

    /**
     * @return GroupsService
     */
    public function getGroupsService()
    {
        return $this->groupsService;
    }

    /**
     * @param GroupsService $groupsService
     */
    public function setGroupsService($groupsService)
    {
        $this->groupsService = $groupsService;
    }

    /**
     * Включить/выключить срабатывание еженедельного задания в определенный день недели
     * @param $scheduled_task_id
     * @param $weekday
     * @param $turn
     * @return Entity|ApiProblem
     */
    public function changeWeekday($scheduled_task_id, $weekday, $turn)
    {
        if(!in_array($weekday, self::WEEKDAYS))
            return new ApiProblem(400, "День недели должен соответствовать одному из значений " . implode(",", self::WEEKDAYS));

        if(!in_array($turn, self::TURNS)){
            return new ApiProblem(400, "`turn` должно соответствовать одному из значений " . implode("," , self::TURNS));
        }

        $scheduled_task_id = (int) $scheduled_task_id;
        $params = [
            'scheduling_task_id' => $scheduled_task_id,
            'special_stamp' => $weekday
        ];
        $timeTableRes = $this->getScheduledTasksTimeTableMapper()->fetchAll($params);

        if($turn == "off") {
            if($timeTableRes->count() == 0) {
                return new ApiProblem(400, "Не найдено дня недели " . $weekday . " у ScheduledTask#" . $scheduled_task_id);
            }

            $timeTableElement = $timeTableRes->getCurrentItems()[0];
            $this->getScheduledTasksTimeTableMapper()->delete($timeTableElement->id);
        }

        if($turn == "on"){
            if($timeTableRes->count() > 0) {
                return new ApiProblem(400, "Уже есть день недели " . $weekday . " в расписании ScheduledTask#" . $scheduled_task_id);
            }

            $scheduledTask = Entity::asArray($this->getTableMapper()->fetch($scheduled_task_id));


            if(!isset($scheduledTask['common_time']) || $scheduledTask['common_time'] == null){
                return new ApiProblem(500, "Произошла ошибка. Время срабатывания не было сохранено");
            }

            $time = explode(":", $scheduledTask['common_time']);
            $date = new \DateTime('next ' . strtolower($weekday));
            $date->setTime($time[0], $time[1]);
            $nextDTM = date(self::SCHEDULED_TIMETABLE_TIMEFORMAT, $date->getTimestamp());
            $timeTableElement = [
                'begin_dtm' => $nextDTM,
                'repeat_period' => 3600*24*7,
                'next_dtm' => $nextDTM,
                'special_stamp' => $weekday,
                'name' => "TIMETABLE_scheduledTask(" . $scheduled_task_id . ")_" . $weekday,
                'scheduling_task_id' => $scheduled_task_id
            ];

            $this->getScheduledTasksTimeTableMapper()->create($timeTableElement);
        }

        return $this->fetch($scheduled_task_id);

    }

    /**
     * Изменить время срабатывания для еженедельного задания
     * @param $scheduled_task_id
     * @param $time
     * @return Entity|ApiProblem
     */
    public function changeTimeForWeeklyTask($scheduled_task_id, $time)
    {
        if(!preg_match("/([0-1][0-9]|20|21|22|23):[0-5][0-9]/", $time)){
            return new ApiProblem(400, "Задайте время в формате HH:mm");
        }

        $scheduledTask = Entity::asArray($this->getTableMapper()->fetch($scheduled_task_id));
        $scheduledTask['common_time'] = $time;

        $this->getTableMapper()->update($scheduled_task_id, $scheduledTask);
        $timetable = $this->getScheduledTasksTimeTableMapper()->fetchAll(['scheduling_task_id' => $scheduled_task_id]);
        foreach ($timetable->getCurrentItems() as $item){
            $item = Entity::asArray($item);
            $times = explode(":", $time);
            $nextDTM = new \DateTime($item['next_dtm']);
            $nextDTM->setTime($times[0], $times[1]);
            $item['next_dtm'] = date(self::SCHEDULED_TIMETABLE_TIMEFORMAT, $nextDTM->getTimestamp());
            $this->getScheduledTasksTimeTableMapper()->update($item['id'], $item);
        }

        return $this->fetch($scheduled_task_id);
    }

    /**
     * Включение/отключение назначенного задания
     * @param $scheduled_task_id
     * @param $turn
     * @return Entity|ApiProblem
     */
    public function turnScheduled($scheduled_task_id, $turn)
    {
        if(!in_array($turn, self::TURNS)){
            return new ApiProblem(400, "`turn` должно соответствовать одному из значений " . implode("," , self::TURNS));
        }

        $scheduledTask =  Entity::asArray($this->getTableMapper()->fetch($scheduled_task_id));
        $scheduledTask['state'] = ($turn == "on")? "ACTIVE" : "PAUSED";
        $this->getTableMapper()->update($scheduled_task_id, $scheduledTask);

        return $this->fetch($scheduled_task_id);
    }

    protected function getScheduledTasksDevGrpIdField(){
        return $this->getScheduledTasksDevGrpTableMapper()->getIdFieldName();
    }

    /**
     * @return \plate\EntitySupport\TableGatewayMapper
     */
    protected function getScheduledTasksDevGrpTableMapper(){
        return $this->getITableService()->getTableMapperByKey(Scheduled_tasks_dev_grpResource::class);
    }

    protected function getDevicesTableName(){
        return $this->getDevicesTableMapper()->getTable()->table;
    }

    protected function getDevicesIdFieldName(){
        return $this->getDevicesTableMapper()->getIdFieldName();
    }

    /**
     * @return \plate\EntitySupport\TableGatewayMapper
     */
    protected function getDevicesTableMapper(){
        return $this->getITableService()->getTableMapperByKey(DevicesResource::class);
    }

    protected function getGroupsTableName()
    {
        return $this->getGroupsTableMapper()->getTable()->table;
    }

    protected function getGroupsIdFieldName()
    {
        return $this->getGroupsTableMapper()->getIdFieldName();
    }

    /**
     * @return \plate\EntitySupport\TableGatewayMapper
     */
    protected function getGroupsTableMapper(){
        return $this->getITableService()->getTableMapperByKey(GroupsResource::class);
    }


    protected function getDev2GrpTableName()
    {
        return $this->getDev2grpTableMapper()->getTable()->table;
    }

    /**
     * @return \plate\EntitySupport\TableGatewayMapper
     */
    protected function getDev2grpTableMapper(){
        return $this->getITableService()->getTableMapperByKey(Dev2grpResource::class);
    }

    protected function getScheduledTasksTimeTableName(){
        return $this->getScheduledTasksTimeTableMapper()->getTable()->table;
    }

    /**
     * @return \plate\EntitySupport\TableGatewayMapper
     */
    protected function getScheduledTasksTimeTableMapper(){
        return $this->getITableService()->getTableMapperByKey(Scheduled_tasks_timetableResource::class);
    }

    protected function getAclMapper(){
        return $this->getITableService()->getTableMapperByKey(DevicesAclResource::class);
    }

    /**
     * @return EntitiesUtils
     */
    public function getEntitiesUtils()
    {
        return $this->entitiesUtils;
    }

    /**
     * @param EntitiesUtils $entitiesUtils
     */
    public function setEntitiesUtils($entitiesUtils)
    {
        $this->entitiesUtils = $entitiesUtils;
    }

    /**
     * Предоставить права на назначенное задание с id = $id текущему пользователю
     * @param $id
     */
    protected function addRightsToScheduledTask($id)
    {
        if(!$this->getAuthUtils()->checkAdminPrivileges()) {
            $scheduledTaskAcl = [
                'client_id' => $this->getAuthUtils()->getClientId(),
                'scheduled_task_id' => $id
            ];

            $this->getAclMapper()->create($scheduledTaskAcl);
        }
    }

}