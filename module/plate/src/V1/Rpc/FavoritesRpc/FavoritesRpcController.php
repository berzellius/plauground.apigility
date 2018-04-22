<?php
namespace plate\V1\Rpc\FavoritesRpc;

use plate\EntityServicesSupport\EntitiesUtils;
use plate\V1\Rest\Favorites\FavoritesService;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblem;
use ZF\ContentNegotiation\ViewModel;

class FavoritesRpcController extends AbstractActionController
{
    /**
     * @var FavoritesService
     */
    protected $favoritesService;

    /**
     * @var EntitiesUtils
     */
    protected $entitiesUtils;

    /**
     * FavoritesRpcController constructor.
     * @param FavoritesService $favoritesService
     */
    public function __construct(FavoritesService $favoritesService)
    {
        $this->favoritesService = $favoritesService;
    }


    public function favoritesRpcAction()
    {
        $queryParams = $this->getRequest()->isPost()? $this->bodyParams() : $this->params()->fromQuery();

        if(isset($queryParams['action'])){
            $action = $queryParams['action'];
            switch ($action){
                CASE "delete":
                    if(!isset($queryParams['entity_type'])){
                        return new ApiProblem(500, "entity_type parameter missing");
                    }
                    if(!isset($queryParams['entity_id'])){
                        return new ApiProblem(500, "entity_id parameter missing");
                    }

                    $entity_type = $queryParams['entity_type'];
                    $entity_id = $queryParams['entity_id'];

                    $this->getFavoritesService()->deleteByEntityTypeAndId($entity_type, $entity_id);
                    break;
                CASE "add":
                    if(!isset($queryParams['entity_type'])){
                        return new ApiProblem(500, "entity_type parameter missing");
                    }
                    if(!isset($queryParams['entity_id'])){
                        return new ApiProblem(500, "entity_id parameter missing");
                    }

                    $params = [];
                    $params['entity_type'] = $queryParams['entity_type'];

                    switch ($params['entity_type']){
                        case "DEVICE":
                            $params['id_device'] = $queryParams['entity_id'];
                            break;
                        case "GROUP":
                            $params['id_group'] = $queryParams['entity_id'];
                            break;
                        case "SCHEDULED":
                            $params['id_scheduled_task'] = $queryParams['entity_id'];
                            break;
                    }

                    $this->getFavoritesService()->create(
                        $params, $params
                    );
                    break;
            }
        }

        $res = $this->getFavoritesService()->fetchAllFavorites();
        $res = $this->getEntitiesUtils()->sortDiffrerentTypeEntities($res, "favorite");

        return new ViewModel($res);
    }

    /**
     * @return FavoritesService
     */
    public function getFavoritesService()
    {
        return $this->favoritesService;
    }

    /**
     * @param FavoritesService $favoritesService
     */
    public function setFavoritesService($favoritesService)
    {
        $this->favoritesService = $favoritesService;
    }

    /**
     * @param EntitiesUtils $entitiesUtils
     */
    public function setEntitiesUtils($entitiesUtils)
    {
        $this->entitiesUtils = $entitiesUtils;
    }

    /**
     * @return EntitiesUtils
     */
    public function getEntitiesUtils()
    {
        return $this->entitiesUtils;
    }
}
