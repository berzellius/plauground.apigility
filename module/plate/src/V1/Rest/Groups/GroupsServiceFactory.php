<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 24.05.2017
 * Time: 22:19
 */

namespace plate\V1\Rest\Groups;


use Interop\Container\ContainerInterface;
use plate\Auth\GetAuthUtils;
use plate\EntityServicesSupport\GetITableService;

class GroupsServiceFactory
{
    use GetITableService,
        GetAuthUtils;

    public function __invoke(ContainerInterface $services)
    {
        $iTableService = $this->getITableService($services);
        $mapper = $iTableService->getTableMapperByKey(GroupsResource::class);
        $authUtils = $this->getAuthUtils($services);

        return new GroupsService($authUtils, $iTableService, $mapper);
    }
}