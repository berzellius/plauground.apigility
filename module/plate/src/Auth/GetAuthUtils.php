<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2017
 * Time: 16:45
 */

namespace plate\Auth;


use Interop\Container\ContainerInterface;

trait GetAuthUtils
{
    public function getAuthUtils(ContainerInterface $services){
        return $services->get(AuthUtils::class);
    }
}