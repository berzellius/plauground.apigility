<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2018
 * Time: 18:49
 */

namespace plate\ConfigSupport;


use DomainException;

trait ConfigReadHelper
{
    protected function getConfig()
    {
        return include 'module/plate/config/module.config.php'; ///../../../../config/module.config.php';
    }

    /**
     * Содержимое секции zf-hal для данного контроллера
     * @param $controllerName
     * @return mixed
     */
    public function getZfHalEntityProperties($controllerName){
        $controllerSection = $this->getZfRestControllerSectionByControllerName($controllerName);
        $entityClass = $controllerSection['entity_class'];
        $moduleConfig =  $this->getConfig();
        $zfHalSection = $this->getConfigSection(array("zf-hal", "metadata_map", $entityClass), $moduleConfig, "");

        return $zfHalSection;
    }

    /**
     * Ищем, какой Controller соответствует данному Resource
     * zf-rest ->
     *      Controller ->
     *          listener = Resource
     * @param $resourceClass
     * @return int|string
     */
    protected function getControllerByResource($resourceClass){
        $moduleConfig = $this->getConfig();
        $zf_rest = $this->getConfigSection(['zf-rest'], $moduleConfig, "");

        foreach ($zf_rest as $controller => $properties){
            if($properties['listener'] == $resourceClass){
                return $controller;
            }
        }
        return null;
    }

    /**
     * Ищем, какой контроллер соответствует запрошенному dao-сервису
     * @param $serviceClass
     * @return int|null|string
     */
    protected function getControllerByService($serviceClass){
        $moduleConfig = $this->getConfig();
        $zf_rest = $this->getConfigSection(['zf-rest'], $moduleConfig, "");

        foreach ($zf_rest as $controller => $properties){
            if(isset($properties['dao_service']) && $properties['dao_service'] == $serviceClass){
                return $controller;
            }
        }
        return null;
    }

    /**
     * Содержимое секции zf-rest для данного контроллера
     * @param $controllerName
     * @return mixed
     */
    protected function getZfRestControllerSectionByControllerName($controllerName){
        $moduleConfig =  $this->getConfig();
        $controllerSection = $this->getConfigSection(array("zf-rest", $controllerName), $moduleConfig, "");

        return $controllerSection;
    }

    /**
     * Получить данные в конфигурационном файле по пути
     * @param array $path - путь - массив ключей, по которому на проследовать
     * @param $initSection - с какой секции начинаем
     * @param $initPath - с какого пути начинаем [some-key][other-key]..[..]
     * @return mixed
     */
    protected function getConfigSection(array $path, $initSection, $initPath){
        $currentConfigSection = $initSection;
        $currentPath = $initPath;

        $this->checkCurrentSection($currentConfigSection, $currentPath);

        foreach($path as $part){
            $currentConfigSection = $currentConfigSection[$part];
            $currentPath = $currentPath . '[' . $part . ']';

            // проверяем содержимое секции
            $this->checkCurrentSection($currentConfigSection, $currentPath);
        }

        return $currentConfigSection;
    }

    /**
     * Если секция не существует, бросаем исключение с описанием
     * @param $currentConfigSection
     * @param $currentPath
     */
    protected function checkCurrentSection($currentConfigSection, $currentPath){
        if(!$currentConfigSection){
            throw new DomainException(sprintf(
                'Unable to get %s properties from %s due to missing %s section in file %s',
                $currentPath,
                "module.config.php",
                $currentPath,
                "module.config.php"
            ));
        }
    }
}