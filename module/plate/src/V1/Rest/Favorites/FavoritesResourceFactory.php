<?php
namespace plate\V1\Rest\Favorites;

use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;

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
            $tableGatewayMapper
            //,$this->getGroupsService($services)
        );
    }
}
