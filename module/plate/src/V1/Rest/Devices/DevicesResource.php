<?php
namespace plate\V1\Rest\Devices;

use plate\EntitySupport\CheckPrivilegesAndDataRetrievingResource;
use plate\EntitySupport\Collection;
use plate\EntitySupport\DataRetrievingResource;
use plate\EntitySupport\MapperInterface;
use plate\EntitySupport\TableGatewayMapper;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class DevicesResource extends CheckPrivilegesAndDataRetrievingResource
{
    protected $userAccessListMapper;

    /**
     * DevicesResource constructor.
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
        $params = [
            "device_id" => $id,
            "client_id" => $this->getLoggedInClientId()
        ];

        $aclCnt = $this->getUserAccessListMapper()->fetchAll($params)->getCurrentItemCount();

        if($aclCnt == 0){
            return $this->notAllowed();
        }

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
        if($this->checkAdminPrivileges()){
            return $this->getMapper()->fetchAll($params);
        }

        $clientId =  $this->getLoggedInClientId();

        if(isset($params['grp_id'])){
            $params = [
                "grp_id" => $params['grp_id'],
                "client_id" => $this->getLoggedInClientId()
            ];

            $aclCnt = $this->userAccessListMapper->fetchAll($params)->getCurrentItemCount();

            if($aclCnt == 0){
                return new ApiProblem(403, "Empty list!");
            }

            return $this->getMapper()->fetchAll(array('group_id' => $params['grp_id']));
        }

        if(isset($params['room_id'])){
            $params = [
                "room_id" => $params['room_id']
            ];

            $devicesACLTableName = $this->getUserAccessListMapper()->getTable()->table;
            $devicesTableName = $this->getMapper()->getTable()->table;
            $idFieldName = $this->getMapper()->getIdFieldName();

            $select = new Select();
            $select
                ->from($devicesACLTableName)
                ->join(
                    $devicesTableName,
                     $devicesTableName . "." . $idFieldName .
                     " = " .
                     $devicesACLTableName . ".device_id"
                )
                ->columns([])
                ->where(
                    $devicesACLTableName . ".client_id = '$clientId'"
                )
                ->where(
                    $devicesTableName . ".room_id = '" . $params['room_id'] . "'"
                )
            ;

            $adapter = new Adapter(
                $this->getMapper()->getTable()->getAdapter()->getDriver(),
                $this->getMapper()->getTable()->getAdapter()->platform
                );

            $dbSelect = new DbSelect($select, $adapter);

            return new Collection($dbSelect);
        }

        return new ApiProblem(403, "Fetching all devices allowed only by grp_id or room_id!");
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
