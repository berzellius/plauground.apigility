<?php
namespace plate\V1\Rest\Scheduled_tasks;

use plate\EntitySupport\CheckPrivilegesAndDataRetrievingResource;
use plate\EntitySupport\Collection;
use plate\EntitySupport\TableGatewayMapper;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use ZF\ApiProblem\ApiProblem;

class Scheduled_tasksResource extends CheckPrivilegesAndDataRetrievingResource
{

    protected $userAccessListMapper;

    /**
     * Scheduled_tasksResource constructor.
     * @param TableGatewayMapper $mapper
     * @param TableGatewayMapper $userAccessListMapper
     */
    public function __construct(TableGatewayMapper $mapper, TableGatewayMapper $userAccessListMapper)
    {
        parent::__construct($mapper);
        $this->userAccessListMapper = $userAccessListMapper;
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
                    "group_id" => $id,
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

    /**
     * @return TableGatewayMapper
     */
    public function getUserAccessListMapper()
    {
        return $this->userAccessListMapper;
    }

    /**
     * @param TableGatewayMapper $userAccessListMapper
     */
    public function setUserAccessListMapper($userAccessListMapper)
    {
        $this->userAccessListMapper = $userAccessListMapper;
    }
}
