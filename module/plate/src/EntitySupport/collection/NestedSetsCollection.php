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
use Zend\Json\Json;

abstract class NestedSetsCollection extends Collection
{
    /*
     * todo эти поля имеет смысл перетащить в Entity. тогда у нас будут наследники NestedSetsEntity;
     * todo можем сделать фабричный метод получения разных HydratingResultSet -> с разной логикой формирования массивов
     */

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