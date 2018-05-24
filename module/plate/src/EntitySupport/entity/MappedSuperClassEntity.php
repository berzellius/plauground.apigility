<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 23.05.2018
 * Time: 21:30
 */

namespace plate\EntitySupport\entity;


abstract class MappedSuperClassEntity extends Entity
{
    /**
     * @var string
     */
    public static $mapperFieldName;

    /**
     * @var array
     */
    public static $mappingClassesCollection;

    /**
     * @param array $data
     * @param MappedSuperClassEntity $prototype
     * @return mixed
     */
    public static function getEntityPrototype(array $data, $prototype){
        $field = $prototype::$mapperFieldName;
        foreach ($prototype::$mappingClassesCollection as $class){
            if($class::$$field === $data[$field]){
                return new $class();
            }
        }
        return new $prototype();
    }
}