<?php
namespace plate\V1\Rpc\Commands2devGroups;

use Interop\Container\ContainerInterface;
use plate\V1\Rest\Devices\DevicesService;
use plate\V1\Rest\Groups\GroupsService;

class Commands2devGroupsControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Commands2devGroupsController(
            $this->getDevicesService($container),
            $this->getGroupsService($container)
        );
    }

    protected function getDevicesService(ContainerInterface $container){
        return $container->get(DevicesService::class);
    }

    protected function getGroupsService(ContainerInterface $container){
        return $container->get(GroupsService::class);
    }
}
