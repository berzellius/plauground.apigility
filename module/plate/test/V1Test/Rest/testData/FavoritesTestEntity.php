<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 04.06.2017
 * Time: 16:17
 */

namespace V1Test\Rest\testData;

class FavoritesTestEntity extends TestEntity
{
    public static $baseUrl = "/favorites";

    public function __construct($id, $data, $scope, $user)
    {
        parent::__construct($id, $data, $scope, $user);
    }
}