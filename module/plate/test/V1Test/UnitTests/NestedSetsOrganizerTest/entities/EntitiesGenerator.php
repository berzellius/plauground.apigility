<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 26.05.2018
 * Time: 20:48
 */

namespace plate\test\V1Test\UnitTests\NestedSetsOrganizerTest\entities;
use plate\EntitySupport\entity\Entity;

/**
 * Class EntitiesGenerator
 * @package plate\test\V1Test\UnitTests\organizer\NestedSetsOrganizerTest\entities
 */
class EntitiesGenerator
{
    /**
     * @var array
     */
    protected $entities;

    protected $collectionClass;

    public function __construct($collectionClass)
    {
        $this->setCollectionClass($collectionClass);
    }

    public function add($class, $lkey, $rkey, $level){
        $entity = new $class;
        $collectionClass = $this->getCollectionClass();

        $lkeyField = $collectionClass::$lkeyField;
        $rkeyField = $collectionClass::$rkeyField;
        $levelField = $collectionClass::$levelField;

        $entity->{$lkeyField} = $lkey;
        $entity->{$rkeyField} = $rkey;
        $entity->{$levelField} = $level;

        $this->entities[] = $entity;

        return $this;
    }

    public function iterator(){
        return new \ArrayIterator($this->getEntities());
    }

    public static function getInstance($collectionClass){
        return new EntitiesGenerator($collectionClass);
    }

    /**
     * @return mixed
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @param mixed $entities
     */
    public function setEntities($entities)
    {
        $this->entities = $entities;
    }

    /**
     * @return mixed
     */
    public function getCollectionClass()
    {
        return $this->collectionClass;
    }

    /**
     * @param mixed $collectionClass
     */
    public function setCollectionClass($collectionClass)
    {
        $this->collectionClass = $collectionClass;
    }
}