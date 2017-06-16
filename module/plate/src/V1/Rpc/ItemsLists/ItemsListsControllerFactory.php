<?php
namespace plate\V1\Rpc\ItemsLists;

use Interop\Container\ContainerInterface;
use plate\V1\Rest\Devices\DevicesService;
use plate\V1\Rest\Groups\GroupsService;
use plate\V1\Rest\Scheduled_tasks\ScheduledTasksService;

class ItemsListsControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $controller = new ItemsListsController(
            $container->get(DevicesService::class),
            $container->get(GroupsService::class),
            $container->get(ScheduledTasksService::class)
        );
        return $controller;
    }
}
