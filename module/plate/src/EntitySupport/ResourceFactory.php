<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 24.04.2017
 * Time: 0:16
 */

namespace plate\EntitySupport;

use DomainException;
use plate\EntitySupport\TableGateway;

abstract class ResourceFactory
{

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

    public function getZfHalEntityProperties($controllerName){
        $controllerSection = $this->getZfRestControllerSectionByControllerName($controllerName);
        $entityClass = $controllerSection['entity_class'];
        $moduleConfig =  $this->getConfig();
        $zfHalSection = $this->getConfigSection(array("zf-hal", "metadata_map", $entityClass), $moduleConfig, "");

        return $zfHalSection;
    }

    private function getZfRestControllerSectionByControllerName($controllerName){
        $moduleConfig =  $this->getConfig();
        $controllerSection = $this->getConfigSection(array("zf-rest", $controllerName), $moduleConfig, "");

        return $controllerSection;
    }

    private function getConfigSection(array $path, $initSection, $initPath){
        $currentConfigSection = $initSection;
        $currentPath = $initPath;

        $this->checkCurrentSection($currentConfigSection, $currentPath);

        foreach($path as $part){
            $currentConfigSection = $currentConfigSection[$part];
            $currentPath = $currentPath . '[' . $part . ']';

            $this->checkCurrentSection($currentConfigSection, $currentPath);
        }

        return $currentConfigSection;
    }

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