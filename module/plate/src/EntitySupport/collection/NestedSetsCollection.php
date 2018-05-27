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
use Zend\Db\Sql\Select;
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
     * Обработка select - если нужна
     * @param Select $select
     * @return Select
     */
    public static function processSelect(Select $select){
        $select = parent::processSelect($select);

        $cc = get_called_class();
        $order = [
            $cc::$lkeyFieldName => Select::ORDER_ASCENDING,
        ];

        $select
            ->order($order);

        return $select;
    }

    public function toJson()
    {
        $this->setItemCountPerPage(-1);
        $currentItems = $this->getCurrentItems();
        die(get_class($currentItems));

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