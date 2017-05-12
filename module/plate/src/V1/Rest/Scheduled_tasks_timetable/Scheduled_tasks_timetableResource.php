<?php
namespace plate\V1\Rest\Scheduled_tasks_timetable;

use plate\EntitySupport\CheckPrivilegesAndDataRetrievingResource;
use plate\EntitySupport\TableGatewayMapper;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class Scheduled_tasks_timetableResource extends CheckPrivilegesAndDataRetrievingResource
{
    protected $userAccessListMapper;
    protected $scheduled_tasksMapper;

    /**
     * Scheduled_tasks_timetableResource constructor.
     * @param TableGatewayMapper $mapper
     * @param TableGatewayMapper $scheduled_tasksMapper
     * @param TableGatewayMapper $userAccessListMapper
     */
    public function __construct(TableGatewayMapper $mapper, TableGatewayMapper $scheduled_tasksMapper, TableGatewayMapper $userAccessListMapper)
    {
        parent::__construct($mapper);
        $this->userAccessListMapper = $userAccessListMapper;
        $this->scheduled_tasksMapper = $scheduled_tasksMapper;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        if(!$this->checkPrivilegesByData($data))
            return $this->notAllowed();

        $this->retrieveData($data);

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
     * Запрос без параметров - только для администраторов
     * с параметром 'scheduling_task_id' - для авторизованных пользователей
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        if(isset($params['scheduling_task_id'])) {
            $task = $this->getScheduledTasksMapper()->fetch($params['scheduling_task_id']);

            if(!$this->checkPrivilegesByScheduledTask($task))
                return $this->notAllowed();

            return $this->getMapper()->fetchAll($params);
        }

        if(!$this->checkAdminPrivileges())
            return $this->notAllowed();

        return $this->getMapper()->fetchAll($params);
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
        if(!$this->checkPrivilegesById($id))
            return $this->notAllowed();

        if(!$this->checkPrivilegesByData($data))
            return $this->notAllowed();

        foreach($data as $k => $v){
            if($v == null)
                unset($data[$k]);
        }

        $data = $this->retrieveData($data);
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
        if(!$this->checkPrivilegesById($id))
            return $this->notAllowed();

        if(!$this->checkPrivilegesByData($data))
            return $this->notAllowed();

        $data = $this->retrieveData($data);
        return $this->getMapper()->update($id, $data);
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

    /**
     * @return TableGatewayMapper
     */
    public function getScheduledTasksMapper()
    {
        return $this->scheduled_tasksMapper;
    }

    /**
     * @param TableGatewayMapper $scheduled_tasksMapper
     */
    public function setScheduledTasksMapper($scheduled_tasksMapper)
    {
        $this->scheduled_tasksMapper = $scheduled_tasksMapper;
    }

    private function checkPrivilegesById($id){
        $data = $this->getMapper()->fetch($id);

        return $this->checkPrivilegesByData($data);
    }

    private function checkPrivilegesByScheduledTask($scheduled_task){
        $data = Scheduled_tasks_timetableEntity::asArray($scheduled_task);

        $dev = isset($data['id_device'])? $data['id_device'] : false;
        $grp = isset($data['id_group'])? $data['id_group'] : false;
        $type = isset($data['grp_dev_type'])? $data['grp_dev_type'] : false;

        if($type == "DEVICE"){
            if(!$dev)
                return false;

            return $this->checkAclPrivileges($type, $dev);
        }

        if($type == "GROUP"){
            if(!$grp)
                return false;

            return $this->checkAclPrivileges($type, $grp);
        }

        return false;

    }

    private function checkPrivilegesByData($data)
    {
        $data = Scheduled_tasks_timetableEntity::asArray($data);
        $scheduling_task_id = isset($data['scheduling_task_id'])? $data['scheduling_task_id'] : false;

        if(!$scheduling_task_id)
            return false;

        $scheduled_task = $this->getScheduledTasksMapper()->fetch($scheduling_task_id);
        if($scheduled_task == null){
            return false;
        }


        return $this->checkPrivilegesByScheduledTask($scheduled_task);
    }

    private function checkAclPrivileges($type, $id)
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
}
