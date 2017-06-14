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
use plate\EntityServicesSupport\EntitiesUtils;
use plate\EntityServicesSupport\GetITableService;
use plate\V1\Rest\Devices\DevicesService;
use plate\V1\Rest\Groups\GroupsService;

class ScheduledTasksServiceFactory
{
    use GetITableService,
        GetAuthUtils;

    public function __invoke(ContainerInterface $services)
    {
        $iTableService = $this->getITableService($services);
        $mapper = $iTableService->getTableMapperByKey(Scheduled_tasksResource::class);
        $authUtils = $this->getAuthUtils($services);

        $service = new ScheduledTasksService($authUtils, $iTableService, $mapper);
        $service->setEntitiesUtils($services->get(EntitiesUtils::class));
        $service->setDevicesService($services->get(DevicesService::class));
        $service->setGroupsService($services->get(GroupsService::class));
        return $service;
    }
}