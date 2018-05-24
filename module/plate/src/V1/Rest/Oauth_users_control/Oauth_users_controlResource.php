<?php
namespace plate\V1\Rest\Oauth_users_control;

use plate\EntitySupport\resource\CheckPrivilegesAndDataRetrievingResource;
use plate\EntitySupport\resource\DataRetrievingResource;
use plate\EntitySupport\resource\MapperInterface;
use plate\EntitySupport\traits\ResourceRetrievingData;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class Oauth_users_controlResource extends CheckPrivilegesAndDataRetrievingResource
{

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        if(!$this->checkAdminPrivileges())
            return $this->notAllowed();

        $data = $this->retrieveData($data);

        return $this->mapper->create($data);
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        if(!$this->checkAdminPrivileges())
            return $this->notAllowed();

        return $this->mapper->delete($id);
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        if(!$this->checkAdminPrivileges())
            return $this->notAllowed();

        return $this->mapper->fetch($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        if(!$this->checkAdminPrivileges())
            return $this->notAllowed();

        return $this->mapper->fetchAll($params);
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
        if(!$this->checkAdminPrivileges())
            return $this->notAllowed();

        $data = $this->retrieveData($data);
        return $this->mapper->update($id, $data);
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
        if(!$this->checkAdminPrivileges())
            return $this->notAllowed();

        $data = $this->retrieveData($data);

        foreach($data as $k => $v){
            if($v == null)
                unset($data[$k]);
        }

        return $this->mapper->update($id, $data);
    }
}
