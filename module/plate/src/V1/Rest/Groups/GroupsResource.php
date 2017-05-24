<?php
namespace plate\V1\Rest\Groups;

use plate\EntitySupport\CheckPrivilegesAndDataRetrievingResourceWithAcl;
use plate\EntitySupport\DataRetrievingResource;
use plate\EntitySupport\TableGatewayMapper;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use ZF\ApiProblem\ApiProblem;
use plate\EntitySupport\Collection;

class GroupsResource extends DataRetrievingResource
{
    protected $groupsService;

    /**
     * GroupsResource constructor.
     */
    public function __construct(
        TableGatewayMapper $mapper,
        GroupsService $groupsService
    )
    {
        parent::__construct($mapper);
        $this->setGroupsService($groupsService);
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
        $retrievedData = $this->retrieveData($data);
        return $this->getGroupsService()->create($data, $retrievedData);
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
        return $this->getGroupsService()->delete($id);
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->getGroupsService()->fetch($id);
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
        return $this->getGroupsService()->fetchAll($params);
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
        $retrievedData = $this->retrieveData($data);
        return $this->getGroupsService()->update($id, $data, $retrievedData);
    }

    public function patch($id, $data)
    {
        $retrievedData = $this->retrieveData($data);
        return $this->getGroupsService()->patch($id, $data, $retrievedData);
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


}
