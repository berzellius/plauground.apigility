<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 24.04.2017
 * Time: 0:16
 */

namespace plate\EntitySupport\resource;

use DomainException;
use Interop\Container\ContainerInterface;
use plate\Auth\AuthUtils;
use plate\Auth\GetAuthUtils;
use plate\ConfigSupport\ConfigReadHelper;
use plate\EntityServicesSupport\EntityService;
use plate\EntityServicesSupport\GetITableService;
use plate\EntityServicesSupport\ITableService;
use plate\EntitySupport\collection\Collection;
use plate\EntitySupport\tableGateway\TableGateway;
use plate\EntitySupport\tableGateway\TableGatewayMapper;
use plate\Hydrator\CustomHydratingResultSet;
use plate\Hydrator\CustomHydrator;
use plate\V1\Rest\BasicHierarchy\HierarchyTypes;

/**
 * Class ResourceFactory
 * Реализует получение TableGateway и данных из секций module.config.php
 * Наследуется фабриками ресурсов
 * @package plate\EntitySupport
 */
class ResourceFactory
{
    use GetITableService, ConfigReadHelper, GetAuthUtils;

    /**
     * Порождающий метод
     * @param ContainerInterface $services
     * @param $resourceClass
     * @param $resourceFactory
     * @return DataRetrievingResource
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $services, $resourceClass, $resourceFactory){
        // определяем класс контроллера
        $controllerPath = $this->getControllerByResource($resourceClass);

        /**
         * Получим необходиме секции из modules.config.php
         * и загрузим сведения:
         * имя поля-идентификатора, классы collection и entity, имя коллекции
         */
        $halEntityProperties = $this->getZfHalEntityProperties($controllerPath);
        $zfRestEntityProperties = $this->getZfRestControllerSectionByControllerName($controllerPath);

        $idField = $halEntityProperties['entity_identifier_name'];
        $collectionClass = $zfRestEntityProperties['collection_class'];
        $entityClass = $zfRestEntityProperties['entity_class'];
        $configName = $zfRestEntityProperties['collection_name'];
        $referenceTables = isset($zfRestEntityProperties['referenceTables'])? $zfRestEntityProperties['referenceTables'] : false;
        $serviceClass = isset($zfRestEntityProperties['dao_service'])? $zfRestEntityProperties['dao_service'] : false;

        /**
         * получаем зарегистрированный маппер
         * этот маппер всегда можно будет получить
         * $this->getITableService($services)->getTableMapperByKey(EntitiesResource::class) в любой фабрике  или сервисе
         * getITableService($services) находится в трейте GetITableService
         */
        $tableGatewayMapper = $this->registerPersistenceMapping(
            $services, $configName, $resourceClass,  $idField, $collectionClass, $entityClass
        );


        /**
         * работаем с таблицами - справочниками
         */
        if($referenceTables && is_array($referenceTables)){
            foreach ($referenceTables as $referenceTable){
                $this->registerPersistenceMapping(
                    $services, $referenceTable['referenceConfig'], $referenceTable['entityClass'], $referenceTable['idField']
                );

                $refTable = $this->getITableService($services)->getTableNameByKey($referenceTable['entityClass']);
                $referenceTable['table'] = $refTable;
                $tableGatewayMapper->registerForeignTable($referenceTable);
            }
        }

        if($serviceClass){
            /**
             * @var EntityService
             */
            $DAOService = $services->get($serviceClass);
            $DAOService->setTableMapper($tableGatewayMapper);
            $resource = new $resourceClass($DAOService, $tableGatewayMapper);
        }
        else{
            $resource = new $resourceClass($tableGatewayMapper);
        }
        return $resource;
    }

    /**
     * Регистрация маппинга персистентных объектов с таблицами БД
     * @param ContainerInterface $services
     * @param $configName - имя секции конфигурации в global.php,
     * например
     * 'entities' => array( // имя секции, $configName
     *       'db' => 'oauth2_users', // псевдоним БД в конфигуации Apigility
     *       'table' => 'entities' // имя таблицы
     *  )
     * @param $resourceClass
     * @param $idField
     * @param mixed $collectionClass
     * @param mixed $entityClass
     * @return TableGatewayMapper
     */
    public function registerPersistenceMapping(
        ContainerInterface $services, $configName, $resourceClass, $idField,
        $collectionClass = false, $entityClass = false)
    {


        $tableGateway = $this->getTableGateway($services, $configName, $collectionClass, $entityClass);
        $tableGatewayMapper = new TableGatewayMapper($tableGateway);

        $authUtils = $this->getAuthUtils($services);
        $tableGatewayMapper->setAuthUtils($authUtils);

        $tableGatewayMapper->setIdField($idField);

        if(!!$collectionClass) {
            $tableGatewayMapper->setCollectionClass($collectionClass);
        }

        if(!!$entityClass) {
            $tableGatewayMapper->setEntityClass($entityClass);
        }


        /**
         * конфигурация должна быть прописана в global.php
         */
        $this->getITableService($services)->registerTableMapper($resourceClass, $tableGatewayMapper);

        return $tableGatewayMapper;
    }

    /**
     * Получить TableGateway
     * @param $services
     * @param $configPrefix - указывает на секцию в local.php, из которой нужно взять имя талицы БД и имя подключения к БД.
     * Подключения к БД можно создавать из веб-интерфейса apigility
     * @param bool $collectionClass
     * @param bool $entityClass
     * @return TableGateway
     */
    public function getTableGateway($services, $configPrefix,
                                    $collectionClass = false, $entityClass = false){

        $config = $services->get('config');

        if(!isset($config[$configPrefix])){
            throw new DomainException(sprintf(
                'Unable to create %s due to missing "%s" configuration section in global.php',
                TableGateway::class,
                $configPrefix
            ));
        }
        $config = $config[$configPrefix];


        if(!isset($config['db']) || !isset($config['table'])){
            throw new DomainException(sprintf(
                'Unable to create %s due to missing "%s" or "%s" parameter in configuration section',
                TableGateway::class,
                "db",
                "table"
            ));
        }

        $db = $config['db'];
        $table = $config['table'];

        if(!!$collectionClass && !!$entityClass){
            $hydrator = new CustomHydrator();

            $hydtratingResultSet = new CustomHydratingResultSet($hydrator, new $entityClass(), $collectionClass);

            return new TableGateway($table, $services->get($db), null, $hydtratingResultSet);
        }
        else{
            return new TableGateway($table, $services->get($db));
        }

    }
}