<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 23.05.2018
 * Time: 21:45
 */

namespace plate\V1\Rest\Entities\inheritance;
use plate\V1\Rest\Entities\EntitiesEntity;

class ScheduledEntity extends EntitiesEntity
{
    public static $type_enum = 'scheduled';
}