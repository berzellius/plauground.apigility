<?php
namespace plate\V1\Rpc\Commands2devGroups;

use plate\EntitySupport\Entity;
use plate\EntitySupport\SimpleResult;
use plate\V1\Rest\Devices\DevicesService;
use plate\V1\Rest\Groups\GroupsService;
use plate\V1\Rest\Groups\GroupsServiceFactory;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblem;
use ZF\ContentNegotiation\ViewModel;

class Commands2devGroupsController extends AbstractActionController
{
    protected   $devicesService,
                $groupsService;

    /**
     * Commands2devGroupsController constructor.
     * @param DevicesService $devicesService
     */
    public function __construct(DevicesService $devicesService, GroupsService $groupsService)
    {
        $this->setDevicesService($devicesService);
        $this->setGroupsService($groupsService);
    }


    public function commands2devGroupsAction()
    {
        $data =  $this->bodyParams();
        $groupId = $data['group'];
        $command = $data['command'];

        $devices = $this->getDevicesService()->fetchAll(['grp_id' => $groupId]);
        //var_dump($devices->getCurrentItems());

        if($devices instanceof ApiProblem){
            return new ViewModel(
                $devices->toArray()
            );
        }

        $updatedDevices = array();

        foreach ($devices->getCurrentItems() as $device) {
            $device['last_command'] = $command;

            $updatedDevice = $this->getDevicesService()->patch($device['id'], $device, ['last_command' => $command]);

            if($updatedDevice instanceof ApiProblem){
                return new ViewModel(
                    $updatedDevice->toArray()
                );
            }

            $updatedDevices[] = $updatedDevice;
        }

        $group = $this->getGroupsService()->fetch($groupId);
        $updatedGroup = $this->getGroupsService()->patch($groupId, $group, ['last_command' => $command]);

        return new ViewModel(
            array_merge(
                (new SimpleResult("ok", "command sent"))->toArray(),
                [
                    'devices' => Entity::asArray($updatedDevices),
                    'group' => Entity::asArray($updatedGroup)
                ]
            )
        );
    }

    /**
     * @return DevicesService
     */
    public function getDevicesService()
    {
        return $this->devicesService;
    }

    /**
     * @param DevicesService $devicesService
     */
    public function setDevicesService($devicesService)
    {
        $this->devicesService = $devicesService;
    }

    /**
     * @return GroupsService
     */
    public function getGroupsService()
    {
        return $this->groupsService;
    }

    /**
     * @param GroupsService $groupsService
     */
    public function setGroupsService($groupsService)
    {
        $this->groupsService = $groupsService;
    }
}
