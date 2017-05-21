<?php

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2017
 * Time: 15:24
 */
namespace plate\EntityServicesSupport;


class ITableServiceFactory
{
    public function __invoke($services){
        return new TableService($services);
    }
}