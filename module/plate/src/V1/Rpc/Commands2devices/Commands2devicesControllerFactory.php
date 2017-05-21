<?php
namespace plate\V1\Rpc\Commands2devices;

use Interop\Container\ContainerInterface;
use plate\V1\Rest\Devices\DevicesEntity;
use plate\V1\Rest\Devices\DevicesResource;
use plate\V1\Rest\Devices\DevicesService;

class Commands2devicesControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $controller = new Commands2devicesController($this->getDevicesService($container));
        return $controller;
    }

    protected function getDevicesService(ContainerInterface $container){
        return $container->get(DevicesService::class);
    }
}
