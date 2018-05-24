<?php
namespace plate\V1\Rest\BasicHierarchy;

use plate\EntitySupport\resource\DataRetrievingResource;
use plate\EntitySupport\tableGateway\TableGatewayMapper;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

/**
 * Class BasicHierarchyResource
 * @package plate\V1\Rest\BasicHierarchy
 */
class BasicHierarchyResource extends DataRetrievingResource
{
    /**
     * @var BasicHierarchyService
     */
    protected $basicHierarchyService;

    /**
     * @return BasicHierarchyService
     */
    public function getBasicHierarchyService()
    {
        return $this->basicHierarchyService;
    }

    /**
     * @param BasicHierarchyService $basicHierarchyService
     */
    public function setBasicHierarchyService($basicHierarchyService)
    {
        $this->basicHierarchyService = $basicHierarchyService;
    }

    /**
     * EntitiesResource constructor.
     * @param BasicHierarchyService $basicHierarchyService
     * @param TableGatewayMapper $tableGatewayMapper
     * @internal param BasicHierarchyService $entitiesService
     */
    public function __construct(BasicHierarchyService $basicHierarchyService, TableGatewayMapper $tableGatewayMapper)
    {
        parent::__construct($tableGatewayMapper);
        $this->setBasicHierarchyService($basicHierarchyService);
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->getBasicHierarchyService()->fetchAll($params);
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
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
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
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
