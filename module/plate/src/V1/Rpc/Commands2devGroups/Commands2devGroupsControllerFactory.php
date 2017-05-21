<?php
namespace plate\V1\Rpc\Commands2devGroups;

use Interop\Container\ContainerInterface;
use plate\V1\Rest\Devices\DevicesService;

class Commands2devGroupsControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Commands2devGroupsController($this->getDevicesService($container));
    }

    protected function getDevicesService(ContainerInterface $container){
        return $container->get(DevicesService::class);
    }
}
