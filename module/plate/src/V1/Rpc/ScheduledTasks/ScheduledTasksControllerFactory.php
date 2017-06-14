<?php
namespace plate\V1\Rpc\ScheduledTasks;

use Interop\Container\ContainerInterface;
use plate\V1\Rest\Scheduled_tasks\ScheduledTasksService;

class ScheduledTasksControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {

        /** @var ScheduledTasksService $scheduledTasksService */
        $scheduledTasksService = $container->get(ScheduledTasksService::class);
        return new ScheduledTasksController($scheduledTasksService);
    }
}
