<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 01.09.2018
 * Time: 9:41
 */

namespace plate\V1\Rest\Entities;


use Zend\Db\Sql\Select;

class EntitiesSelectHelper
{
    /**
     * @param Select $select
     * @param $typeList
     * @return Select
     */
    public static function selectTypes(Select $select, $typeList){
        return EntitiesCollection::selectTypes($select, $typeList);
    }

    /**
     * @param Select $select
     * @param $levelDepth
     * @param array $typeList
     * @return Select
     */
    public static function selectByMaxLevelDepthAndTypeList(Select $select, $levelDepth, array $typeList = []){
        return EntitiesCollection::selectByMaxLevelDepthAndTypeList($select, $levelDepth, $typeList);
    }

    /**
     * @param $select
     * @return Select
     */
    public static function selectFavorites(Select $select)
    {
        // isFavorite определяется функцией => вынуждены использовать having. ожидаем небольшое количество строк в результате
        $select
            ->having("isFavorite = 1");

        return $select;
    }

    /**
     * @param Select $select
     * @param $rootId
     * @param null $levelDepth
     * @param array $typeList
     * @return null|Select
     */
    public static function selectByRootElementIdAndMaxLevelDepthAndTypeList(Select $select, $rootId, $levelDepth = null, array $typeList = []){
        return EntitiesCollection::selectByRootElementIdAndMaxLevelDepthAndTypeList($select, $rootId, $levelDepth, $typeList);
    }

    /**
     * @param Select $select
     * @param $tableName
     * @param $idField
     * @param $rootId
     * @param $levelDepth
     * @param array $typeList
     * @return Select
     */
    public static function selectByRootNodeIdAndMaxLevelDepthAndTypeList(Select $select, $tableName, $idField, $rootId, $levelDepth, array $typeList = [])
    {
        return EntitiesCollection::selectByRootNodeIdAndMaxLevelDepthAndTypeList($select, $tableName, $idField, $rootId, $levelDepth, $typeList);
    }
}