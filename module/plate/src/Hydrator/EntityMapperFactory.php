<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 23.05.2018
 * Time: 21:17
 */

namespace plate\Hydrator;


use plate\EntitySupport\entity\Entity;
use plate\EntitySupport\entity\MappedSuperClassEntity;

class EntityMapperFactory
{
    /**
     * Возвращает необходимую реализацию Entity в зависимости от содержимого
     * @param array $data
     * @param Entity $entity
     * @return Entity
     */
    public static function getEntityObject(array $data, Entity $entity){
        if($entity instanceof MappedSuperClassEntity){
            return MappedSuperClassEntity::getEntityPrototype($data, $entity);
        }

        return $entity;
    }
}