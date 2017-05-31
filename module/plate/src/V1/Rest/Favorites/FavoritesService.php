<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 31.05.2017
 * Time: 20:42
 */

namespace plate\V1\Rest\Favorites;


use plate\EntityServicesSupport\EntityService;
use ZF\ApiProblem\ApiProblem;

class FavoritesService extends EntityService
{
    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->getTableMapper()->fetch($id);
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @param  mixed $retrievedData
     * @return mixed|ApiProblem
     */
    public function create($data, $retrievedData)
    {
        return $this->getTableMapper()->create($retrievedData);
    }

}