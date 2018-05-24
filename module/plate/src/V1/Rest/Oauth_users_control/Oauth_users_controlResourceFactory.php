<?php
namespace plate\V1\Rest\Oauth_users_control;

use plate\EntitySupport\resource\ResourceFactory;
use plate\EntitySupport\tableGateway\TableGatewayMapper;

class Oauth_users_controlResourceFactory extends ResourceFactory
{
    public function __invoke($services)
    {
        $tableGateway = $this->getTableGateway($services, "oauth_users_control");
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $halEntityProperties = $this->getZfHalEntityProperties("plate\\V1\\Rest\\Oauth_users_control\\Controller");
        $tableGatewayMapper->setHalEntityProperties($halEntityProperties);

        return new Oauth_users_controlResource(
            $tableGatewayMapper
        );
    }
}
