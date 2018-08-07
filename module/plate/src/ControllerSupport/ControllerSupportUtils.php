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
    /**
     * @param $params
     * @param $name
     * @param $message
     * @return mixed
     * @throws Exception
     */
    public static function assertParameterSet($params, $name, $message){
        if(!isset($params[$name])){
            throw new Exception($message);
        }
        return $params[$name];
    }

    /**
     * @param array $params
     * @param array $names
     * @param $message
     * @throws Exception
     */
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

    /**
     * @param array $params
     * @param array $names
     * @param $message
     * @throws Exception
     */
    public static function assertOneOrZeroParamatersIsSet(array $params, array $names, $message){
        $c = 0;

        foreach ($names as $k){
            if(isset($params[$k])){
                $c++;
                if($c > 1) throw new Exception($message);
            }
        }
    }

    public static function getArrayFromCommaDelimitedString($types)
    {
        return explode(',', $types);
    }

    /**
     * @param $params
     * @param $name
     * @param array $haystack
     * @param $message
     * @return mixed
     * @throws Exception
     */
    public static function assertParameterSetAndValueInArray($params, $name, array $haystack, $message){
        $value = self::assertParameterSet($params, $name, $message);

        if(! in_array($params[$name], $haystack)){
            throw new Exception($message);
        }

        return $value;
    }
}