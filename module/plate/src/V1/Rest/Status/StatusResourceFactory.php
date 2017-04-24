<?php
namespace plate\V1\Rest\Status;


use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;

class StatusResourceFactory extends ResourceFactory
{
    public function __invoke($services)
    {
        $tableGateway = $this->getTableGateway($services, "statuslib");
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $halEntityProperties = $this->getZfHalEntityProperties("plate\\V1\\Rest\\Status\\Controller");
        $tableGatewayMapper->setHalEntityProperties($halEntityProperties);

        return new StatusResource(
            $tableGatewayMapper
        );
    }
}
