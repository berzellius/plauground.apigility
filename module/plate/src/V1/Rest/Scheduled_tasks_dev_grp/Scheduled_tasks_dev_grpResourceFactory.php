<?php

namespace plate\V1\Rest\Scheduled_tasks_dev_grp;

use Interop\Container\ContainerInterface;
use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 12.06.2017
 * Time: 10:30
 */
class Scheduled_tasks_dev_grpResourceFactory extends ResourceFactory
{
    public function __invoke(ContainerInterface $container)
    {

        $tableGateway = $this->getTableGateway($container, "scheduled_tasks_dev_grp");
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $this->getITableService($container)->registerTableMapper(Scheduled_tasks_dev_grpResource::class, $tableGatewayMapper);

        return new Scheduled_tasks_dev_grpResource($tableGatewayMapper);
    }
}