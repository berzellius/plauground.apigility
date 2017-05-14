<?php
namespace plate\V1\Rest\Dev2grp;

use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;

class Dev2grpResourceFactory extends ResourceFactory
{
    public function __invoke($services)
    {
        $tableGateway = $this->getTableGateway($services, "dev2grp");
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $halEntityProperties = $this->getZfHalEntityProperties("plate\\V1\\Rest\\Dev2grp\\Controller");
        $tableGatewayMapper->setHalEntityProperties($halEntityProperties);

        $aclTableGateway = $this->getTableGateway($services, "devices_acl");
        $aclTableGatewayMapper = new TableGatewayMapper($aclTableGateway);

        $oauthUsersControlTableGateway = $this->getTableGateway($services, "oauth_users_control");
        $oauthUsersControlTableGatewayMapper = new TableGatewayMapper($oauthUsersControlTableGateway);

        return new Dev2grpResource(
            $tableGatewayMapper, $aclTableGatewayMapper, $oauthUsersControlTableGatewayMapper
        );
    }
}

