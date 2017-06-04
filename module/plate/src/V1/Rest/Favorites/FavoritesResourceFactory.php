<?php
namespace plate\V1\Rest\Favorites;

use Interop\Container\ContainerInterface;
use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;
use Zend\View\Helper\Placeholder\Container;

class FavoritesResourceFactory extends ResourceFactory
{
    public function __invoke($services)
    {
        $tableGateway = $this->getTableGateway($services, "favorites");
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $halEntityProperties = $this->getZfHalEntityProperties("plate\\V1\\Rest\\Favorites\\Controller");
        $tableGatewayMapper->setHalEntityProperties($halEntityProperties);

        $this->getITableService($services)->registerTableMapper(FavoritesResource::class, $tableGatewayMapper);

        return new FavoritesResource(
            $tableGatewayMapper,
            $this->getFavoritesService($services)
        );
    }

    /**
     * @param ContainerInterface $services
     * @return FavoritesService
     */
    protected function getFavoritesService(ContainerInterface $services){
        $favoritesService = $services->get(FavoritesService::class);
        return $favoritesService;
    }
}
