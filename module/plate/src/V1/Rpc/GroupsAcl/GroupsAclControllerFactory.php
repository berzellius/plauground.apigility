<?php
namespace plate\V1\Rpc\GroupsAcl;

use Interop\Container\ContainerInterface;
use plate\V1\Rest\DevicesAcl\DevicesAclService;

class GroupsAclControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new GroupsAclController($container->get(DevicesAclService::class));
    }
}
