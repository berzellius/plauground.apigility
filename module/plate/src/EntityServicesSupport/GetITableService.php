<?php

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2017
 * Time: 16:01
 */
namespace plate\EntityServicesSupport;

use Interop\Container\ContainerInterface;

trait GetITableService
{
    /**
     * @param $service
     * @return ITableService
     */
    public function getITableService(ContainerInterface $service){
        return $service->get(ITableService::class);
    }
}