<?php
namespace plate\V1\Rest\Groups;

use plate\EntitySupport\CheckPrivilegesAndDataRetrievingResourceWithAcl;
use plate\EntitySupport\TableGatewayMapper;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use ZF\ApiProblem\ApiProblem;
use plate\EntitySupport\Collection;

class GroupsResource extends CheckPrivilegesAndDataRetrievingResourceWithAcl
{
    protected   $dev2grpTableGatewayMapper,
                $devicesTableGatewayMapper;

    /**
     * GroupsResource constructor.
     */
    public function __construct(
        TableGatewayMapper $mapper,
        TableGatewayMapper $userAccessListMapper,
        TableGatewayMapper $dev2grpTableGatewayMapper,
        TableGatewayMapper $devicesTableGatewayMapper)
    {
        parent::__construct($mapper, $userAccessListMapper);
        $this->setDev2grpTableGatewayMapper($dev2grpTableGatewayMapper);
        $this->setDevicesTableGatewayMapper($devicesTableGatewayMapper);
    }


    /**
     * Create a resource.
     * Обычному пользователю автоматически назначет доступ на созданную группу
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $data = $this->retrieveData($data);
        $cresult = $this->getMapper()->create($data);
        $newGrpId = $cresult->id;

        // даем доступ на созданную группу
        if(!$this->checkAdminPrivileges()) {
            $this->getUserAccessListMapper()->create(
                [
                    "grp_id" => $newGrpId,
                    "client_id" => $this->getLoggedInClientId()
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
        if($this->checkAdminPrivileges()){
            return $this->getMapper()->delete($id);
        }

        $aclDataOwnedCount = $this->getUserAccessListMapper()->fetchAll([
                "grp_id" => $id,
                "client_id" => $this->getLoggedInClientId()
            ])
            ->getCurrentItemCount();

        if($aclDataOwnedCount === 0){
            return new ApiProblem(403,"you have not access to this group");
        }

        $aclDataNotOwnedCount = $this->getUserAccessListMapper()->fetchAll([
            "grp_id" => $id,
            "client_id<=>" => $this->getLoggedInClientId()
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

        return $this->getMapper()>$this->delete($id);
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
            "client_id" => $this->getLoggedInClientId()
        ];

        if(
            !$this->checkAdminPrivileges() &&
            $this->getUserAccessListMapper()->fetchAll($params)->getCurrentItemCount() == 0
        ){
            return $this->notAllowed();
        }

        return $this->getMapper()->fetch($id);
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
            $select =$this->getGroupsByRoomIdSelector($params['room_id']);

            $adapter = new Adapter(
                $this->getMapper()->getTable()->getAdapter()->getDriver(),
                $this->getMapper()->getTable()->getAdapter()->getPlatform()
            );

            $dbSelect = new DbSelect($select, $adapter);

            return new Collection($dbSelect);
        }

        if($this->checkAdminPrivileges()){
            return $this->getMapper()->fetchAll($params);
        }

        $select = $this->getGroupsBySelector([]);

        $adapter = new Adapter(
            $this->getMapper()->getTable()->getAdapter()->getDriver(),
            $this->getMapper()->getTable()->getAdapter()->getPlatform()
        );

        $dbSelect = new DbSelect($select, $adapter);

        return new Collection($dbSelect);
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        $params = [
            "grp_id" => $id,
            "client_id" => $this->getLoggedInClientId()
        ];

        if(
            !$this->checkAdminPrivileges() &&
            $this->getUserAccessListMapper()->fetchAll($params)->getCurrentItemCount() == 0
        ){
            return $this->notAllowed();
        }

        $data = $this->retrieveData($data);
        return $this->getMapper()->update($id, $data);
    }

    /**
     * Возвращает Zend\Db\Sql\Select из тадлицы групп устройств с заданным фильтром $params
     * для обычных пользователей возвращает только те объекты, к которым есть разрешение в acl
     *
     * @param $params
     * @return Select
     */
    protected function getGroupsBySelector($params){
        $groupsTableName = $this->getMapper()->getTable()->table;
        $idFieldName = $this->getMapper()->getIdFieldName();

        if($this->checkAdminPrivileges()) {
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
            $clientId =  $this->getLoggedInClientId();
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
        $groupsTableName = $this->getMapper()->getTable()->table;
        $aclTableName = $this->getUserAccessListMapper()->getTable()->table;
        $dev2grpTableName = $this->getDev2grpTableGatewayMapper()->getTable()->table;
        $devicesTableName = $this->getDevicesTableGatewayMapper()->getTable()->table;
        $idFieldName = $this->getMapper()->getIdFieldName();

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

        if($this->checkAdminPrivileges()){

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
            ->where($aclTableName . ".client_id = '" . $this->getLoggedInClientId() . "'")
            ->group($groupsTableName . ".id");

        return $select;
    }

    /**
     * @return TableGatewayMapper
     */
    public function getDev2grpTableGatewayMapper()
    {
        return $this->dev2grpTableGatewayMapper;
    }

    /**
     * @param TableGatewayMapper $dev2grpTableGatewayMapper
     */
    public function setDev2grpTableGatewayMapper($dev2grpTableGatewayMapper)
    {
        $this->dev2grpTableGatewayMapper = $dev2grpTableGatewayMapper;
    }

    /**
     * @return TableGatewayMapper
     */
    public function getDevicesTableGatewayMapper()
    {
        return $this->devicesTableGatewayMapper;
    }

    /**
     * @param TableGatewayMapper $devicesTableGatewayMapper
     */
    public function setDevicesTableGatewayMapper($devicesTableGatewayMapper)
    {
        $this->devicesTableGatewayMapper = $devicesTableGatewayMapper;
    }


}
