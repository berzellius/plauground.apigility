<?php
namespace plate\V1\Rpc\EntitiesRpc;

use Herrera\Json\Exception\Exception;
use Interop\Container\ContainerInterface;
use plate\ControllerSupport\ControllerSupportUtils;
use plate\Hydrator\CustomHydratingResultSet;
use plate\V1\Rest\Entities\EntitiesService;
use Zend\InputFilter\InputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZF\Apigility\Documentation\Controller;

class EntitiesRpcController extends AbstractActionController
{
    /**
     * @var EntitiesService
     */
    protected $entitiesService;

    public function entitiesRpcAction()
    {
        $filteredData = $this->getInputFilter()->getValues();
        ControllerSupportUtils::
            assertOnlyOneParameterIsSet($filteredData, ['entity_root', 'node_root'],
            'One and only one of variables `entity_root` and `node_root` must be set!');

        $types = [];
        if(isset($filteredData['types'])){
            $types = ControllerSupportUtils::getArrayFromCommaDelimitedString($filteredData['types']);
        }

        $level_depth = isset($filteredData['level_depth'])? $filteredData['level_depth'] : null;


        if(isset($filteredData['entity_root'])){
            $entity_root = $filteredData['entity_root'];

            $res = $this->getEntitiesService()->findByParentEntityAndTypesSetAndMaxDepth(
                $entity_root, $level_depth, $types
            );

            return new JsonModel($res->toObjectsArray());
        }

        if(isset($filteredData['node_root'])){
            $node_root = $filteredData['node_root'];

            $res = $this->getEntitiesService()->findByParentNodeAndTypesSetAndMaxDepth(
                $node_root, $level_depth, $types
            );

            return new JsonModel($res->toObjectsArray());
        }

        return null;
    }

    /**
     * EntitiesRpcController constructor.
     * @param EntitiesService $entitiesService
     */
    public function __construct(EntitiesService $entitiesService)
    {
        $this->entitiesService = $entitiesService;
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


}
