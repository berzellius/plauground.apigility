<?php
namespace plate\V1\Rest\Oauth_users_control;

use plate\EntitySupport\MapperInterface;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class Oauth_users_controlResource extends AbstractResourceListener
{
    protected $mapper;

    const ADMIN_SCOPE_NAME = 'main';

    public function __construct(MapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    private function checkAdminPrivileges(){
        $identity = $this->getIdentity()->getAuthenticationIdentity();
        return $identity['scope'] == self::ADMIN_SCOPE_NAME;
    }

    private function notAllowed(){
        return new ApiProblem(401, 'Method not allowed! ');
    }

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

        return $this->mapper->fetchAll();
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
        if(!$this->checkAdminPrivileges())
            return $this->notAllowed();

        return $this->mapper->update($id, $data);
    }
}
