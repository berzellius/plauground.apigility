<?php
namespace plate\V1\Rest\Scheduled_tasks_timetable;

class Scheduled_tasks_timetableResourceFactory
{
    public function __invoke($services)
    {
        return new Scheduled_tasks_timetableResource();
    }
}
