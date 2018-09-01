<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2017
 * Time: 15:47
 */
namespace plate\EntityServicesSupport;

use Interop\Container\ContainerInterface;
use plate\Auth\AuthUtils;
use plate\EntityServicesSupport\ITableService;
use plate\EntitySupport\tableGateway\TableGatewayMapper;
use plate\EntityServicesSupport\IEntityService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ConnectionInterface;

abstract class EntityService implements IEntityService{
    protected   $authUtils,
                $iTableService,
                $tableMapper;

    use ApiProblems;

    /**
     * EntityService constructor.
     * @param AuthUtils $authUtils
     * @param ITableService $iTableService
     * @param TableGatewayMapper $mapper
     */
    public function __construct(AuthUtils $authUtils, ITableService $iTableService, TableGatewayMapper $mapper)
    {
        $this->setAuthUtils($authUtils);
        $this->setITableService($iTableService);
        $this->setTableMapper($mapper);
    }

    /**
     * Получить другой сервис
     * @param $serviceClass
     * @return mixed
     */
    public function getService($serviceClass){
        try {
            return $this->getServices()->get($serviceClass);
        } catch (NotFoundExceptionInterface $e) {
        } catch (ContainerExceptionInterface $e) {
        }
        return null;
    }

    /**
     * @return \Zend\Db\Sql\Select
     */
    public function generateBasicSelect(){
        return $this->getTableMapper()->generateBasicSelect();
    }

    /**
     * Коммит
     */
    protected function commitTransaction(){
        $this->getConnectionObjectFromTableMapper()->commit();
    }

    /**
     * Откат
     */
    protected function rollbackTransaction(){
        $this->getConnectionObjectFromTableMapper()->rollback();
    }

    /**
     * Начать транзакцию
     */
    protected function beginTransaction(){
        $this->getConnectionObjectFromTableMapper()->beginTransaction();
    }

    /**
     * Получаем объект ConnectionInterface для управления транзакциями
     * @return ConnectionInterface
     */
    protected function getConnectionObjectFromTableMapper(){
        return $this->getAdapter()->getDriver()->getConnection();
    }


    /**
     * @return ITableService
     */
    public function getITableService()
    {
        return $this->iTableService;
    }

    /**
     * @param ITableService $iTableService
     */
    public function setITableService($iTableService)
    {
        $this->iTableService = $iTableService;
    }

    /**
     * @return TableGatewayMapper
     */
    public function getTableMapper()
    {
        return $this->tableMapper;
    }

    /**
     * @param TableGatewayMapper $tableMapper
     */
    public function setTableMapper($tableMapper)
    {
        $this->tableMapper = $tableMapper;
    }

    /**
     * @return AuthUtils
     */
    public function getAuthUtils()
    {
        return $this->authUtils;
    }

    /**
     * @param AuthUtils $authUtils
     */
    public function setAuthUtils($authUtils)
    {
        $this->authUtils = $authUtils;
    }

    protected function getTableName(){
        return $this->getTableMapper()->getTable()->table;
    }

    protected function getIdFieldName(){
        return$this->getTableMapper()->getIdFieldName();
    }

    protected function getAdapter(){
        $adapter = new Adapter(
            $this->getTableMapper()->getTable()->getAdapter()->getDriver(),
            $this->getTableMapper()->getTable()->getAdapter()->getPlatform()
        );

        return $adapter;
    }
}