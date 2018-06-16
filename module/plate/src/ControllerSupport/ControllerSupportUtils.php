<?php

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 14.06.2017
 * Time: 21:09
 */
namespace plate\ControllerSupport;

use Exception;

class ControllerSupportUtils
{
    public static function assertParameterSet($params, $name, $message){
        if(!isset($params[$name])){
            throw new Exception($message);
        }
        return $params[$name];
    }

    public static function assertOnlyOneParameterIsSet(array $params, array $names, $message){
        $c = 0;

        foreach ($names as $k){
            if(isset($params[$k])){
                $c++;
                if($c > 1) throw new Exception($message);
            }
        }

        if($c == 0)
            throw new Exception($message);
    }

    public static function getArrayFromCommaDelimitedString($types)
    {
        return explode(',', $types);
    }
}