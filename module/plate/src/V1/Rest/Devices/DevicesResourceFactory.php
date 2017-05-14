<?php
namespace plate\V1\Rest\Devices;

use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;

class DevicesResourceFactory extends ResourceFactory
{
    public function __invoke($services)
    {
        $tableGateway = $this->getTableGateway($services, "devices");
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $halEntityProperties = $this->getZfHalEntityProperties("plate\\V1\\Rest\\Devices\\Controller");
        $tableGatewayMapper->setHalEntityProperties($halEntityProperties);

        $aclTableGateway = $this->getTableGateway($services, "devices_acl");
        $aclTableGatewayMapper = new TableGatewayMapper($aclTableGateway);

        $dev2grpTableGateway = $this->getTableGateway($services, "dev2grp");
        $dev2grpTableGatewayMapper = new TableGatewayMapper($dev2grpTableGateway);

        return new DevicesResource(
            $tableGatewayMapper, $aclTableGatewayMapper, $dev2grpTableGatewayMapper
        );
    }
}
