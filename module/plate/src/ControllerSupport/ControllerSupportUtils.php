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
}