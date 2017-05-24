<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 24.05.2017
 * Time: 21:50
 */

namespace plate\V1\Rest\Groups;


use plate\EntityServicesSupport\EntityService;
use plate\EntitySupport\Collection;
use plate\V1\Rest\Dev2grp\Dev2grpResource;
use plate\V1\Rest\Devices\DevicesResource;
use plate\V1\Rest\DevicesAcl\DevicesAclResource;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use ZF\ApiProblem\ApiProblem;

class GroupsService extends EntityService
{

    /**
     * Create a resource.
     * Обычному пользователю автоматически назначет доступ на созданную группу
     *
     * @param  mixed $data
     * @param $retrievedData
     * @return mixed|ApiProblem
     */
    public function create($data, $retrievedData)
    {
        $cresult = $this->getTableMapper()->create($retrievedData);
        $newGrpId = $cresult->id;

        // даем доступ на созданную группу
        if(!$this->getAuthUtils()->checkAdminPrivileges()) {
            $this->getUserAccessListMapper()->create(
                [
                    "grp_id" => $newGrpId,
                    "client_id" => $this->getAuthUtils()->getClientId()
                ]
            );
        }

        return $cresult;
    }

    /**
     * Delete a resource.
     * Если к группе имеет доступ более чем 1 пользователь,
     * то удалить ее может только админ
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        if($this->getAuthUtils()->checkAdminPrivileges()){
            return $this->getTableMapper()->delete($id);
        }

        $aclDataOwnedCount = $this->getUserAccessListMapper()->fetchAll([
            "grp_id" => $id,
            "client_id" => $this->getAuthUtils()->getClientId()
        ])
            ->getCurrentItemCount();

        if($aclDataOwnedCount === 0){
            return new ApiProblem(403,"you have not access to this group");
        }

        $aclDataNotOwnedCount = $this->getUserAccessListMapper()->fetchAll([
            "grp_id" => $id,
            "client_id<=>" => $this->getAuthUtils()->getClientId()
        ]);

        if($aclDataNotOwnedCount > 0){
            $users = [];
            foreach ($aclDataNotOwnedCount as $user) {
                $users[] = $user->client_id;
            }
            return new ApiProblem(
                403,
                "cant delete: not only you have access to this group -> users: " . implode(", ", $users)
            );
        }

        return $this->getTableMapper()->delete($id);
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $params = [
            "grp_id" => $id,
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
     * Получить список групп. Для обычного пользователя
     * будут получены только группы, к которым предоставлен доступ
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        if(isset($params['room_id'])){
            // особый случай - получить группы устройств по комнате
            $select = $this->getGroupsByRoomIdSelector($params['room_id']);
            $dbSelect = new DbSelect($select, $this->getAdapter());
            return new Collection($dbSelect);
        }

        if($this->getAuthUtils()->checkAdminPrivileges()){
            return $this->getTableMapper()->fetchAll($params);
        }

        $select = $this->getGroupsBySelector([]);
        $dbSelect = new DbSelect($select, $this->getAdapter());
        return new Collection($dbSelect);
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @param  mixed $retrievedData
     * @return mixed|ApiProblem
     */
    public function update($id, $data, $retrievedData)
    {
        $params = [
            "grp_id" => $id,
            "client_id" => $this->getAuthUtils()->getClientId()
        ];

        if(
            !$this->getAuthUtils()->checkAdminPrivileges() &&
            $this->getUserAccessListMapper()->fetchAll($params)->getCurrentItemCount() == 0
        ){
            return $this->notAllowed();
        }
        return $this->getTableMapper()->update($id, $retrievedData);
    }


    /**
     * Patch entity
     * @param $id
     * @param $data
     * @param $retrievedData
     * @return mixed|ApiProblem
     */
    public function patch($id, $data, $retrievedData)
    {
        foreach($retrievedData as $k => $v){
            if($v == null)
                unset($retrievedData[$k]);
        }

        return $this->update($id, $data, $retrievedData);
    }

    /**
     * Возвращает Zend\Db\Sql\Select из тадлицы групп устройств с заданным фильтром $params
     * для обычных пользователей возвращает только те объекты, к которым есть разрешение в acl
     *
     * @param $params
     * @return Select
     */
    protected function getGroupsBySelector($params){
        $groupsTableName = $this->getTableMapper()->getTable()->table;
        $idFieldName = $this->getTableMapper()->getIdFieldName();

        if($this->getAuthUtils()->checkAdminPrivileges()) {
            // админ
            $select = new Select();
            $select
                ->from($groupsTableName);

            foreach ($params as $pname => $pvalue) {
                $select->
                where(
                    $groupsTableName . "." . $pname . " = '" . $pvalue . "'"
                );
            }

            return $select;
        }
        else{
            // обычный пользователь - groups join devices_acl
            $clientId =  $this->getAuthUtils()->getClientId();
            $devicesACLTableName = $this->getUserAccessListMapper()->getTable()->table;

            $select = new Select();
            $select
                ->from($devicesACLTableName)
                ->join(
                    $groupsTableName,
                    $groupsTableName . "." . $idFieldName .
                    " = " .
                    $devicesACLTableName . ".grp_id"
                )
                ->columns([])
                ->where(
                    $devicesACLTableName . ".client_id = '$clientId'"
                );

            foreach($params as $pname => $pvalue) {
                $select->where(
                    $groupsTableName . "." . $pname . " = '" . $pvalue . "'"
                );
            }

            return $select;
        }
    }

    protected function getGroupsByRoomIdSelector($room_id)
    {
        $groupsTableName = $this->getTableMapper()->getTable()->table;
        $aclTableName = $this->getUserAccessListMapper()->getTable()->table;
        $dev2grpTableName = $this->getDev2GrpMapper()->getTable()->table;
        $devicesTableName = $this->getDevicesMapper()->getTable()->table;
        $idFieldName = $this->getTableMapper()->getIdFieldName();

        $select = new Select();
        $select->from($groupsTableName)
            ->join(
                $dev2grpTableName,
                $dev2grpTableName . ".group_id = " . $groupsTableName . "." . $idFieldName,
                []
            )
            ->join(
                $devicesTableName,
                $devicesTableName . ".id = " . $dev2grpTableName . ".device_id",
                []
            );

        if($this->getAuthUtils()->checkAdminPrivileges()){

            $select
                ->where($devicesTableName . ".room_id = '" . $room_id . "'")
                ->group($groupsTableName . ".id");


            return $select;
        }


        $select
            ->join(
                $aclTableName,
                $aclTableName . ".grp_id = " . $groupsTableName . "." . $idFieldName,
                []
            )
            ->where($devicesTableName . ".room_id = '" . $room_id . "'")
            ->where($aclTableName . ".client_id = '" . $this->getAuthUtils()->getClientId() . "'")
            ->group($groupsTableName . "." . $idFieldName);

        return $select;
    }


    protected function getUserAccessListMapper(){
        return $this->getITableService()->getTableMapperByKey(DevicesAclResource::class);
    }

    protected function getUserAccessListMapperTableName(){
        $mapper = $this->getUserAccessListMapper();
        return $mapper->getTable()->table;
    }

    protected function getDev2GrpMapper(){
        return $this->getITableService()->getTableMapperByKey(Dev2grpResource::class);
    }

    protected function getDev2GrpTableName(){
        $mapper = $this->getDev2GrpMapper();
        return $mapper->getTable()->table;
    }

    protected function getDevicesMapper(){
        return $this->getITableService()->getTableMapperByKey(DevicesResource::class);
    }

    protected function getDevicesTableName(){
        $mapper = $this->getDevicesMapper();
        return $mapper->getTable()->table;
    }
}