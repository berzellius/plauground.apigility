<?php

namespace  plate\test\V1Test\UnitTests\NestedSetsOrganizerTest\entities;
use plate\EntitySupport\collection\NestedSetsCollection;

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 26.05.2018
 * Time: 18:56
 */
class CollectionStub1 extends NestedSetsCollection{
    public static $lkeyField = 'lkey';
    public static $rkeyField = 'rkey';
    public static $levelField = 'level';
    public static $containerField = 'container';
    public static $passInNodeFieldName = 'allowed';
}