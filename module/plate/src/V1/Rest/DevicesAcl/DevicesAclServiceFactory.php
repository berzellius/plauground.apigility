<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 09.06.2017
 * Time: 21:46
 */

namespace plate\V1\Rest\DevicesAcl;


use Interop\Container\ContainerInterface;
use plate\Auth\GetAuthUtils;
use plate\EntityServicesSupport\GetITableService;
use plate\EntitySupport\ResourceFactory;

class DevicesAclServiceFactory
{
    use GetITableService,
        GetAuthUtils;

    public function __invoke(ContainerInterface $container)
    {
        $iTableService = $this->getITableService($container);
        $mapper = $iTableService->getTableMapperByKey(DevicesAclResource::class);
        $authUtils = $this->getAuthUtils($container);

        return new DevicesAclService($authUtils, $iTableService, $mapper);
    }
}