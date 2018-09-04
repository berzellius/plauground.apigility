<?php
namespace plate\V1\Rpc\FavoritesRpc;

use plate\ControllerSupport\ControllerSupportUtils;
use plate\ControllerSupport\RpcController;
use plate\V1\Rest\Entities\EntitiesService;
use plate\V1\Rest\EntitiesUserContext\EntitiesUserContextService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class FavoritesRpcController extends RpcController
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
     * @throws \Exception
     */
    public function favoritesRpcAction()
    {

        $filteredData = $this->getInputFilter()->getValues();

        $entityId = ControllerSupportUtils::assertParameterSet($filteredData,
            'entity_id',
            'you must send entity_id - id of entity you want to like/dislike');
        $do = ControllerSupportUtils::assertParameterSetAndValueInArray($filteredData,
            'do', ['like', 'dislike'],
            'you must tell what to do - like or dislike entity. set `do` parameter to `like` or `dislike`');

        switch ($do){
            case 'like':
                $this->getEntitiesUserContextService()->likeEntity($entityId);
                break;
            case 'dislike':
                $this->getEntitiesUserContextService()->dislikeEntity($entityId);
                break;
        }

        return new JsonModel($this->getEntitiesService()->getEntityById($entityId));
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
