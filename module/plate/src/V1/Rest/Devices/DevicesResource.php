<?php
namespace plate\V1\Rest\Devices;

use plate\EntitySupport\CheckPrivilegesAndDataRetrievingResource;
use plate\EntitySupport\CheckPrivilegesAndDataRetrievingResourceWithAcl;
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

class DevicesResource extends CheckPrivilegesAndDataRetrievingResourceWithAcl
{
    protected $dev2grpTableGatewayMapper;

    /**
     * DevicesResource constructor.
     * @param $dev2grpTableGatewayMapper
     */
    public function __construct($tableGatewayMapper, $aclTableGatewayMapper, $dev2grpTableGatewayMapper)
    {
        parent::__construct($tableGatewayMapper, $aclTableGatewayMapper);
        $this->dev2grpTableGatewayMapper = $dev2grpTableGatewayMapper;
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

        if(
            !$this->checkAdminPrivileges() &&
            $this->getUserAccessListMapper()->fetchAll($params)->getCurrentItemCount() == 0
        ){
            return $this->notAllowed();
        }

        return $this->getMapper()->fetch($id);
    }

    /**
     * Получение списка устройств:
     * 1) по grp_id - получение устройств в группе;
     *      для получения списка необходимо явно предоставленное право пользователя нагруппу устройств в таблице списка доступа devices_acl,
     *      либо права администратора
     * 2) по room_id - получение списка устройств в комнате; (если задан grp_id, room_id игнорируется)
     *      возвращает  полный список устройств в комнате (для аккаунта адмнистратора)
     *      возвращает список устройств в комнате, которым явно предосталено разрешение в таблице devices_acl
     *3) без параметров - список всех доступных устройств в системе
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        if(isset($params['grp_id'])){
            $params = [
                "grp_id" => $params['grp_id'],
                "client_id" => $this->getLoggedInClientId()
            ];

            if(
                !$this->checkAdminPrivileges() &&
                $this->userAccessListMapper->fetchAll($params)->getCurrentItemCount() == 0
            ){
                return new ApiProblem(403, "Empty list!");
            }

            $dev2grpTableName = $this->getDev2grpTableGatewayMapper()->getTable()->table;
            $devicesTableName = $this->getMapper()->getTable()->table;
            $aclTableName = $this->getUserAccessListMapper()->getTable()->table;
            $select = new Select();
            $select
                ->from($dev2grpTableName)
                ->join(
                    $devicesTableName,
                    $devicesTableName . ".id = " . $dev2grpTableName . ".device_id"
                )
                ->join(
                    $aclTableName,
                    $aclTableName . ".device_id = " . $devicesTableName . ".id",
                    []
                )
                ->columns([])
                ->where($dev2grpTableName . ".group_id = " . $params['grp_id'])
                ->where($aclTableName . ".client_id = '" . $this->getLoggedInClientId() . "'", Predicate::OP_AND);

            $adapter = new Adapter(
                $this->getMapper()->getTable()->getAdapter()->getDriver(),
                $this->getMapper()->getTable()->getAdapter()->getPlatform()
            );

            $dbSelect = new DbSelect($select, $adapter);
            return new Collection($dbSelect);
        }

        if($this->checkAdminPrivileges()){
            return $this->getMapper()->fetchAll($params);
        }

        $select = $this->getDevicesBySelector(
            isset($params['room_id'])? ['room_id' => $params['room_id']] : []
        );

        $adapter = new Adapter(
            $this->getMapper()->getTable()->getAdapter()->getDriver(),
            $this->getMapper()->getTable()->getAdapter()->getPlatform()
        );

        $dbSelect = new DbSelect($select, $adapter);

        return new Collection($dbSelect);
    }

    /**
     * Возвращает Zend\Db\Sql\Select из тадлицы устройств с заданным фильтром $params
     * для обычных пользователей возвращает только те объекты, к которым есть разрешение в acl
     *
     * @param $params
     * @return Select
     */
    protected function getDevicesBySelector($params){
        $devicesTableName = $this->getMapper()->getTable()->table;
        $idFieldName = $this->getMapper()->getIdFieldName();

        if($this->checkAdminPrivileges()) {
            $select = new Select();
            $select
                ->from($devicesTableName);

            foreach ($params as $pname => $pvalue) {
                $select->
                where(
                    $devicesTableName . "." . $pname . " = '" . $pvalue . "'"
                );
            }

            return $select;
        }
        else{
            $clientId =  $this->getLoggedInClientId();
            $devicesACLTableName = $this->getUserAccessListMapper()->getTable()->table;

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
                );

            foreach($params as $pname => $pvalue) {
                $select->where(
                    $devicesTableName . "." . $pname . " = '" . $pvalue . "'"
                );
            }

            return $select;
        }
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

    /**
     * @return TableGatewayMapper
     */
    public function getDev2grpTableGatewayMapper()
    {
        return $this->dev2grpTableGatewayMapper;
    }

    /**
     * @param TableGatewayMapper $dev2grpTableGatewayMapper
     */
    public function setDev2grpTableGatewayMapper($dev2grpTableGatewayMapper)
    {
        $this->dev2grpTableGatewayMapper = $dev2grpTableGatewayMapper;
    }


}
