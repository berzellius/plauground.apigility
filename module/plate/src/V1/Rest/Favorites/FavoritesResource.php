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
        // todo RPC удаления по типу и id привязанной сущности
        return $this->getFavoritesService()->delete($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->getFavoritesService()->fetchAll($params);
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
