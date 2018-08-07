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
use plate\V1\Rest\Entities_uc\Entities_ucService;
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
     * @param $levelDepth
     * @param array $types
     * @return Select|null
     * @throws \Exception
     */
    public function selectByParentNodeAndTypesSetAndMaxDepth($rootId, $levelDepth = null, array $types = []){
        return $this->getTableMapper()->generateSelectByRootNodeIdAndMaxLevelDepthAndTypeList($rootId, $levelDepth, $types);
    }

    /**
     * Выбор элементов, принадлежащих элементу $rootId, с ограничением по типам - $types == [<id типа>, [...]]
     * глубиной не более $levelDepth
     * @param $rootId
     * @param $levelDepth
     * @param array $types
     * @return CustomHydratingResultSet|null
     * @throws \Exception
     */
    public function findByParentEntityAndTypesSetAndMaxDepth($rootId, $levelDepth = null, array $types = []){
        $select = $this->getTableMapper()->generateSelectByRootElementIdAndMaxLevelDepthAndTypeList($rootId, $levelDepth, $types);

        //die($select->getSqlString($this->getAdapter()->platform));
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
     * @throws \Exception
     */
    public function findByParentNodeAndTypesSetAndMaxDepth($rootId, $levelDepth = null, array $types = []){
        $select = $this->getTableMapper()->generateSelectByRootNodeIdAndMaxLevelDepthAndTypeList($rootId, $levelDepth, $types);
        /**
         * @var CustomHydratingResultSet
         */
        $res = $this->getTableMapper()->getTable()->selectWith($select);
        return $res;
    }

    /**
     * @param null $levelDepth
     * @param array $types
     * @return \Zend\Db\ResultSet\ResultSetInterface
     * @throws \Exception
     */
    public function findByTypesSetAndMaxDepth($levelDepth = null, array $types = []){
        $select = $this->getTableMapper()->generateSelectByMaxLevelDepthAndTypeList($levelDepth, $types);
        $res = $this->getTableMapper()->getTable()->selectWith($select);

        return $res;
    }

    /**
     * Поиск по Избранному
     * @param array $types
     * @param null $levelDepth
     * @return \Zend\Db\ResultSet\ResultSetInterface
     * @throws \Exception
     */
    public function findFavoritesByTypesAndMaxLevelDepth(array $types = [], $levelDepth = null)
    {
        $select = $this->getTableMapper()->generateSelectFavoritesByMaxLevelDepthAndTypeList($levelDepth, $types);

        $res = $this->getTableMapper()->getTable()->selectWith($select);
        return $res;
    }

    /**
     * Отбор только по типам элементов
     * @param $types
     * @return CustomHydratingResultSet
     * @throws \Exception
     */
    public function findByTypesOnly(array $types)
    {
        if(!in_array(0, $types)){
            // здесь обязателен нулевой тип в списке
            $types[] = 0;
        }

        sort($types);

        $select = $this->getTableMapper()->generateSelectByTypesOnly($types);
        /**
         * @var CustomHydratingResultSet
         */
        $res = $this->getTableMapper()->getTable()->selectWith($select);
        return $res;
    }


    /**
     * Выбор всех элементов
     * @return CustomHydratingResultSet|null
     */
    public function findAll(){
        $select = $this->getTableMapper()->generateBasicSelect();
        /**
         * @var CustomHydratingResultSet
         */
        $res = $this->getTableMapper()->getTable()->selectWith($select);
        return $res;
    }

    /**
     * @param $entityId
     * @return CustomHydratingResultSet
     * @throws \Exception
     */
    public function getEntityById($entityId)
    {
        $select = $this->getTableMapper()->generateSelectByRootElementIdAndMaxLevelDepthAndTypeList($entityId, 0, []);

        /**
         * @var CustomHydratingResultSet
         */
        $res = $this->getTableMapper()->getTable()->selectWith($select);
        return $res;
    }


}