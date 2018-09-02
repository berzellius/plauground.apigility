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


    public static function getFieldsMap(){
        return array_merge(
            parent::getFieldsMap(),
            [
                'WEEKDAYS' => 'weekdays',
            ]
        );
    }

    public static function transform($data){
        $data['weekdays'] = self::getBitmaskArray($data['weekdays']);
        return $data;
    }

    protected static function getBitmaskArray($weekdays){
        $res = [];
        $bin = strrev(decbin($weekdays));

        $offset = 0;
        while (($pos = strpos($bin, "1", $offset)) !== false){
            $res[] = $pos;
            $offset = $pos + 1;
        }

        return $res;
    }
}