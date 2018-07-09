<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace plate\EntitySupport\collection;


use Zend\Db\ResultSet\AbstractResultSet;
use Zend\Db\Sql\Select;
use Zend\Json\Json;
use Zend\Paginator\Paginator;

/**
 * Class Collection
 * Этот класс наследуют мапперы коллекций
 * @package plate\EntitySupport
 */
class Collection extends Paginator
{
    protected $collectionListName = 'list';
    protected $collectionEntityName = 'object';

    /**
     * Collection constructor.
     * @param \Zend\Paginator\Adapter\AdapterInterface|\Zend\Paginator\AdapterAggregateInterface $adapter
     */
    public function __construct($adapter)
    {
        /**
         * Здесь прилетает adapter, в который уже зашит sql-запрос
         * можно что-то хорошее сделать с этим запросом, пока не поздно :)
         * а само выполнение запроса происходит при обращении к getCurrentItems()
         * т.е. если мы хотим sql запрос -> Json результат, метод toJson подходит
         * а если хотим результат sql перемаппить в объекты и с ними поработать, то надо что-то новое
         * например, getCurrentItems наследовать сюда и разбираться. Тогда этот collection должен знать,
         * объекты какого типа (Entity) он должен хранить.
         */
        parent::__construct($adapter);
    }

    /**
     * Обработка select - если нужна
     * @param Select $select
     * @return Select
     */
    public static function processSelect(Select $select){
        return $select;
    }

    /**
     * @param Select $select
     * @param $rootId
     * @param $levelDepth
     * @param array $typeList
     * @return null|Select
     * @throws \Exception
     */
    public static function selectByRootElementIdAndMaxLevelDepthAndTypeList(Select $select, $rootId, $levelDepth, array $typeList){
        throw new \Exception("method selectByRootElementIdAndMaxLevelDepthAndTypeList must be implemented in child classes of " . Collection::class);
    }

    /**
     * @param Select $select
     * @param $rootId
     * @param $levelDepth
     * @param array $typeList
     * @return null|Select
     * @throws \Exception
     */
    public static function selectByRootNodeIdAndMaxLevelDepthAndTypeList(Select $select, $tableName, $idField, $rootId, $levelDepth, array $typeList){
        throw new \Exception("method selectByRootNodeIdAndMaxLevelDepthAndTypeList must be implemented in child classes of " . Collection::class);
    }

    /**
     * @param Select $select
     * @param $tableName
     * @param $idField
     * @param $levelDepth
     * @param array $typeList
     * @throws \Exception
     */
    public static function  selectByMaxLevelDepthAndTypeList(Select $select, $tableName, $idField, $levelDepth, array $typeList){
        throw new \Exception("method selectByMaxLevelDepthAndTypeList must be implemented in child classes of " . Collection::class);
    }

    /**
     * Преобразование в JSON
     * @return string
     */
    public function toJson()
    {
        /**
         * При вызове getCurrentItems выполняется select
         */
        $currentItems = $this->getCurrentItems();


        if ($currentItems instanceof AbstractResultSet) {
            return Json::encode($currentItems->toArray());
        }

        $rebuildedItems = [
            'page' => $this->getCurrentPageNumber(),
            'pagesize' => $this->getItemCountPerPage(),
            $this->getCollectionListName() => []
        ];

        foreach ($currentItems as $item){
            $rebuildedItems[$this->getCollectionListName()][] = $item;
        }


        return Json::encode($rebuildedItems);
    }

    /**
     * @return string
     */
    public function getCollectionListName()
    {
        return $this->collectionListName;
    }

    /**
     * @param string $collectionListName
     */
    public function setCollectionListName($collectionListName)
    {
        $this->collectionListName = $collectionListName;
    }

    /**
     * @return string
     */
    public function getCollectionEntityName()
    {
        return $this->collectionEntityName;
    }

    /**
     * @param string $collectionEntityName
     */
    public function setCollectionEntityName($collectionEntityName)
    {
        $this->collectionEntityName = $collectionEntityName;
    }


}
