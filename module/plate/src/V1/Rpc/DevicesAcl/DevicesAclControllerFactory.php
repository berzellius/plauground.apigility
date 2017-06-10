<?php
namespace plate\V1\Rpc\DevicesAcl;

use Interop\Container\ContainerInterface;
use plate\V1\Rest\DevicesAcl\DevicesAclService;

class DevicesAclControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new DevicesAclController($container->get(DevicesAclService::class));
    }
}
