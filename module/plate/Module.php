<?php
namespace plate;

use ZF\Apigility\Provider\ApigilityProviderInterface;

/**
 * Class Module
 * hello berz
 * @package plate
 */
class Module implements ApigilityProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'ZF\Apigility\Autoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }
}
