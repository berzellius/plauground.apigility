<?php
namespace plate\V1\Rest\Devices;

use Foo\Bar\TestClassInBar;
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

class DevicesResource extends DataRetrievingResource
{
    protected $devicesService;

    /**
     * DevicesResource constructor.
     * @param DevicesService $devicesService
     * @param TableGatewayMapper $tableGatewayMapper
     */
    public function __construct($devicesService, $tableGatewayMapper)
    {
        parent::__construct($tableGatewayMapper);
        $this->devicesService = $devicesService;
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

        return $this->getDevicesService()->create($data, $retrievedData);
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return $this->getDevicesService()->delete($id);
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->getDevicesService()->fetch($id);
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
        return $this->getDevicesService()->fetchAll($params);
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
        return $this->getDevicesService()->update($id, $data, $retrievedData);
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
        $retrievedData = $this->retrieveData($data);
        return $this->getDevicesService()->patch($id, $data, $retrievedData);
    }

    /**
     * @return DevicesService
     */
    public function getDevicesService()
    {
        return $this->devicesService;
    }

    /**
     * @param DevicesService $devicesService
     */
    public function setDevicesService($devicesService)
    {
        $this->devicesService = $devicesService;
    }
}
