<?php
namespace plate\V1\Rpc\ScheduledTasks;

class ScheduledTasksControllerFactory
{
    public function __invoke($controllers)
    {
        return new ScheduledTasksController();
    }
}
