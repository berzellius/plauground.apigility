<?php
namespace plate\V1\Rpc\Devices_acl;

use Interop\Container\ContainerInterface;
use plate\V1\Rest\Devices\DevicesService;

class Devices_aclControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var DevicesService $devicesService */
        $devicesService = $container->get(DevicesService::class);
        return new Devices_aclController($devicesService);
    }
}
