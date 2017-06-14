<?php
namespace plate\V1\Rpc\FavoritesRpc;

use plate\EntityServicesSupport\EntitiesUtils;
use plate\V1\Rest\Favorites\FavoritesService;
use Zend\Mvc\Controller\AbstractActionController;
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
