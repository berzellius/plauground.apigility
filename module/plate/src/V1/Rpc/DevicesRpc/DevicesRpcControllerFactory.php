<?php
namespace plate\V1\Rpc\DevicesRpc;

use Interop\Container\ContainerInterface;
use plate\V1\Rest\Devices\DevicesService;
use plate\V1\Rest\Groups\GroupsService;
use plate\V1\Rest\Scheduled_tasks\ScheduledTasksService;

class DevicesRpcControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /**
         * @var DevicesService $devicesServices
         */
        $devicesServices = $container->get(DevicesService::class);

        $controller = new DevicesRpcController(
            $devicesServices
        );

        return $controller;
    }
}
