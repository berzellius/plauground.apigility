<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 24.05.2018
 * Time: 0:14
 */

namespace plate\Organizer;


use bar\baz\source_with_namespace;
use Iterator;
use plate\EntitySupport\collection\Collection;
use plate\EntitySupport\collection\NestedSetsCollection;
use Zend\Paginator\Paginator;

abstract class Organizer
{
    /**
     * @var string
     */
    protected $collectionPrototypeClass;

    /**
     * Organizer constructor.
     * @param string $collectionPrototypeClass
     */
    public function __construct($collectionPrototypeClass)
    {
        $this->setCollectionPrototypeClass($collectionPrototypeClass);
    }

    /**
     * @param $collectionPrototypeClass
     * @return NestedSetsOrganizer|PlainOrganizer
     */
    public static function getOrganizer($collectionPrototypeClass){
        if(in_array(NestedSetsCollection::class, class_parents($collectionPrototypeClass))){
            return new NestedSetsOrganizer($collectionPrototypeClass);
        }

        return new PlainOrganizer($collectionPrototypeClass);
    }



    /**
     * @param Iterator $iterator
     * @param Collection $collectionPrototypeClass
     * @return array
     */
    public abstract function organize(Iterator $iterator, $collectionPrototypeClass = null);

    /**
     * @return string
     */
    public function getCollectionPrototypeClass()
    {
        return $this->collectionPrototypeClass;
    }

    /**
     * @param string $collectionPrototypeClass
     */
    public function setCollectionPrototypeClass($collectionPrototypeClass)
    {
        $this->collectionPrototypeClass = $collectionPrototypeClass;
    }
}