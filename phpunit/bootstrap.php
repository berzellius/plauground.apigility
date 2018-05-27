<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 26.05.2018
 * Time: 16:19
 */

include_once __DIR__ . '/../vendor/autoload.php';


$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4("plate\\test\\", __DIR__ . '/../module/plate/test', true);
$classLoader->addPsr4("plate\\", __DIR__ . '/../module/plate/src', true);
$classLoader->register();

