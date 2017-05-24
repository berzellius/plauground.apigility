<?php
namespace plate\V1\Rest\Groups;

use Interop\Container\ContainerInterface;
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

        $this->getITableService($services)->registerTableMapper(GroupsResource::class, $tableGatewayMapper);

        return new GroupsResource(
            $tableGatewayMapper, $this->getGroupsService($services)
        );
    }
    /**
     * @param $services
     * @return GroupsService
     */
    protected function getGroupsService(ContainerInterface $services){
        $groupsService =  $services->get(GroupsService::class);
        return $groupsService;
    }

}
