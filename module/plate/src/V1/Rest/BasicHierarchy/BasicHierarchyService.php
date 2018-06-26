<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2018
 * Time: 19:31
 */

namespace plate\V1\Rest\BasicHierarchy;


use Interop\Container\ContainerInterface;
use plate\EntityServicesSupport\EntityService;
use plate\EntitySupport\collection\Collection;
use plate\EntitySupport\collection\NestedSetsCollection;
use plate\EntitySupport\resource\ResourceFactory;
use plate\EntitySupport\tableGateway\TableGatewayMapper;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Join;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Hydrator\ObjectProperty;
use Zend\Paginator\Adapter\DbSelect;

/**
 * Бизнес-логика работы с базовой иерархией системы
 * Class BasicHierarchyService
 * @package plate\V1\Rest\BasicHierarchy
 */
class BasicHierarchyService extends EntityService
{

    /**
     * Выбор элементов, принадлежащих элементу $rootId, с ограничением по типам - $types == [<id типа>, [...]]
     * глубиной не более $levelDepth
     * @param $rootId
     * @param array $types
     * @param $levelDepth
     * @return Select|null
     * @throws \Exception
     */
    public function selectByParentAndTypesSetAndMaxDepth($rootId, $levelDepth = null, array $types = []){

        //return $this->getTableMapper()->generateSelectByRootElementIdAndMaxLevelDepthAndTypeList($rootId, $levelDepth, $types);
        return $this->getTableMapper()->generateSelectByRootNodeIdAndMaxLevelDepthAndTypeList($rootId, $levelDepth, $types);
        /*$select = $this->selectByParentAndLevelDepth($rootId, $levelDepth);

        if(count($types) > 0){
            $select
                ->where("t.type in (" . implode(',', $types) . ")");
        }

        return $select;*/
    }

    /**
     * Выбор элементов, принадлежащих элементу $rootId, глубиной не более $levelDepth
     * @param $rootId
     * @param null $levelDepth
     * @return Select|null
     */
    public function selectByParentAndLevelDepth($rootId, $levelDepth = null){
        $select = $this->getTableMapper()->generateBasicSelect();

        $select
            ->join(
            // hbe - hierarchy basic entities.. Надо что-то придумать в плане псевдонима
                ['hbe' => '___playground_view_basic_hier_by_type_id'],
                new Expression("hbe.type_id = " . $rootId),
                []
            );


        $select
            ->where(
                "t.lkey >= hbe.lkey and t.rkey <= hbe.rkey", Where::OP_AND
            )
        ;

        if($levelDepth != null){
            $select
                ->where(
                    "t.level <= (hbe.level + " . $levelDepth .")", Where::OP_AND
                );
        }

        return $select;
    }

    public function fetchAll($params)
    {
        $select = $this->getTableMapper()->generateBasicSelect();

        /**
         * дальше дополняем запрос, а потом эту добавочку нужно грамотно параметризовать,
         * чтобы в NestedSetsCollection была зашита логика работы с выбором родительского элемента, глубины, типов..
         *
         * !! да вообще cделаем DAO, который принимает агрументы, указанные ниже
         * если это обычная parentID-defined коллеция, то она будет уметь отдавать уровни не более 1 в силу своих своиств
         * а если это не иерархическая коллекция, то и вовсе ей побоку на parent-child
         */

        // в params нас интересует root_entity_id, type_ids_list, level_depth
        if(isset($params['root_entity_id'])){
            $root_entity_id = (int) $params['root_entity_id'];
            $type_ids_list = isset($params['type_ids_list'])? explode(',', $params['type_ids_list']) : [];
            foreach ($type_ids_list as &$value) $value = (int) $value;
            $level_depth = isset($params['level_depth'])? (int)$params['level_depth'] : null;

            $select = $this->selectByParentAndTypesSetAndMaxDepth($root_entity_id, $level_depth, $type_ids_list);
        }

        /**
         * @var HydratingResultSet
         */
        $res = $this->getTableMapper()->getTable()->selectWith($select);
        return $res;
    }
}