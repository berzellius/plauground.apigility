<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 23.05.2018
 * Time: 21:45
 */

namespace plate\V1\Rest\Entities\inheritance;
use plate\V1\Rest\Entities\EntitiesEntity;

class DeviceEntity extends EntitiesEntity
{
    public static $type_enum = 'device';

    public static function getFieldsMap(){
        return array_merge(
            parent::getFieldsMap(),
            [
                'IP' => 'ip',
                'MAC' => 'mac',
                'CHANNEL' => 'channel',
                'DEVICE_TYPE' => 'device_type',
                'MAX_AMP' => 'max_amp',
                'CONNECTION_TYPE' => 'connection_type',
                'LAST_COMMAND' => 'last_command'
            ]
        );
    }

}