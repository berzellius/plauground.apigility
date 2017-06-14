<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 11.06.2017
 * Time: 21:13
 */

namespace plate\EntityServicesSupport;


use Interop\Container\ContainerInterface;

class EntitiesUtilsFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new EntitiesUtils();
    }
}