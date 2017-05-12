<?php
namespace plate\V1\Rest\Application_clients;

use plate\EntitySupport\CheckPrivilegesAndDataRetrievingResource;
use ZF\ApiProblem\ApiProblem;

class Application_clientsResource extends CheckPrivilegesAndDataRetrievingResource
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
        if(!$this->checkAdminPrivileges())
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
        if(!$this->checkAdminPrivileges())
            return $this->notAllowed();

        return $this->getMapper()->fetch($id);
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
        if(!$this->checkAdminPrivileges())
            return $this->notAllowed();

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
        if(!$this->checkAdminPrivileges())
            return $this->notAllowed();


        $data = $this->retrieveData($data);
        return $this->getMapper()->update($id, $data);
    }
}
