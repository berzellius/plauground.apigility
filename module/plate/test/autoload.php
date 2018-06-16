<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 26.05.2018
 * Time: 16:19
 */
chdir('.\..\..\..');

include_once 'vendor/autoload.php';
$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4("plate\\test\\", __DIR__, true);
$classLoader->register();