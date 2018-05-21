<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 20.05.2018
 * Time: 22:55
 */

namespace plate\V1\Rest\Entities;


use Interop\Container\ContainerInterface;
use plate\Auth\GetAuthUtils;
use plate\EntityServicesSupport\GetITableService;

/**
 * Class EntitiesServiceFactory
 * @package plate\V1\Rest\Entities
 */
class EntitiesServiceFactory
{
    use GetITableService,
        GetAuthUtils;

    /**
     * Фабричный метод для порождения сервиса
     * @param ContainerInterface $services
     * @return EntitiesService
     */
    public function __invoke(ContainerInterface $services)
    {
        $iTableService = $this->getITableService($services);
        // получить зарегистрированный mapper. Так мы можем получать мапперы любых объектов
        $mapper = $iTableService->getTableMapperByKey(EntitiesResource::class);
        $authUtils = $this->getAuthUtils($services);

        return new EntitiesService($authUtils, $iTableService, $mapper);
    }
}