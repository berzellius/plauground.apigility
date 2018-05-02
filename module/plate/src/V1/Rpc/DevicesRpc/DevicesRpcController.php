<?php
namespace plate\V1\Rpc\DevicesRpc;

use plate\V1\Rest\Devices\DevicesService;
use Zend\Mvc\Controller\AbstractActionController;

class DevicesRpcController extends AbstractActionController
{
    // TODO если не пригодится, удалить сервис, пока в нем смысла нет

    /**
     * @var DevicesService $devicesService
     */
    protected $devicesService;

    /**
     * DevicesRpcController constructor.
     * @param DevicesService $devicesService
     */
    public function __construct($devicesService)
    {
        $this->setDevicesService($devicesService);
    }

    public function devicesRpcAction()
    {
       //print_r($this->getDevicesService()-);


        print_r($this->getDevicesService()->fetchAll([])->getCurrentItems());
        die('22');
        //return $this->getDevicesService()->fetchAll([])->getCurrentItems();
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
