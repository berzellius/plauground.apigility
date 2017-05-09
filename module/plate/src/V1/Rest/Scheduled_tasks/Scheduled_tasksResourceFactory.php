<?php
namespace plate\V1\Rest\Scheduled_tasks;

use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;

class Scheduled_tasksResourceFactory extends ResourceFactory
{
    public function __invoke($services)
    {
        $tableGateway = $this->getTableGateway($services, "scheduled_tasks");
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $halEntityProperties = $this->getZfHalEntityProperties("plate\\V1\\Rest\\Scheduled_tasks\\Controller");
        $tableGatewayMapper->setHalEntityProperties($halEntityProperties);

        $aclTableGateway = $this->getTableGateway($services, "devices_acl");
        $aclTableGatewayMapper = new TableGatewayMapper($aclTableGateway);

        return new Scheduled_tasksResource(
            $tableGatewayMapper, $aclTableGatewayMapper
        );
    }
}
