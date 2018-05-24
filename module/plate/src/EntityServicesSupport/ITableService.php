<?php

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2017
 * Time: 15:23
 */
namespace plate\EntityServicesSupport;

use plate\EntitySupport\tableGateway\TableGatewayMapper;

interface ITableService
{
    /**
     * Зарегистрировать mapper таблицы для общего использования
     * @param string $key
     * @param TableGatewayMapper $mapper
     * @return void
     */
    public function registerTableMapper($key, $mapper);


    /**
     * Получить зарегистрированный mapper по ключу
     * @param $key
     * @return TableGatewayMapper
     */
    public function getTableMapperByKey($key);

    /**
     * Получить имя таблицы по ключу mapper'а
     * @param $key
     * @return string
     */
    public function getTableNameByKey($key);

    /**
     * Получить имя поля идентификатора сущности по ключу
     * @param $key
     * @return string
     */
    public function getTableIdFieldName($key);

}