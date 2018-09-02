<?php
namespace plate\V1\Rest\Entities;

use plate\EntitySupport\entity\Entity;
use plate\EntitySupport\entity\MappedSuperClassEntity;
use plate\V1\Rest\Entities\inheritance\DeviceEntity;
use plate\V1\Rest\Entities\inheritance\FloorEntity;
use plate\V1\Rest\Entities\inheritance\GroupEntity;
use plate\V1\Rest\Entities\inheritance\RoomEntity;
use plate\V1\Rest\Entities\inheritance\ScheduledEntity;
use plate\V1\Rest\Entities\inheritance\ScheduledTimingEntity;

/**
 * Класс для маппинга сущностей (обязателен для REST API сервисов Apigility)
 * Class EntitiesEntity
 * @package plate\V1\Rest\Entities
 */
class EntitiesEntity extends MappedSuperClassEntity
{
    public static $mapperFieldName = 'type_enum';

    public static $mappingClassesCollection = [
        DeviceEntity::class, FloorEntity::class, GroupEntity::class, RoomEntity::class, ScheduledEntity::class, ScheduledTimingEntity::class
    ];

    public static function getFieldsMap(){
        return [
            'NAME' => 'name',
            'DESCRIPTION' => 'description',
            'NS_ID' => 'ns_id',
            'ENT_ID' => 'ent_id',
            'LEVEL' => 'level',
            'TYPE_NAME' => 'type_name',
            'TYPE' => 'type',
            'LKEY' => 'lkey',
            'RKEY' => 'rkey',
            'CONTAINER' => 'container',
            'IS_ALLOWED' => 'isAllowed',
            'IS_FAVORITE' => 'isFavorite'
        ];
    }
}
