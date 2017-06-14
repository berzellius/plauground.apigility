<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2017
 * Time: 15:53
 */
namespace plate\V1\Rest\Devices;
use plate\EntityServicesSupport\EntityService;
use plate\EntitySupport\Collection;
use plate\EntitySupport\Entity;
use plate\V1\Rest\Dev2grp\Dev2grpResource;
use plate\V1\Rest\DevicesAcl\DevicesAclResource;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use ZF\ApiProblem\ApiProblem;

class DevicesService extends EntityService{

    public function sampleMethod(){
        return 'ok' . $this->getITableService()->getTableNameByKey('devices') . '/' . $this->getAuthUtils()->getClientId();
    }

    /**
     * Получить данные устройства по id
     * @param $id
     * @return array|\ArrayObject|null|Entity|ApiProblem
     */
    public function fetch($id)
    {
        $params = [
            "device_id" => $id,
            "client_id" => $this->getAuthUtils()->getClientId()
        ];

        if(
            !$this->getAuthUtils()->checkAdminPrivileges() &&
            $this->getUserAccessListMapper()->fetchAll($params)->getCurrentItemCount() == 0
        ){
            return $this->notAllowed();
        }

        return $this->getTableMapper()->fetch($id);
    }

    /**
     * Получение списка устройств:
     * 1) по grp_id - получение устройств в группе;
     *      для получения списка необходимо явно предоставленное право пользователя нагруппу устройств в таблице списка доступа devices_acl,
     *      либо права администратора
     * 2) по room_id - получение списка устройств в комнате; (если задан grp_id, room_id игнорируется)
     *      возвращает  полный список устройств в комнате (для аккаунта адмнистратора)
     *      возвращает список устройств в комнате, которым явно предосталено разрешение в таблице devices_acl
     *3) без параметров - список всех доступных устройств в системе
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        if(isset($params['grp_id'])){
            $params = [
                "grp_id" => $params['grp_id'],
                "client_id" => $this->getAuthUtils()->getClientId()
            ];

            if(
                !$this->getAuthUtils()->checkAdminPrivileges() &&
                $this->getUserAccessListMapper()->fetchAll($params)->getCurrentItemCount() == 0
            ){
                return new ApiProblem(403, "Empty list!");
            }

            $select = $this->getDevicesSelectorByGroup($params['grp_id']);
            $dbSelect = new DbSelect($select, $this->getAdapter());
            return new Collection($dbSelect);
        }

        if($this->getAuthUtils()->checkAdminPrivileges()){
            return $this->getTableMapper()->fetchAll($params);
        }

        $select = $this->getDevicesBySelector(
            isset($params['room_id'])? ['room_id' => $params['room_id']] : []
        );

        $dbSelect = new DbSelect($select, $this->getAdapter());

        return new Collection($dbSelect);
    }

    public function create($data, $retrievedData)
    {
        if(!$this->getAuthUtils()->checkAdminPrivileges())
            return $this->notAllowed();

        return $this->getTableMapper()->create($retrievedData);

    }

    public function delete($id)
    {
        if(!$this->getAuthUtils()->checkAdminPrivileges())
            return $this->notAllowed();

        return $this->getTableMapper()->delete($id);
    }

    public function update($id, $data, $retrievedData)
    {
        if(!$this->getAuthUtils()->checkAdminPrivileges())
            return $this->notAllowed();

        return $this->getTableMapper()->update($id, $retrievedData);
    }

    public function patch($id, $data, $retrievedData)
    {
        foreach($retrievedData as $k => $v){
            if($v == null)
                unset($retrievedData[$k]);
        }

        if($this->getAuthUtils()->checkAdminPrivileges()){
            return $this->getTableMapper()->update($id, $retrievedData);
        }

        $params = [
            "device_id" => $id,
            "client_id" => $this->getAuthUtils()->getClientId()
        ];

        if($this->getUserAccessListMapper()->fetchAll($params)->getCurrentItemCount() == 0){
            return $this->notAllowed();
        }

        if(
            isset($retrievedData['last_command']) && count($retrievedData) === 1
        ){
            return $this->getTableMapper()->update($id, $retrievedData);
        }

        return $this->notAllowed();
    }

    public function addToDevicesAcl($user, $deviceId){
        $data = [
            "client_id" => $user,
            "device_id" => $deviceId
        ];

        $this->getUserAccessListMapper()->create($data);
    }

    public function checkRightsToDevice($client_id, $device_id){
        $params = [
            'client_id' => $client_id,
            'device_id' => $device_id
        ];

        return (
            $this->getAuthUtils()->checkAdminPrivileges() ||
            $this->getUserAccessListMapper()->fetchAll($params)->getCurrentItemCount() != 0
        );
    }

    /**
     * Возвращает Zend\Db\Sql\Select из таблицы устройств с привязкой к группе устройств @grpId
     * для обычных пользователей возвращает только те объекты, к которым есть разрешение в acl
     * @param $grpId
     * @return Select
     */
    protected function getDevicesSelectorByGroup($grpId){
        $select = new Select();
        $select
            ->from($this->getDevices2GroupMapperTableName())
            ->join(
                $this->getTableName(),
                $this->getTableName() . ". " . $this->getIdFieldName() . " = " . $this->getDevices2GroupMapperTableName() . ".device_id"
            )
            ->join(
                $this->getUserAccessListMapperTableName(),
                $this->getUserAccessListMapperTableName() . ".device_id = " . $this->getTableName() . ".id",
                []
            )
            ->columns([])
            ->where($this->getDevices2GroupMapperTableName() . ".group_id = " . $grpId)
            ->where($this->getUserAccessListMapperTableName() . ".client_id = '" . $this->getAuthUtils()->getClientId() . "'", Predicate::OP_AND);

        return $select;
    }

    /**
     * Возвращает Zend\Db\Sql\Select из тадлицы устройств с заданным фильтром @params
     * для обычных пользователей возвращает только те объекты, к которым есть разрешение в acl
     *
     * @param $params
     * @return Select
     */
    protected function getDevicesBySelector($params){
        if($this->getAuthUtils()->checkAdminPrivileges()) {
            $select = new Select();
            $select
                ->from($this->getTableName());

            foreach ($params as $pname => $pvalue) {
                $select->
                where(
                    $this->getTableName() . "." . $pname . " = '" . $pvalue . "'"
                );
            }

            return $select;
        }
        else{
            $clientId =  $this->getAuthUtils()->getClientId();
            $devicesACLTableName = $this->getUserAccessListMapperTableName();

            $select = new Select();
            $select
                ->from($devicesACLTableName)
                ->join(
                    $this->getTableName(),
                    $this->getTableName() . "." . $this->getIdFieldName() .
                    " = " .
                    $devicesACLTableName . ".device_id"
                )
                ->columns([])
                ->where(
                    $devicesACLTableName . ".client_id = '$clientId'"
                );

            foreach($params as $pname => $pvalue) {
                $select->where(
                    $this->getTableName() . "." . $pname . " = '" . $pvalue . "'"
                );
            }

            return $select;
        }
    }

    protected function getUserAccessListMapper(){
        return $this->getITableService()->getTableMapperByKey(DevicesAclResource::class);
    }

    protected function getUserAccessListMapperTableName(){
        $mapper = $this->getUserAccessListMapper();
        return $mapper->getTable()->table;
    }

    protected function getDevices2GroupMapper(){
        return $this->getITableService()->getTableMapperByKey(Dev2grpResource::class);
    }

    protected function getDevices2GroupMapperTableName(){
        $mapper = $this->getDevices2GroupMapper();
        return $mapper->getTable()->table;
    }
}