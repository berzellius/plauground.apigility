<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 24.04.2017
 * Time: 0:16
 */

namespace plate\EntitySupport;

use DomainException;
use plate\EntityServicesSupport\GetITableService;
use plate\EntityServicesSupport\ITableService;
use plate\EntitySupport\TableGateway;

/**
 * Class ResourceFactory
 * Реализует получение TableGateway и данных из секций module.config.php
 * Наследуется фабриками ресурсов
 * @package plate\EntitySupport
 */
abstract class ResourceFactory
{
    use GetITableService;

    /**
     * Получить TableGateway
     * @param $services
     * @param $configPrefix - указывает на секцию в local.php, из которой нужно взять имя талицы БД и имя подключения к БД.
     * Подключения к БД можно создавать из веб-интерфейса apigility
     * @return \plate\EntitySupport\TableGateway
     */
    public function getTableGateway($services, $configPrefix){

        $config = $services->get('config');

        if(!isset($config[$configPrefix])){
            throw new DomainException(sprintf(
                'Unable to create %s due to missing "%s" configuration section',
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

        return new TableGateway($table, $services->get($db));
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
     * Содержимое секции zf-rest для данного контроллера
     * @param $controllerName
     * @return mixed
     */
    private function getZfRestControllerSectionByControllerName($controllerName){
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
    private function getConfigSection(array $path, $initSection, $initPath){
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
    private function checkCurrentSection($currentConfigSection, $currentPath){
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

    private function getConfig()
    {
        return include 'module/plate/config/module.config.php'; ///../../../../config/module.config.php';
    }
}