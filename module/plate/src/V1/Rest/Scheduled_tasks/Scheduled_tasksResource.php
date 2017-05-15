<?php
namespace plate\V1\Rest\Scheduled_tasks;

use plate\EntitySupport\CheckPrivilegesAndDataRetrievingResource;
use plate\EntitySupport\CheckPrivilegesAndDataRetrievingResourceWithAcl;
use plate\EntitySupport\Collection;
use plate\EntitySupport\TableGatewayMapper;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\TableIdentifier;
use Zend\Paginator\Adapter\DbSelect;
use ZF\ApiProblem\ApiProblem;

class Scheduled_tasksResource extends CheckPrivilegesAndDataRetrievingResourceWithAcl
{

    protected   $devicesTableGateway,
                $dev2grpTableGatewayMapper,
                $groupsTableGateway;

    /**
     * Scheduled_tasksResource constructor.
     * @param $userAccessListMapper
     */
    public function __construct(
        $tableGatewayMapper,
        $userAccessListMapper,
        $devicesTableGatewayMapper,
        $groupsTableGatewayMapper,
        $dev2grpTableGatewayMapper
    )
    {
        parent::__construct($tableGatewayMapper, $userAccessListMapper);
        $this->setDevicesTableGatewayMapper($devicesTableGatewayMapper);
        $this->setGroupsTableGatewayMapper($groupsTableGatewayMapper);
        $this->setDev2grpTableGatewayMapper($dev2grpTableGatewayMapper);
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $data = $this->retrieveData($data);
        $check = $this->checkData($data);
        if($check instanceof ApiProblem)
            return $check;

        if(!$this->checkPrivilegesByData($data))
            return $this->notAllowed();

        return $this->getMapper()->create($data);
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        if(!$this->checkPrivilegesById($id))
            return $this->notAllowed();

        return $this->getMapper()->delete($id);
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        if(!$this->checkPrivilegesById($id))
            return $this->notAllowed();

        return $this->getMapper()->fetch($id);
    }

    /**
     * Fetch all or a subset of resources
     * Для администраторов выбираются все записи
     * Для остальных - те записи, которым соответствуют разрешения в devices_acl для группы или конкретного устройства
     * для авторизованного пользователя
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {

        if(isset($params['room_id'])){
            // особый случай - выбор назначенных заданий по room_id
            $select = $this->getScheduledTasksByRoomIdSelector($params['room_id']);

            $adapter = new Adapter(
                $this->getMapper()->getTable()->getAdapter()->getDriver(),
                $this->getMapper()->getTable()->getAdapter()->getPlatform()
            );

            $dbSelect = new DbSelect($select, $adapter);

            return new Collection($dbSelect);
        }
        $clientId =  $this->getLoggedInClientId();

        if($this->checkAdminPrivileges()){
            return $this->getMapper()->fetchAll($params);
        }

        $scheduledTasksTableName = $this->getMapper()->getTable()->table;
        $devicesACLTableName = $this->getUserAccessListMapper()->getTable()->table;

        $select = new Select();
        $select
            ->from(array('da1' => $devicesACLTableName))
            ->join(
                $scheduledTasksTableName,
                $scheduledTasksTableName . ".id_device = da1.device_id",
                array("id", "state", "id_device", "id_group", "grp_dev_type", "period_type", "command", "name"),
                Select::JOIN_RIGHT
            )
            ->join(
                array('da2' => $devicesACLTableName),
                $scheduledTasksTableName . ".id_group = da2.grp_id",
                array(),
                Select::JOIN_LEFT
            )
            ->columns([])
            ->where("da1.client_id = '" . $clientId . "'")
            ->where("da2.client_id = '" . $clientId . "'", Predicate::OP_OR);

        $adapter = new Adapter(
            $this->getMapper()->getTable()->getAdapter()->getDriver(),
            $this->getMapper()->getTable()->getAdapter()->getPlatform()
        );

        $dbSelect = new DbSelect($select, $adapter);

        return new Collection($dbSelect);
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        $data = $this->retrieveData($data);
        $check = $this->checkData($data);
        if($check instanceof ApiProblem)
            return $check;

        foreach($data as $k => $v){
            if($v == null)
                unset($data[$k]);
        }

        if(isset($data['id_device'])){
            $data['id_group'] = null;
        }

        if(isset($data['id_group'])){
            $data['id_device'] = null;
        }


        if(!$this->checkPrivilegesByData($data))
            return $this->notAllowed();

        if(!$this->checkPrivilegesById($id))
            return $this->notAllowed();


        return $this->getMapper()->update($id, $data);
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
        $data = $this->retrieveData($data);
        $check = $this->checkData($data);
        if($check instanceof ApiProblem)
            return $check;

        if(!$this->checkPrivilegesByData($data))
            return $this->notAllowed();

        if(!$this->checkPrivilegesById($id))
            return $this->notAllowed();

        return $this->getMapper()->update($id, $data);
    }

    private function checkData($data)
    {
        $dev = isset($data['id_device'])? $data['id_device'] : false;
        $grp = isset($data['id_group'])? $data['id_group'] : false;
        $type = isset($data['grp_dev_type'])? $data['grp_dev_type'] : false;

        if(!$type){
            return new ApiProblem(400, "'grp_dev_type' must be set");
        }

        if($type == "DEVICE" && $grp){
            return new ApiProblem(400, "only 'device_id' must be set for 'DEVICE' type");
        }

        if($type == "GROUP" && $dev){
            return new ApiProblem(400, "only 'group_id' must be set for 'GROUP' type");
        }

        if(!($dev xor $grp)){
            return new ApiProblem(400, "Both 'device_id' and 'group_id' cant be set: ");
        }
        return true;
    }

    private function checkPrivilegesByData($data)
    {
        if($this->checkAdminPrivileges())
            return true;

        $dev = isset($data['id_device'])? $data['id_device'] : false;
        $grp = isset($data['id_group'])? $data['id_group'] : false;
        $type = isset($data['grp_dev_type'])? $data['grp_dev_type'] : false;

        if($type == "DEVICE"){
            if(!$dev)
                return false;

            return $this->checkPrivileges($type, $dev);
        }

        if($type == "GROUP"){
            if(!$grp)
                return false;

            return $this->checkPrivileges($type, $grp);
        }

        return false;
    }

    private function checkPrivilegesById($id)
    {
        if($this->checkAdminPrivileges())
            return true;

        $data = Scheduled_tasksEntity::asArray($this->getMapper()->fetch($id));
        return $this->checkPrivilegesByData($data);
    }

    private function checkPrivileges($type, $id)
    {
        if($this->checkAdminPrivileges())
            return true;

        $params = [];
        switch ($type){
            case "GROUP":
                $params = [
                    "grp_id" => $id,
                    "client_id" => $this->getLoggedInClientId()
                ];
                break;
            case "DEVICE":
                $params = [
                    "device_id" => $id,
                    "client_id" => $this->getLoggedInClientId()
                ];
                break;
            default:
                return false;
        }
        //die(json_encode($params));
        return ($this->getUserAccessListMapper()->fetchAll($params)->getCurrentItemCount() !== 0);
    }

    protected function getScheduledTasksByRoomIdSelector($room_id)
    {
        $scheduledTasksTableName = $this->getMapper()->getTable()->table;
        $platform = $this->getMapper()->getTable()->getAdapter()->getPlatform();

        $devicesSelect = $this->getDevicesByRoomIdSelect($room_id);
        $groupsSelect = $this->getGroupsByRoomIdSelect($room_id);


        $select = new Select();
        $select
            ->from(array('dt' => $devicesSelect))
            ->join(
                $scheduledTasksTableName,
                $scheduledTasksTableName . ".id_device" . " = dt.id",
                ["id", "grp_dev_type", "id_group", "id_device", "name", "period_type", "state", "command"],
                Select::JOIN_RIGHT
            )
            ->join(
                array('grt' => $groupsSelect),
                $scheduledTasksTableName . ".id_group" . " = grt.id",
                [],
                Select::JOIN_LEFT
            )
            ->columns([])
            ->where("grt.id is not null")
            ->where("dt.id is not null", Predicate::OP_OR);

        return $select;
    }

    protected function getDevicesByRoomIdSelect($room_id){
        $aclTableName = $this->getUserAccessListMapper()->getTable()->table;
        $devicesTableName = $this->getDevicesTableGateway()->getTable()->table;

        $select = new Select();
        $select
            ->from($devicesTableName);

        if(!$this->checkAdminPrivileges()){
            $select->join(
                $aclTableName,
                $aclTableName . ".device_id = " . $devicesTableName . ".id",
                []
            );
        }

        $select->where($devicesTableName . ".room_id = " . $room_id);

        if(!$this->checkAdminPrivileges()){
            $select
                ->where($aclTableName . ".client_id = '" . $this->getLoggedInClientId() . "'");
        }

        $select->group($devicesTableName . ".id");

        return $select;
    }

    protected function getGroupsByRoomIdSelect($room_id){
        $aclTableName = $this->getUserAccessListMapper()->getTable()->table;
        $devicesTableName = $this->getDevicesTableGateway()->getTable()->table;
        $groupsTableName = $this->getGroupsTableGateway()->getTable()->table;
        $dev2grpTableName = $this->getDev2grpTableGatewayMapper()->getTable()->table;

        $select = new Select();
        $select
            ->from($groupsTableName)
            ->join(
                $dev2grpTableName,
                $dev2grpTableName . ".group_id = " . $groupsTableName . ".id",
                []
            )
            ->join(
                $devicesTableName,
                $dev2grpTableName . ".device_id = " . $devicesTableName . ".id",
                []
            )
            //->columns([])
        ;

        if(!$this->checkAdminPrivileges()){
            $select->join(
                $aclTableName,
                $aclTableName . ".grp_id = " . $groupsTableName . ".id",
                []
            );
        }

        $select->where($devicesTableName . ".room_id = " . $room_id);

        if(!$this->checkAdminPrivileges()){
            $select
                ->where($aclTableName . ".client_id = '" . $this->getLoggedInClientId() . "'");
        }

        $select->group($groupsTableName . ".id");
        return $select;
    }

    /**
     * @return TableGatewayMapper
     */
    public function getDevicesTableGateway()
    {
        return $this->devicesTableGateway;
    }

    /**
     * @param TableGatewayMapper $devicesTableGateway
     */
    public function setDevicesTableGatewayMapper($devicesTableGateway)
    {
        $this->devicesTableGateway = $devicesTableGateway;
    }

    /**
     * @return TableGatewayMapper
     */
    public function getGroupsTableGateway()
    {
        return $this->groupsTableGateway;
    }

    /**
     * @param TableGatewayMapper $groupsTableGateway
     */
    public function setGroupsTableGatewayMapper($groupsTableGateway)
    {
        $this->groupsTableGateway = $groupsTableGateway;
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



}
