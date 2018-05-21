<?php
namespace plate\V1\Rest\Entities;

use Interop\Container\ContainerInterface;
use plate\EntitySupport\ResourceFactory;
use plate\EntitySupport\TableGatewayMapper;

/**
 * Фабрика для контроллера REST API сервиса Entities
 * EntitiesResource - это контроллер
 * Class EntitiesResourceFactory
 * @package plate\V1\Rest\Entities
 */
class EntitiesResourceFactory extends ResourceFactory
{
    /**
     * Порождающий метод
     * @param ContainerInterface $services
     * @return EntitiesResource
     */
    public function __invoke(ContainerInterface $services)
    {
        /**
         * получаем зарегистрированный маппер
         * этот маппер всегда можно будет получить
         * $this->getITableService($services)->getTableMapperByKey(EntitiesResource::class) в любой фабрике  или сервисе
         * getITableService($services) находится в трейте GetITableService
         */
        $tableGatewayMapper = $this->registerPersistenceMapping(
            $services, "entities", "plate\\V1\\Rest\\Entities\\Controller", EntitiesResource::class);

        return new EntitiesResource(
            // сервис для реализации бизнес-логики
            $this->getEntitiesService($services),
            $tableGatewayMapper
        );
    }

    /**
     * получить объект с сервисом. фабрика порождения сервиса должна быть описана в modules.config.php
     * в сеции service_manager
     * @param $services
     * @return EntitiesService
     */
    protected function getEntitiesService(ContainerInterface $services){
        $entitiesService =  $services->get(EntitiesService::class);
        return $entitiesService;
    }
}
