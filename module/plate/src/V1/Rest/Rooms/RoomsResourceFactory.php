<?php
namespace plate\V1\Rest\Rooms;

use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;

class RoomsResourceFactory extends ResourceFactory
{
    public function __invoke($services)
    {
        $tableGateway = $this->getTableGateway($services, "rooms");
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $halEntityProperties = $this->getZfHalEntityProperties("plate\\V1\\Rest\\Rooms\\Controller");
        $tableGatewayMapper->setHalEntityProperties($halEntityProperties);

        return new RoomsResource(
            $tableGatewayMapper
        );
    }
}
