<?php
namespace plate\V1\Rpc\FavoritesRpc;

use Interop\Container\ContainerInterface;
use plate\EntityServicesSupport\EntitiesUtils;
use plate\EntityServicesSupport\EntitiesUtilsFactory;
use plate\V1\Rest\Favorites\FavoritesService;

class FavoritesRpcControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $controller = new FavoritesRpcController($container->get(FavoritesService::class));
        $controller->setEntitiesUtils($this->getEntitiesUtils($container));
        return $controller;
    }


    /**
     * @param ContainerInterface $container
     * @return EntitiesUtils
     */
    protected function getEntitiesUtils(ContainerInterface $container){
        return $container->get(EntitiesUtils::class);
    }
}
