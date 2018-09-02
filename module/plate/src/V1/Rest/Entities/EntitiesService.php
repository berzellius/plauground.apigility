<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 20.05.2018
 * Time: 22:54
 */

namespace plate\V1\Rest\Entities;


use plate\Auth\AuthUtils;
use plate\EntityServicesSupport\EntityService;
use plate\EntityServicesSupport\ITableService;
use plate\EntitySupport\tableGateway\TableGatewayMapper;
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
     * Выбор элементов, принадлежащих элементу $rootId, с ограничением по типам - $types == [<id типа>, [...]]
     * глубиной не более $levelDepth
     * @param $rootId
     * @param $levelDepth
     * @param array $types
     * @return CustomHydratingResultSet|null
     * @throws \Exception
     */
    public function findByParentEntityAndTypesSetAndMaxDepth($rootId, $levelDepth = null, array $types = []){

        $select = EntitiesSelectHelper::selectByRootElementIdAndMaxLevelDepthAndTypeList(
            $this->generateBasicSelect(),
            $rootId,
            $levelDepth,
            $types
        );

        /** @var CustomHydratingResultSet $res */
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

        $select =
            EntitiesSelectHelper::selectByRootNodeIdAndMaxLevelDepthAndTypeList(
                $this->generateBasicSelect(),
                $this->getTableMapper()->getTable()->table,
                $this->getTableMapper()->getIdField(),
                $rootId,
                $levelDepth,
                $types
            );

        /** @var CustomHydratingResultSet $res */
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

        $res = $this->getTableMapper()->getTable()->selectWith(
            EntitiesSelectHelper::selectByMaxLevelDepthAndTypeList(
                $this->generateBasicSelect(),
                $levelDepth, $types)
        );

        return $res;
    }

    /**
     * Поиск по Избранному
     * @param array $types
     * @return \Zend\Db\ResultSet\ResultSetInterface
     * @throws \Exception
     */
    public function findFavoritesByTypes(array $types = [])
    {

        $select = $this->generateBasicSelect();
        $select = EntitiesSelectHelper::selectTypes($select, $types);
        $select = EntitiesSelectHelper::selectFavorites($select);
        // нам нужны элементы на минимальном уровне
        $select
            ->where("t.surrogate_level = 0");

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

        $select = EntitiesSelectHelper::selectTypes(
            $this->generateBasicSelect(), $types);

        /** @var CustomHydratingResultSet $res */
        $res = $this->getTableMapper()->getTable()->selectWith($select);
        return $res;
    }


    /**
     * Выбор всех элементов
     * @return CustomHydratingResultSet|null
     */
    public function findAll(){
        $select = $this->getTableMapper()->generateBasicSelect();

        /** @var CustomHydratingResultSet $res */
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
        $select = EntitiesSelectHelper::selectByRootElementIdAndMaxLevelDepthAndTypeList(
            $this->generateBasicSelect(),
            $entityId, 0, []);

        /** @var CustomHydratingResultSet $res */
        $res = $this->getTableMapper()->getTable()->selectWith($select);
        return $res;
    }
}