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

    protected $scheduledTasksService;

    /**
     * Scheduled_tasksResource constructor.
     * @param TableGatewayMapper $tableGatewayMapper
     * @param TableGatewayMapper $userAccessListMapper
     * @param $devicesTableGatewayMapper
     * @param $groupsTableGatewayMapper
     * @param $dev2grpTableGatewayMapper
     * @param ScheduledTasksService $scheduledTasksService
     */
    public function __construct(
        $tableGatewayMapper,
        $userAccessListMapper,
        $devicesTableGatewayMapper,
        $groupsTableGatewayMapper,
        $dev2grpTableGatewayMapper,
        ScheduledTasksService $scheduledTasksService
    )
    {
        parent::__construct($tableGatewayMapper, $userAccessListMapper);
        $this->setDevicesTableGatewayMapper($devicesTableGatewayMapper);
        $this->setGroupsTableGatewayMapper($groupsTableGatewayMapper);
        $this->setDev2grpTableGatewayMapper($dev2grpTableGatewayMapper);
        $this->setScheduledTasksService($scheduledTasksService);
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $retrievedData = $this->retrieveData($data);
        return $this->getScheduledTasksService()->create($data, $retrievedData);
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return $this->getScheduledTasksService()->delete($id);
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->getScheduledTasksService()->fetch($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->getScheduledTasksService()->fetchAll($params);
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

        foreach($data as $k => $v){
            if($v == null)
                unset($data[$k]);
        }

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
        return $this->getMapper()->update($id, $data);
    }

    /**
     * @return ScheduledTasksService
     */
    public function getScheduledTasksService()
    {
        return $this->scheduledTasksService;
    }

    /**
     * @param ScheduledTasksService $scheduledTasksService
     */
    public function setScheduledTasksService($scheduledTasksService)
    {
        $this->scheduledTasksService = $scheduledTasksService;
    }

    protected function checkPrivileges($type, $id)
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
                ["id", "name", "period_type", "state", "command"],
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
