<?php
namespace plate\V1\Rest\Groups;

use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;

class GroupsResourceFactory extends ResourceFactory
{
    public function __invoke($services)
    {
        $tableGateway = $this->getTableGateway($services, "groups");
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $halEntityProperties = $this->getZfHalEntityProperties("plate\\V1\\Rest\\Groups\\Controller");
        $tableGatewayMapper->setHalEntityProperties($halEntityProperties);

        $aclTableGateway = $this->getTableGateway($services, "devices_acl");
        $aclTableGatewayMapper = new TableGatewayMapper($aclTableGateway);

        $dev2grpTableGateway = $this->getTableGateway($services, "dev2grp");
        $dev2grpTableGatewayMapper = new TableGatewayMapper($dev2grpTableGateway);

        $devicesTableGateway = $this->getTableGateway($services, "devices");
        $devicesTableGatewayMapper = new TableGatewayMapper($devicesTableGateway);

        return new GroupsResource(
            $tableGatewayMapper, $aclTableGatewayMapper, $dev2grpTableGatewayMapper, $devicesTableGatewayMapper
        );
    }
}
