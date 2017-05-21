<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2017
 * Time: 15:58
 */

namespace plate\V1\Rest\Devices;


use Interop\Container\ContainerInterface;
use plate\Auth\GetAuthUtils;
use plate\EntityServicesSupport\GetITableService;

class DevicesServiceFactory
{
    use GetITableService,
        GetAuthUtils;

    public function __invoke(ContainerInterface $services)
    {
        $iTableService = $this->getITableService($services);
        $mapper = $iTableService->getTableMapperByKey(DevicesResource::class);
        $authUtils = $this->getAuthUtils($services);

        return new DevicesService($authUtils, $iTableService, $mapper);
    }
}