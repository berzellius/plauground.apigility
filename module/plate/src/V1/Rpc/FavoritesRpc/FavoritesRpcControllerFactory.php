<?php
namespace plate\V1\Rpc\FavoritesRpc;

use plate\V1\Rest\Entities\EntitiesService;
use plate\V1\Rest\EntitiesUserContext\EntitiesUserContextService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class FavoritesRpcControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        try {
            $entitiesService = $container->get(EntitiesService::class);
            $entitiesUserContextService = $container->get(EntitiesUserContextService::class);

        } catch (NotFoundExceptionInterface $e) {
        } catch (ContainerExceptionInterface $e) {
        }

        $controller = new FavoritesRpcController();
        $controller->setEntitiesService($entitiesService);
        $controller->setEntitiesUserContextService($entitiesUserContextService);

        return $controller;
    }
}
