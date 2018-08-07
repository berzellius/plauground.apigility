<?php
namespace plate\V1\Rest\BasicHierarchy;

use plate\EntitySupport\entity\Entity;
use plate\EntitySupport\entity\MappedSuperClassEntity;
use plate\V1\Rest\BasicHierarchy\inheritance\DeviceEntity;
use plate\V1\Rest\BasicHierarchy\inheritance\FloorEntity;
use plate\V1\Rest\BasicHierarchy\inheritance\GroupEntity;
use plate\V1\Rest\BasicHierarchy\inheritance\RoomEntity;
use plate\V1\Rest\BasicHierarchy\inheritance\ScheduledEntity;

/**
 * Класс для маппинга сущностей (обязателен для REST API сервисов Apigility)
 * Class BasicHierarchyEntity
 * @package plate\V1\Rest\BasicHierarchy
 */
class BasicHierarchyEntity extends MappedSuperClassEntity
{
    public static $mapperFieldName = 'type_enum';

    public static $mappingClassesCollection = [
        DeviceEntity::class,
        GroupEntity::class,
        ScheduledEntity::class,
        RoomEntity::class,
        FloorEntity::class
    ];
}
