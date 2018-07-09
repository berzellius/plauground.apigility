<?php
namespace plate\V1\Rpc\EntitiesRpc;

use Interop\Container\ContainerInterface;
use plate\V1\Rest\Entities\EntitiesService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class EntitiesRpcControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        try {
            $entitiesService = $container->get(EntitiesService::class);
        } catch (NotFoundExceptionInterface $e) {
        } catch (ContainerExceptionInterface $e) {
        }


        $controller = new EntitiesRpcController();
        $controller->setEntitiesService($entitiesService);
        return $controller;
    }
}
