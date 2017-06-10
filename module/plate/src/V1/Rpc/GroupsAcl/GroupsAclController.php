<?php
namespace plate\V1\Rpc\GroupsAcl;

use plate\EntitySupport\Entity;
use plate\V1\Rest\DevicesAcl\DevicesAclService;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class GroupsAclController extends AbstractActionController
{
    /**
     * @var DevicesAclService
     */
    protected $devicesAclService;

    /**
     * GroupsAclController constructor.
     * @param DevicesAclService $devicesAclService
     */
    public function __construct(DevicesAclService $devicesAclService)
    {
        $this->devicesAclService = $devicesAclService;
    }


    public function groupsAclAction()
    {
        $data = $this->bodyParams();

        $groupID = $data['group_id'];
        $client_id = $data['client_id'];

        $res = $this->getDevicesAclService()->addRightsToGroup($client_id, $groupID);

        return new ViewModel(
            Entity::asArray($res)
        );
    }

    /**
     * @return DevicesAclService
     */
    public function getDevicesAclService()
    {
        return $this->devicesAclService;
    }

    /**
     * @param DevicesAclService $devicesAclService
     */
    public function setDevicesAclService($devicesAclService)
    {
        $this->devicesAclService = $devicesAclService;
    }


}
