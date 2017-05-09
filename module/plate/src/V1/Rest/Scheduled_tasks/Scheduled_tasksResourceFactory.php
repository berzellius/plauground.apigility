<?php
namespace plate\V1\Rest\Scheduled_tasks;

class Scheduled_tasksResourceFactory
{
    public function __invoke($services)
    {
        return new Scheduled_tasksResource();
    }
}
