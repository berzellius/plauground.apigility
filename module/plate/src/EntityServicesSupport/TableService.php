<?php

namespace plate\EntityServicesSupport;
use Interop\Container\ContainerInterface;
use plate\EntityServicesSupport\ITableService;
use plate\V1\Rest\Scheduled_tasks\Scheduled_tasksResource;

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2017
 * Time: 15:23
 */
class TableService implements ITableService
{
    protected $services;

    /**
     * TableService constructor.
     * @param $services
     */
    public function __construct($services)
    {
        $this->services = $services;
    }

    /**
     * @return ContainerInterface
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param ContainerInterface $services
     */
    public function setServices($services)
    {
        $this->services = $services;
    }



    /**
     * @var array
     */
    protected $tableMappersStorage = array();

    /**
     * @return array
     */
    public function getTableMappersStorage()
    {
        return $this->tableMappersStorage;
    }

    /**
     * @param array $tableMappersStorage
     */
    public function setTableMappersStorage($tableMappersStorage)
    {
        $this->tableMappersStorage = $tableMappersStorage;
    }


    /**
     * Зарегистрировать mapper таблицы для общего использования
     * @param string $key
     * @param \plate\EntitySupport\TableGatewayMapper $mapper
     * @return void
     */
    public function registerTableMapper($key, $mapper)
    {
        $stor = $this->getTableMappersStorage();
        $stor[$key] = $mapper;
        $this->setTableMappersStorage($stor);
    }

    /**
     * Получить зарегистрированный mapper по ключу
     * @param $key
     * @return \plate\EntitySupport\TableGatewayMapper
     */
    public function getTableMapperByKey($key)
    {

        if(isset($this->getTableMappersStorage()[$key])){
            return $this->getTableMappersStorage()[$key];
        }
        else{
            $resource = $this->getServices()->get($key);
            return $this->getTableMappersStorage()[$key];
            //return null;
        }
    }

    /**
     * Получить имя таблицы по ключу mapper'а
     * @param $key
     * @return string
     */
    public function getTableNameByKey($key)
    {
        $mapper = $this->getTableMapperByKey($key);
        if($mapper == null){
            return null;
        }

        return $mapper->getTable()->table;
    }

    /**
     * Получить имя поля идентификатора сущности по ключу
     * @param $key
     * @return string
     */
    public function getTableIdFieldName($key)
    {
        $mapper = $this->getTableMapperByKey($key);
        if($mapper == null){
            return null;
        }

        return $mapper->getIdFieldName();
    }
}