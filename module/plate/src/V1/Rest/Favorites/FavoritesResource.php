<?php
namespace plate\V1\Rest\Favorites;

use plate\EntitySupport\DataRetrievingResource;
use plate\EntitySupport\TableGatewayMapper;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class FavoritesResource extends DataRetrievingResource
{
    /**
     * @var FavoritesService
     */
    protected $favoritesService;

    /**
     * FavoritesResource constructor.
     */
    public function __construct(
        TableGatewayMapper $mapper,
        FavoritesService $service
    )
    {
        parent::__construct($mapper);
        $this->setFavoritesService($service);
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
        return $this->getFavoritesService()->create($data, $retrievedData);
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
        return $this->getFavoritesService()->fetch($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return new ApiProblem(405, 'The GET method has not been defined for collections');
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

    /**
     * @return FavoritesService
     */
    public function getFavoritesService()
    {
        return $this->favoritesService;
    }

    /**
     * @param FavoritesService $favoritesService
     */
    public function setFavoritesService($favoritesService)
    {
        $this->favoritesService = $favoritesService;
    }
}
