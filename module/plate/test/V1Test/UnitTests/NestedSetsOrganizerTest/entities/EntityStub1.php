<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 26.05.2018
 * Time: 18:57
 */

namespace plate\test\V1Test\UnitTests\NestedSetsOrganizerTest\entities;


use plate\EntitySupport\entity\Entity;

abstract class EntityStub1 extends Entity{
    public $lkey;
    public $rkey;
    public $level;
    public $container = 'entities';
    public $allowed;
}