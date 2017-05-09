<?php
namespace plate\V1\Rest\Application_clients;

use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;

class Application_clientsResourceFactory extends ResourceFactory
{
    public function __invoke($services)
    {
        $tableGateway = $this->getTableGateway($services, "application_clients");
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $halEntityProperties = $this->getZfHalEntityProperties("plate\\V1\\Rest\\Application_clients\\Controller");
        $tableGatewayMapper->setHalEntityProperties($halEntityProperties);

        return new Application_clientsResource(
            $tableGatewayMapper
        );
    }
}
