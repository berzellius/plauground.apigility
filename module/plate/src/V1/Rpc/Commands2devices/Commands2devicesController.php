<?php
namespace plate\V1\Rpc\Commands2devices;

use plate\EntitySupport\Entity;
use plate\EntitySupport\SimpleResult;
use plate\V1\Rest\Devices\DevicesEntity;
use plate\V1\Rest\Devices\DevicesResource;
use plate\V1\Rest\Devices\DevicesService;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblem;
use ZF\ContentNegotiation\ViewModel;

class Commands2devicesController extends AbstractActionController
{
    protected $devicesService;

    /**
     * Commands2devicesController constructor.
     * @param DevicesService $devicesService
     */
    public function __construct($devicesService)
    {
        $this->setDevicesService($devicesService);
    }


    public function commands2devicesAction()
    {
        $data =  $this->bodyParams();
        $deviceId = $data['device'];
        $command = $data['command'];
        $device = $this->getDevicesService()->fetch($deviceId);

        if($device instanceof ApiProblem){
            return new ViewModel(
                $device->toArray()
            );
        }

        $device['last_command'] = $command;

        $updatedDevice = $this->getDevicesService()->patch($deviceId, $device, ['last_command' => $command]);

        if($updatedDevice instanceof ApiProblem){
            return new ViewModel(
                $updatedDevice->toArray()
            );
        }


        return new ViewModel(
            array_merge(
                (new SimpleResult("ok", "command sent"))->toArray(),
                [
                    'device' => Entity::asArray($updatedDevice)
                ]
                )
        );
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
