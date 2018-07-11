<?php
namespace plate\V1\Rpc\EntitiesRpc;

use plate\ControllerSupport\ControllerSupportUtils;
use plate\ControllerSupport\RpcController;
use plate\V1\Rest\Entities\EntitiesService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZF\ApiProblem\ApiProblem;

class EntitiesRpcController extends RpcController
{
    /**
     * @var EntitiesService
     */
    protected $entitiesService;

    /**
     * @return null|JsonModel
     * @throws \Exception
     */
    public function entitiesRpcAction()
    {
        $filteredData = $this->getInputFilter()->getValues();
        ControllerSupportUtils::
            assertOneOrZeroParamatersIsSet($filteredData, ['ent_id', 'ns_id'],
            'only one of variables `ent_id` and `ns_id` can be set!');

        $types = [];
        if(isset($filteredData['types'])){
            $types = ControllerSupportUtils::getArrayFromCommaDelimitedString($filteredData['types']);
        }

        $level_depth = isset($filteredData['level'])? $filteredData['level'] : null;


        if(isset($filteredData['ent_id'])){
            $entity_root = $filteredData['ent_id'];

            $res = $this->getEntitiesService()->findByParentEntityAndTypesSetAndMaxDepth(
                $entity_root, $level_depth, $types
            );

            return new JsonModel($res->toObjectsArray());
        }

        if(isset($filteredData['ns_id'])){
            $node_root = $filteredData['ns_id'];

            $res = $this->getEntitiesService()->findByParentNodeAndTypesSetAndMaxDepth(
                $node_root, $level_depth, $types
            );

            return new JsonModel($res->toObjectsArray());
        }

        // случай, когда у нас не выбран узел и не задана глубина, но указаны типы
        if(null === $level_depth && count($types) > 0){
            $res = $this->getEntitiesService()->findByTypesOnly(
                $types
            );
            return new JsonModel($res->toObjectsArray());
        }


        $res = $this->getEntitiesService()->findByTypesSetAndMaxDepth($level_depth, $types);
        return new JsonModel($res->toObjectsArray());
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
