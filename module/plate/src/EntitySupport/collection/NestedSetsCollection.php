<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 22.05.2018
 * Time: 0:01
 */

namespace plate\EntitySupport\collection;


use plate\EntitySupport\collection\Collection;
use Zend\Db\ResultSet\AbstractResultSet;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Json\Json;

abstract class NestedSetsCollection extends Collection
{
    /**
     * имя поля, которое соответствует уровню в nested sets иерархии
     * @return string
     */
    public static $levelFieldName = 'level';

    /**
     * имя поля, которое соответствует левому ключу в nested sets иерархии
     * @return string
     */
    public static $lkeyFieldName = 'lkey';

    /**
     * имя поля, которое соответствует правому ключу в nested sets иерархии
     * @return string
     */
    public static $rkeyFieldName = 'rkey';

    /**
     * имя поля, которое соответсвует полю, которое хранит название контейнера
     * @return string
     */
    public static $containerFieldName = 'container';

    /**
     * поле, определяющее тип элемента
     * @var string
     */
    public static $typeFieldName = 'type';

    /**
     * имя таблицы, содержащей узлы иерархии наименьшего уровня для каждого элемента
     * @var string
     */
    public static $minimalLevelsTable = null;

    /**
     * имя поля таблицы $minimalLevelsTable, по которому производится поиск элемента
     */
    public static $minimalLevelsTableIdField = null;

    /**
     * Обработка select - если нужна
     * @param Select $select
     * @param $clientId - идентификатор пользователя, если есть
     * @param $isAdmin
     * @return Select
     */
    public static function processSelect(Select $select, $clientId = null, $isAdmin = false){
        $select = parent::processSelect($select, $clientId);

        $cc = get_called_class();
        $order = [
            $cc::$lkeyFieldName => Select::ORDER_ASCENDING,
        ];

        $select
            ->order($order);

        return $select;
    }

    /**
     * Отбор подчиненных элементов
     * Родительский элемент определяем по id сущности, входящей в иерархию
     * @param Select $select
     * @param $rootId
     * @param $levelDepth
     * @param array $typeList
     * @return null|Select
     */
    public static function selectByRootElementIdAndMaxLevelDepthAndTypeList(Select $select, $rootId, $levelDepth = null, array $typeList = [])
    {
        $cc = get_called_class();

        $select = self::selectByRootElementIdAndMaxLevelDepthWithJoiningTable(
            $select, $cc::$minimalLevelsTable, $cc::$minimalLevelsTableIdField, $rootId, $levelDepth
        );
        $select = self::selectTypes($select, $typeList);

        return $select;
    }

    /**
     * Отбор подчиненных элементов
     * Родительский элемент определяем по полю $idField в таблице $tableName
     * @param Select $select
     * @param $tableName
     * @param $idField
     * @param array $rootId
     * @param $levelDepth
     * @param array $typeList
     * @return Select
     */
    public static function selectByRootNodeIdAndMaxLevelDepthAndTypeList(Select $select, $tableName, $idField, $rootId, $levelDepth, array $typeList = [])
    {
        $select = self::selectByRootElementIdAndMaxLevelDepthWithJoiningTable(
            $select, $tableName, $idField, $rootId, $levelDepth
        );
        $select = self::selectTypes($select, $typeList);
        return $select;
    }

    /**
     * @param Select $select
     * @param $tableName
     * @param $idField
     * @param $levelDepth
     * @param array $typeList
     * @return Select
     */
    public static function selectByMaxLevelDepthAndTypeList(Select $select, $tableName, $idField, $levelDepth, array $typeList = []){
        $select = self::selectByMaxLevelDepthWithJoiningTable(
            $select, $tableName, $idField, $levelDepth
        );
        $select = self::selectTypes($select, $typeList);
        return $select;
    }

    /**
     * @param Select $select
     * @param $tableName
     * @param $idField
     * @param array $typeList
     * @return Select
     */
    public static function selectByTypesOnly(Select $select, $tableName, $idField, array $typeList = []){
        $select = self::selectTypes($select, $typeList);
        return $select;
    }

    /**
     * @param Select $select
     * @param $typeList
     * @return Select
     */
    protected static function selectTypes(Select $select, $typeList){
        $cc = get_called_class();
        if(count($typeList) > 0){
            $select
                ->where($cc::$typeFieldName . " in (" . implode(',', $typeList) . ")");
        }

        return $select;
    }

    /**
     * @param Select $select
     * @param $joinTable
     * @param $joinField
     * @param $rootId
     * @param null $levelDepth
     * @return Select
     */
    protected static function selectByRootElementIdAndMaxLevelDepthWithJoiningTable(
        Select $select, $joinTable, $joinField, $rootId, $levelDepth = null
    ){
        $cc = get_called_class();

        $select
            ->join(
                ['mt' => $joinTable],
                new Expression("mt. " . $joinField . " = " . $rootId),
                []
            );


        $select
            ->where(
                "t." . $cc::$lkeyFieldName . " >= mt." . $cc::$lkeyFieldName .
                " and t. " . $cc::$rkeyFieldName . " <= mt." . $cc::$rkeyFieldName, Where::OP_AND
            )
        ;

        if($levelDepth != null || $levelDepth === 0){
            $select
                ->where(
                    "t." . $cc::$levelFieldName . " <= (mt. "  . $cc::$levelFieldName . " + " . $levelDepth .")", Where::OP_AND
                );
        }

        return $select;
    }

    /**
     * @param $select
     * @param $tableName
     * @param $idField
     * @param $levelDepth
     * @return Select
     */
    protected static function selectByMaxLevelDepthWithJoiningTable($select, $tableName, $idField, $levelDepth)
    {
        $cc = get_called_class();

        if($levelDepth != null || $levelDepth === 0){
            $select
                ->where(
                    "t." . $cc::$levelFieldName . " <= (". $levelDepth .")", Where::OP_AND
                );
        }

        return $select;
    }

    public function toJson()
    {
        $this->setItemCountPerPage(-1);
        $currentItems = $this->getCurrentItems();
        //die(get_class($currentItems));

        if ($currentItems instanceof AbstractResultSet) {
            return Json::encode($currentItems->toArray());
        }

        $rebuildedItems = [
            /*'page' => $this->getCurrentPageNumber(),
            'pagesize' => $this->getItemCountPerPage(),*/
            $this->getCollectionListName() => []
        ];

        foreach ($currentItems as $item){
            $rebuildedItems[$this->getCollectionListName()][] = $item;
        }


        return Json::encode($rebuildedItems);
    }
}