<?php
use V1Test\Rest\testData\TestEntity;

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 09.06.2017
 * Time: 22:29
 */
class TestRpcEntity extends TestEntity
{
    /**
     * @return bool
     */
    public function deleteOnCleanUp()
    {
        return false;
    }
}