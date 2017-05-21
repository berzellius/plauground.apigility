<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2017
 * Time: 20:42
 */

namespace plate\V1\Rest\DevicesAcl;


use Interop\Container\ContainerInterface;
use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;

class DevicesAclResourceFactory extends ResourceFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $tableGateway = $this->getTableGateway($services, "devices_acl");
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $this->getITableService($services)->registerTableMapper(DevicesAclResource::class, $tableGatewayMapper);

        return new DevicesAclResource($tableGatewayMapper);
    }
}