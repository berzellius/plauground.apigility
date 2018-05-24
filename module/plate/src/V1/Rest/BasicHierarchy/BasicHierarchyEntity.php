<?php
namespace plate\V1\Rest\BasicHierarchy;

use plate\EntitySupport\entity\Entity;
use plate\EntitySupport\entity\MappedSuperClassEntity;
use plate\V1\Rest\BasicHierarchy\inheritance\DeviceBasicHierarchyEntity;
use plate\V1\Rest\BasicHierarchy\inheritance\FloorBasicHierarchyEntity;
use plate\V1\Rest\BasicHierarchy\inheritance\GroupBasicHierarchyEntity;
use plate\V1\Rest\BasicHierarchy\inheritance\RoomBasicHierarchyEntity;
use plate\V1\Rest\BasicHierarchy\inheritance\ScheduledBasicHierarchyEntity;

/**
 * Класс для маппинга сущностей (обязателен для REST API сервисов Apigility)
 * Class BasicHierarchyEntity
 * @package plate\V1\Rest\BasicHierarchy
 */
class BasicHierarchyEntity extends MappedSuperClassEntity
{
    public static $mapperFieldName = 'type_enum';

    public static $mappingClassesCollection = [
        DeviceBasicHierarchyEntity::class,
        GroupBasicHierarchyEntity::class,
        ScheduledBasicHierarchyEntity::class,
        RoomBasicHierarchyEntity::class,
        FloorBasicHierarchyEntity::class
    ];
}
