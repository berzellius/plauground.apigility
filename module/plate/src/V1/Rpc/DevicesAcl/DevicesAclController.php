<?php
namespace plate\V1\Rpc\DevicesAcl;

use plate\EntitySupport\Entity;
use plate\V1\Rest\DevicesAcl\DevicesAclService;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class DevicesAclController extends AbstractActionController
{

    protected $devicesAclService;

    /**
     * DevicesAclController constructor.
     * @param DevicesAclService $devicesAclService
     */
    public function __construct(DevicesAclService $devicesAclService)
    {
        $this->setDevicesAclService($devicesAclService);
    }

    public function devicesAclAction()
    {
        $data = $this->bodyParams();

        $deviceID = $data['device_id'];
        $client_id = $data['client_id'];

        $res = $this->getDevicesAclService()->addRightsToDevice($client_id, $deviceID);

        return new ViewModel(
            Entity::asArray($res)
        );
    }

    /**
     * @return DevicesAclService
     */
    public function getDevicesAclService()
    {
        return $this->devicesAclService;
    }

    /**
     * @param DevicesAclService $devicesAclService
     */
    public function setDevicesAclService($devicesAclService)
    {
        $this->devicesAclService = $devicesAclService;
    }
}
