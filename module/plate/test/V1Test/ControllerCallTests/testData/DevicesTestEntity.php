<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 04.06.2017
 * Time: 16:17
 */

namespace V1Test\Rest\testData;

class DevicesTestEntity extends TestEntity
{
    public static $baseUrl = "/devices";

    public function __construct($id, $data, $scope, $user)
    {
        parent::__construct($id, $data, $scope, $user);
    }
}