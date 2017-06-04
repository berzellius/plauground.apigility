<?php
namespace plate\V1\Rpc\Devices_acl;

use plate\V1\Rest\Devices\DevicesService;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class Devices_aclController extends AbstractActionController
{
    /**
     * @var DevicesService
     */
    protected $devicesService;

    /**
     * Devices_aclController constructor.
     * @param DevicesService $devicesService
     */
    public function __construct(DevicesService $devicesService)
    {
        $this->setDevicesService($devicesService);
    }

    public function devices_aclAction()
    {
        return new ViewModel(array());

        //return new ViewModel(array("res" => "ok"));
        /*if($this->getRequest()) {
            $data = $this->bodyParams();
            $deviceId = $data['device_id'];
        }*/
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
