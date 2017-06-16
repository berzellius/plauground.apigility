<?php
namespace plate\V1\Rpc\ItemsLists;

use plate\V1\Rest\Devices\DevicesService;
use plate\V1\Rest\Favorites\FavoritesService;
use plate\V1\Rest\Groups\GroupsService;
use plate\V1\Rest\Scheduled_tasks\ScheduledTasksService;
use Zend\Mvc\Controller\AbstractActionController;

class ItemsListsController extends AbstractActionController
{

    /**
     * @var DevicesService
     */
    protected $devicesService;

    /**
     * @var GroupsService
     */
    protected $groupsService;

    /**
     * @var ScheduledTasksService
     */
    protected $scheduledTasksService;

    /**
     * ItemListsController constructor
     * @param DevicesService $devicesService
     * @param GroupsService $groupsService
     * @param ScheduledTasksService $scheduledTasksService
     */
    public function __construct($devicesService, $groupsService, $scheduledTasksService)
    {
        $this->setDevicesService($devicesService);
        $this->setGroupsService($groupsService);
        $this->setScheduledTasksService($scheduledTasksService);
    }

    public function itemsListsAction(){
        $params = $this->params()->fromQuery();

        $roomID = isset($params['room_id'])? $params['room_id'] : false;

        $items = [];
        $items['devices'] =
            ($roomID)? $this->getDevicesService()->fetchAll(['room_id' => $roomID]) :
                $this->getDevicesService()->fetchAll()->getCurrentItems();
        $items['groups'] =
            ($roomID)? $this->getGroupsService()->fetchAll(['room_id' => $roomID]) :
                $this->getGroupsService()->fetchAll()->getCurrentItems();
        $items['scheduled_tasks'] =
            ($roomID)? $this->getScheduledTasksService()->fetchAll(['room_id' => $roomID]) :
                $this->getScheduledTasksService()->fetchAll([])->getCurrentItems();


        return $items;
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

    /**
     * @return ScheduledTasksService
     */
    public function getScheduledTasksService()
    {
        return $this->scheduledTasksService;
    }

    /**
     * @param mixed $scheduledTasksService
     */
    public function setScheduledTasksService($scheduledTasksService)
    {
        $this->scheduledTasksService = $scheduledTasksService;
    }
}
