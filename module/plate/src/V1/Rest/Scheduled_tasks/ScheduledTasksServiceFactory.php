<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 03.06.2017
 * Time: 20:04
 */

namespace plate\V1\Rest\Scheduled_tasks;

use Interop\Container\ContainerInterface;
use plate\Auth\GetAuthUtils;
use plate\EntityServicesSupport\GetITableService;

class ScheduledTasksServiceFactory
{
    use GetITableService,
        GetAuthUtils;

    public function __invoke(ContainerInterface $services)
    {
        $iTableService = $this->getITableService($services);
        $mapper = $iTableService->getTableMapperByKey(Scheduled_tasksResource::class);
        $authUtils = $this->getAuthUtils($services);

        return new ScheduledTasksService($authUtils, $iTableService, $mapper);
    }
}