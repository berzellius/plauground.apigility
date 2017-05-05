<?php
namespace plate\V1\Rest\Rooms;

use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;

/**
 * Class RoomsResourceFactory
 *  Фабричный метод получения экземпляра RoomsResource с назначением маппера к таблице "rooms"
 * @package plate\V1\Rest\Rooms
 */
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
