<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 22.05.2018
 * Time: 21:26
 */

namespace plate\EntityServicesSupport;

use Interop\Container\ContainerInterface;
use plate\Auth\GetAuthUtils;
use plate\ConfigSupport\ConfigReadHelper;

/**
 * Class ServiceFactory
 * @package plate\EntityServicesSupport
 */
class ServiceFactory
{
    use GetITableService,
        GetAuthUtils,
        ConfigReadHelper;

    /**
     * Фабричный метод для порождения сервиса
     * @param ContainerInterface $services
     * @param $serviceClass
     * @param $serviceFactory
     * @return EntityService
     */
    public function __invoke(ContainerInterface $services, $serviceClass, $serviceFactory)
    {
        /**
         * строим фабрику аналогично фабрике ресурсов
         * т.е. мы должны получить запрашиваемый класс и сгенерить его
         */


        $controllerPath = $this->getControllerByService($serviceClass);
        $zfRestEntityProperties = $this->getZfRestControllerSectionByControllerName($controllerPath);
        $resourceClass = $zfRestEntityProperties['listener'];

        $iTableService = $this->getITableService($services);
        // получить зарегистрированный mapper. Так мы можем получать мапперы любых объектов
        $mapper = $iTableService->getTableMapperByKey($resourceClass);
        $authUtils = $this->getAuthUtils($services);

        // определяем класс контроллера
        return new $serviceClass($authUtils, $iTableService, $mapper);
    }
}