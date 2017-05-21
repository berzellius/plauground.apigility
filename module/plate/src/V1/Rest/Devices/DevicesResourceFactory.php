<?php
namespace plate\V1\Rest\Devices;

use Interop\Container\ContainerInterface;
use plate\EntityServicesSupport\ITableService;
use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;
use plate\V1\Rest\Dev2grp\Dev2grpResource;

class DevicesResourceFactory extends ResourceFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $tableGateway = $this->getTableGateway($services, "devices");
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $halEntityProperties = $this->getZfHalEntityProperties("plate\\V1\\Rest\\Devices\\Controller");
        $tableGatewayMapper->setHalEntityProperties($halEntityProperties);

        $this->getITableService($services)->registerTableMapper(DevicesResource::class, $tableGatewayMapper);

        return new DevicesResource(
            $this->getDevicesService($services),
            $tableGatewayMapper
        );
    }

    /**
     * @param $services
     * @return DevicesService
     */
    protected function getDevicesService(ContainerInterface $services){
        $devicesService =  $services->get(DevicesService::class);
        return $devicesService;
    }
}
