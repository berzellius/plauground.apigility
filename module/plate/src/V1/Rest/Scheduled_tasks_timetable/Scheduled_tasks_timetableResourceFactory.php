<?php
namespace plate\V1\Rest\Scheduled_tasks_timetable;

use Interop\Container\ContainerInterface;
use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;

class Scheduled_tasks_timetableResourceFactory extends ResourceFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $tableGateway = $this->getTableGateway($services, "scheduled_tasks_timetable");
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $this->getITableService($services)->registerTableMapper(Scheduled_tasks_timetableResource::class, $tableGatewayMapper);

        $scheduled_tasksTableGateway = $this->getTableGateway($services, "scheduled_tasks");
        $scheduled_tasksTableGatewayMapper = new TableGatewayMapper($scheduled_tasksTableGateway);

        $halEntityProperties = $this->getZfHalEntityProperties("plate\\V1\\Rest\\Scheduled_tasks_timetable\\Controller");
        $tableGatewayMapper->setHalEntityProperties($halEntityProperties);

        $aclTableGateway = $this->getTableGateway($services, "devices_acl");
        $aclTableGatewayMapper = new TableGatewayMapper($aclTableGateway);

        return new Scheduled_tasks_timetableResource(
            $tableGatewayMapper, $scheduled_tasksTableGatewayMapper, $aclTableGatewayMapper
        );
    }
}
