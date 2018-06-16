<?php
namespace plate\V1\Rpc\EntitiesRpc;

use Interop\Container\ContainerInterface;
use plate\V1\Rest\Entities\EntitiesService;

class EntitiesRpcControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $entitiesService = $container->get(EntitiesService::class);
        return new EntitiesRpcController($entitiesService);
    }
}
