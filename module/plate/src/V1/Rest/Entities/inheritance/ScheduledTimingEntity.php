<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 02.09.2018
 * Time: 18:11
 */

namespace plate\V1\Rest\Entities\inheritance;


use plate\V1\Rest\Entities\EntitiesEntity;

class ScheduledTimingEntity extends EntitiesEntity
{
    public static $type_enum = 'timing';

    public static function getFieldsMap(){
        return array_merge(
            parent::getFieldsMap(),
            [
                'TIME' => 'time',
                'COMMAND' => 'command',
                'LOGO_URL' => 'logoUrl'
            ]
        );
    }
}