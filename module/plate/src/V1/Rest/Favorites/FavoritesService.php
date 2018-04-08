<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 31.05.2017
 * Time: 20:42
 */

namespace plate\V1\Rest\Favorites;


use plate\EntityServicesSupport\EntityService;
use plate\EntitySupport\Collection;
use plate\EntitySupport\Entity;
use plate\V1\Rest\Devices\DevicesResource;
use plate\V1\Rest\DevicesAcl\UserAccessUtilsForServices;
use plate\V1\Rest\Groups\GroupsResource;
use plate\V1\Rest\Scheduled_tasks\Scheduled_tasksEntity;
use plate\V1\Rest\Scheduled_tasks\Scheduled_tasksResource;
use plate\V1\Rest\Scheduled_tasks_dev_grp\Scheduled_tasks_dev_grpResource;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Join;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use ZF\Apigility\Documentation\Api;
use ZF\ApiProblem\ApiProblem;
use Zend\Paginator\Paginator;

class FavoritesService extends EntityService
{
    use UserAccessUtilsForServices;

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @param  mixed $retrievedData
     * @return mixed|ApiProblem
     */
    public function create($data, $retrievedData)
    {
        $type = $retrievedData['entity_type'];
        if(!$this->checkPrivileges($retrievedData)){
            return $this->notAllowed();
        }

        if(!$this->getAuthUtils()->checkAdminPrivileges()){
            $retrievedData['user'] = $this->getAuthUtils()->getClientId();
        }

        switch ($type){
            case "DEVICE":
                if(!isset($retrievedData['id_device'])){
                    return new ApiProblem(403, "for 'DEVICE' record you must set id_device");
                }

                if(isset($retrievedData['id_group']) || isset($retrievedData['id_scheduled_task'])){
                    return new ApiProblem(403, "for 'DEVICE' record id_group or id_scheduled_task cant be set");
                }

                $exists = $this->fetchAll(
                    [
                        'entity_type' => $retrievedData['entity_type'],
                        'id_device' => $retrievedData['id_device'],
                        'user' => $retrievedData['user']
                    ]
                );
                if ($exists->getCurrentItemCount() > 0){
                    return new ApiProblem(403, "Device#" . $retrievedData['id_device'] . " is already in favorites!");
                }

                break;
            case "GROUP":
                if(!isset($retrievedData['id_group'])){
                    return new ApiProblem(403, "for 'GROUP' record you must set id_group");
                }

                if(isset($retrievedData['id_device']) || isset($retrievedData['id_scheduled_task'])){
                    return new ApiProblem(403, "for 'GROUP' record id_device or id_scheduled_task cant be set");
                }

                $exists = $this->fetchAll(
                    [
                        'entity_type' => $retrievedData['entity_type'],
                        'id_group' => $retrievedData['id_group'],
                        'user' => $retrievedData['user']
                    ]
                );
                if ($exists->getCurrentItemCount() > 0){
                    return new ApiProblem(403, "Group#" . $retrievedData['id_group'] . " is already in favorites!");
                }

                break;
            case "SCHEDULED":
                if(!isset($retrievedData['id_scheduled_task'])){
                    return new ApiProblem(403, "for 'SCHEDULED' record you must set id_device");
                }

                if(isset($retrievedData['id_group']) || isset($retrievedData['id_device'])){
                    return new ApiProblem(403, "for 'SCHEDULED' record id_group or id_device cant be set");
                }

                $exists = $this->fetchAll(
                    [
                        'entity_type' => $retrievedData['entity_type'],
                        'id_scheduled_task' => $retrievedData['id_scheduled_task'],
                        'user' => $retrievedData['user']
                    ]
                );
                if ($exists->getCurrentItemCount() > 0){
                    return new ApiProblem(403, "Scheduled#" . $retrievedData['id_scheduled_task'] . " is already in favorites!");
                }

                break;
        }


        return $this->getTableMapper()->create($retrievedData);
    }

    public function delete($id)
    {
        $entity = $this->getTableMapper()->fetch($id);
        if(!$this->checkPrivileges($entity)){
            return $this->notAllowed();
        }

        return $this->getTableMapper()->delete($id);
    }

    protected function checkPrivileges($data)
    {
        if($this->getAuthUtils()->checkAdminPrivileges())
            return true;

        if($data instanceof Entity){
            $data = Entity::asArray($data);
        }

        $type = isset($data['entity_type'])? $data['entity_type'] : false;
        if(!$type)
            return false;

        $params = [];
        switch ($type){
            case "GROUP":
                if(!isset($data['id_group']))
                    return false;

                $params = [
                    "grp_id" => $data['id_group'],
                    "client_id" => $this->getAuthUtils()->getClientId()
                ];
                break;
            case "DEVICE":
                if(!isset($data['id_device']))
                    return false;

                $params = [
                    "device_id" => $data['id_device'],
                    "client_id" => $this->getAuthUtils()->getClientId()
                ];
                break;
            case "SCHEDULED":
                if(!isset($data['id_scheduled_task']))
                    return false;

                /*$scheduledTask = $this->getScheduledTasksMapper()->fetch($data['id_scheduled_task']);
                $scheduledTask = Entity::asArray($scheduledTask);
                if(Scheduled_tasksEntity::getEntityDevGrpType($scheduledTask) == "GROUP"){
                    $params = [
                        "grp_id" => $scheduledTask['id_group'],
                        "client_id" => $this->getAuthUtils()->getClientId()
                    ];
                }

                if(Scheduled_tasksEntity::getEntityDevGrpType($scheduledTask) == "DEVICE"){
                    $params = [
                        "device_id" => $scheduledTask['id_device'],
                        "client_id" => $this->getAuthUtils()->getClientId()
                    ];
                }*/
                $params = [
                    "scheduled_task_id" => $data['id_scheduled_task'],
                    "client_id" => $this->getAuthUtils()->getClientId()
                ];
                break;
            default:
                return false;
        }
        return $this->checkPrivilegesByFilter($params);
    }

    public function deleteByEntityTypeAndId($entity_type, $entity_id)
    {
        $data = array(
            'entity_type' => $entity_type,
            'user' => $this->getAuthUtils()->getClientId()
        );

        switch ($entity_type){
            case "GROUP":
                $data['id_group'] = $entity_id;
                break;

            case "DEVICE":
                $data['id_device'] = $entity_id;
                break;

            case "SCHEDULED_TASK":
                $data['id_scheduled_task'] = $entity_id;
                break;

            default:
                return $this->notAllowed();
        }

        if(!$this->checkPrivileges($data)){
            return $this->notAllowed();
        }

        $found = $this->getTableMapper()->fetchAll($data);
        $foundItems = $found->getCurrentItems();

        if($found->getCurrentItemCount() == 0)
            return new ApiProblem(404, "record not found!");

        $toDelete = $foundItems[0];
        return $this->delete($toDelete['id']);
    }

    protected function getScheduledTasksMapper(){
        return $this->getITableService()->getTableMapperByKey(Scheduled_tasksResource::class);
    }

    public function fetchAll($params)
    {
        return $this->getTableMapper()->fetchAll($params);
    }

    /**
     * Получить избранное пользователя
     * @return array
     */
    public function fetchAllFavorites(){
        $client_id = $this->getAuthUtils()->getClientId();

        $devicesTable = $this->getDevicesTableName();
        $devicesIdField = $this->getDevicesIdFieldName();

        $groupsTable = $this->getGroupsTableName();
        $groupsIdField = $this->getGroupsIdFieldName();

        $scheduledTasksTable = $this->getScheduledTasksTableName();
        $scheduledTasksIdField = $this->getScheduledTasksIdFieldName();

        $table = $this->getTableName();
        $idField = $this->getIdFieldName();

        $stdgTableName = $this->getScheduledTasks_dev_grpTableName();

        $select = new Select();
        $select
            ->from(array("d" => $devicesTable))
            ->columns(
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
                    'device.last_command' => 'last_command',
                    'scheduled.stamps' => new Expression("
                        (
                            select
                            group_concat(`special_stamp`)
                            from scheduled_tasks_timetable
                            where scheduled_tasks_timetable.scheduling_task_id = `st`.id
                        )
                    "),
                        /*new Expression("
                        (
                            select time(
                                substring_index(
                                    group_concat(
                                        cast(`begin_dtm` as CHAR) ORDER BY `id`), ',', 1
                                    )
                                )
                            from scheduled_tasks_timetable
                            where scheduled_tasks_timetable.scheduling_task_id = `st`.id
                        )
                        ")*/
                ]
            )
            ->join(
                array("f" => $table),
                "d." . $devicesIdField . " = f.id_device",
                [
                    'favorite.id' => 'id',
                    'favorite.entity_type' => 'entity_type',
                ],
                Join::JOIN_RIGHT
            )
            ->join(
                array("g" => $groupsTable),
                "g." . $groupsIdField . " = f.id_group",
                [
                    'group.id' => 'id',
                    'group.name' => 'name',
                    'group.last_command' => 'last_command'
                ],
                Join::JOIN_LEFT
            )
            ->join(
                array("st" => $scheduledTasksTable),
                "st." . $scheduledTasksIdField . " = f.id_scheduled_task",
                [
                    'scheduled.id' => 'id',
                    'scheduled.state' => 'state',
                    'scheduled.command' => 'command',
                    'scheduled.period_type' => 'period_type',
                    'scheduled.name' => 'name',
                    'scheduled.time' => 'common_time'
                ],
                Join::JOIN_LEFT
            )
            ->join(
                ['stdg' => $stdgTableName],
                "stdg.scheduled_task_id = st." . $this->getIdFieldName(),
                [],
                Join::JOIN_LEFT
            )
            ->join(
                ['sd' => $devicesTable],
                "stdg.id_device = sd." . $devicesIdField,
                [
                    'scheduled.device.id' => 'id',
                    'scheduled.device.mac' => 'mac',
                    'scheduled.device.ip' => 'ip',
                    'scheduled.device.channel' => 'channel',
                    'scheduled.device.description' => 'description',
                    'scheduled.device.room_id' => 'room_id',
                    'scheduled.device.type' => 'type',
                    'scheduled.device.max_amp' => 'max_amp',
                    'scheduled.device.connection_type' => 'connection_type',
                    'scheduled.device.last_command' => 'last_command'
                ],
                Join::JOIN_LEFT
            )
            ->join(
                ["sg" => $groupsTable],
                "stdg.id_group = sg." . $groupsIdField,
                [
                    'scheduled.group.id' => 'id',
                    'scheduled.group.name' => 'name',
                    'scheduled.group.last_command' => 'last_command'
                ],
                Join::JOIN_LEFT
            )
            ->where("f.user = '" . $client_id . "'")
            ->where(
                "(d.id IS NOT NULL OR
                 g.id IS NOT NULL OR
                 st.id IS NOT NULL)"
            )
            ->order(
                "f.entity_type"
            )
        ;

        $adapter = new Adapter(
            $this->getTableMapper()->getTable()->getAdapter()->getDriver(),
            $this->getTableMapper()->getTable()->getAdapter()->getPlatform()
        );

        $dbSelect = new DbSelect($select, $adapter);

        return $dbSelect->getItems(0, 300);
    }

    protected function getDevicesIdFieldName(){
        return $this->getITableService()->getTableIdFieldName(DevicesResource::class);
    }

    protected function getDevicesTableName(){
        return $this->getITableService()->getTableNameByKey(DevicesResource::class);
    }

    protected function getGroupsTableName(){
        return $this->getITableService()->getTableNameByKey(GroupsResource::class);
    }

    protected function getGroupsIdFieldName(){
        return $this->getITableService()->getTableIdFieldName(GroupsResource::class);
    }

    protected function getScheduledTasksTableName(){
        return $this->getITableService()->getTableNameByKey(Scheduled_tasksResource::class);
    }

    protected function getScheduledTasksIdFieldName(){
        return $this->getITableService()->getTableIdFieldName(Scheduled_tasksResource::class);
    }

    protected function getScheduledTasks_dev_grpTableName(){
        return $this->getITableService()->getTableNameByKey(Scheduled_tasks_dev_grpResource::class);
    }
}