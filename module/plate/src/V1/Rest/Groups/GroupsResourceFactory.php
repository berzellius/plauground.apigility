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


        return new GroupsResource(
            $tableGatewayMapper, $aclTableGatewayMapper
        );
    }
}
