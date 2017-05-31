<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 31.05.2017
 * Time: 20:42
 */

namespace plate\V1\Rest\Favorites;


use Interop\Container\ContainerInterface;
use plate\Auth\GetAuthUtils;
use plate\EntityServicesSupport\GetITableService;

class FactoriesServiceFactory
{
    use GetITableService,
        GetAuthUtils;

    public function __invoke(ContainerInterface $services)
    {
        $iTableService = $this->getITableService($services);
        $mapper = $iTableService->getTableMapperByKey(FavoritesResource::class);
        $authUtils = $this->getAuthUtils($services);

        return new FavoritesService($authUtils, $iTableService, $mapper);
    }
}