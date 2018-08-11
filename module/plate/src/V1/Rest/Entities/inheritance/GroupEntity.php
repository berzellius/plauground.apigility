<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 23.05.2018
 * Time: 21:45
 */

namespace plate\V1\Rest\Entities\inheritance;
use plate\V1\Rest\Entities\EntitiesEntity;

class GroupEntity extends EntitiesEntity
{
    public static $type_enum = 'group';

    public static function getFieldsMap(){
        return array_merge(
            parent::getFieldsMap(),
            [
                'LAST_COMMAND' => 'last_command'
            ]
        );
    }
}