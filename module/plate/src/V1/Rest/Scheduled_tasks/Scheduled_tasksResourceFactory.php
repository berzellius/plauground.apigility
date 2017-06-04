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

        $this->getITableService($services)->registerTableMapper(Scheduled_tasksResource::class, $tableGatewayMapper);

        $aclTableGateway = $this->getTableGateway($services, "devices_acl");
        $aclTableGatewayMapper = new TableGatewayMapper($aclTableGateway);

        $devicesTableGateway = $this->getTableGateway($services, "devices");
        $devicesTableGatewayMapper = new TableGatewayMapper($devicesTableGateway);

        $groupsTableGateway = $this->getTableGateway($services, "groups");
        $groupsTableGatewayMapper = new TableGatewayMapper($groupsTableGateway);

        $dev2grpTableGateway = $this->getTableGateway($services, "dev2grp");
        $dev2grpTableGatewayMapper = new TableGatewayMapper($dev2grpTableGateway);

        return new Scheduled_tasksResource(
            $tableGatewayMapper,
            $aclTableGatewayMapper,
            $devicesTableGatewayMapper,
            $groupsTableGatewayMapper,
            $dev2grpTableGatewayMapper
        );
    }
}
