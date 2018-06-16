<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 20.05.2018
 * Time: 22:54
 */

namespace plate\V1\Rest\Entities;


use plate\EntityServicesSupport\EntityService;
use plate\Hydrator\CustomHydratingResultSet;
use plate\Json\JsonModelAlt;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\View\Helper\ViewModel;

/**
 * Бизнес-логика работы с Entities
 * Class EntitiesService
 * @package plate\V1\Rest\Entities
 */
class EntitiesService extends EntityService
{

    /**
     * @param $params
     * @return HydratingResultSet|\ZF\ApiProblem\ApiProblem
     *
    public function fetchAll($params)
    {
        // работа с Entities напрямую - только админу
        if(!$this->getAuthUtils()->checkAdminPrivileges() && false){
            return $this->notAllowed();
        }

        if(isset($params['root_entity_id'])){
            $root_entity_id = (int) $params['root_entity_id'];
            $type_ids_list = isset($params['type_ids_list'])? explode(',', $params['type_ids_list']) : [];
            foreach ($type_ids_list as &$value) $value = (int) $value;
            $level_depth = isset($params['level_depth'])? (int)$params['level_depth'] : null;

            $select = $this->selectByParentAndTypesSetAndMaxDepth($root_entity_id, $level_depth, $type_ids_list);
        }
        else{
            $select = $this->getTableMapper()->generateBasicSelect();
        }

        /**
         * @var HydratingResultSet
         *
        $res = $this->getTableMapper()->getTable()->selectWith($select);
        return $res;
    }*/

    /**
     * Выбор элементов, принадлежащих элементу $rootId, с ограничением по типам - $types == [<id типа>, [...]]
     * глубиной не более $levelDepth
     * @param $rootId
     * @param array $types
     * @param $levelDepth
     * @return Select|null
     */
    public function selectByParentNodeAndTypesSetAndMaxDepth($rootId, $levelDepth = null, array $types = []){
        return $this->getTableMapper()->generateSelectByRootNodeIdAndMaxLevelDepthAndTypeList($rootId, $levelDepth, $types);
    }

    /**
     * Выбор элементов, принадлежащих элементу $rootId, с ограничением по типам - $types == [<id типа>, [...]]
     * глубиной не более $levelDepth
     * @param $rootId
     * @param array $types
     * @param $levelDepth
     * @return CustomHydratingResultSet|null
     */
    public function findByParentEntityAndTypesSetAndMaxDepth($rootId, $levelDepth = null, array $types = []){
        $select = $this->getTableMapper()->generateSelectByRootElementIdAndMaxLevelDepthAndTypeList($rootId, $levelDepth, $types);

        /**
         * @var CustomHydratingResultSet
         */
        $res = $this->getTableMapper()->getTable()->selectWith($select);
        return $res;
    }

    /**
     * Выбор элементов, принадлежащих узлу $rootId, с ограничением по типам - $types == [<id типа>, [...]]
     * глубиной не более $levelDepth
     * @param $rootId
     * @param array $types
     * @param $levelDepth
     * @return CustomHydratingResultSet|null
     */
    public function findByParentNodeAndTypesSetAndMaxDepth($rootId, $levelDepth = null, array $types = []){
        $select = $this->getTableMapper()->generateSelectByRootNodeIdAndMaxLevelDepthAndTypeList($rootId, $levelDepth, $types);

        /**
         * @var CustomHydratingResultSet
         */
        $res = $this->getTableMapper()->getTable()->selectWith($select);
        return $res;
    }
}