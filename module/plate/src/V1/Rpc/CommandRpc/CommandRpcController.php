<?php
namespace plate\V1\Rpc\CommandRpc;

use plate\ControllerSupport\ControllerSupportUtils;
use plate\ControllerSupport\RpcController;
use plate\V1\Rest\Entities\EntitiesService;
use plate\V1\Rest\EntitiesUserContext\EntitiesUserContextService;
use Zend\Mvc\Controller\AbstractActionController;

class CommandRpcController extends RpcController
{

    /**
     * @var EntitiesService
     */
    protected $entitiesService;

    /**
     * @var EntitiesUserContextService
     */
    protected $entitiesUserContextService;

    /**
     *
     * @throws \Exception
     */
    public function commandRpcAction()
    {
        $filteredData = $this->getInputFilter()->getValues();

        $entityId = ControllerSupportUtils::assertParameterSet($filteredData,
            'entity_id',
            'you must send entity_id - id of entity which you want send command');
        $command = ControllerSupportUtils::assertParameterSet($filteredData,
            'command',
            'you must send command');

        if(! $this->getEntitiesUserContextService()->checkRights($entityId)){
            $this->getEntitiesService()->notAllowedException("user has not rights for entity#" . $entityId);
        };

        return $this->getEntitiesService()->sendCommandToEntity($entityId, $command);
    }

    /**
     * @return EntitiesService
     */
    public function getEntitiesService()
    {
        return $this->entitiesService;
    }

    /**
     * @param EntitiesService $entitiesService
     */
    public function setEntitiesService($entitiesService)
    {
        $this->entitiesService = $entitiesService;
    }

    /**
     * @return EntitiesUserContextService
     */
    public function getEntitiesUserContextService()
    {
        return $this->entitiesUserContextService;
    }

    /**
     * @param EntitiesUserContextService $entitiesUserContextService
     */
    public function setEntitiesUserContextService($entitiesUserContextService)
    {
        $this->entitiesUserContextService = $entitiesUserContextService;
    }


}
