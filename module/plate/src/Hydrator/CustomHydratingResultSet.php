<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 24.05.2018
 * Time: 0:08
 */

namespace plate\Hydrator;


use plate\EntitySupport\collection\Collection;
use plate\EntitySupport\entity\Entity;
use plate\Organizer\Organizer;
use Rhumsaa\Uuid\Console\Exception;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\HydratorInterface;
use ZF\ApiProblem\ApiProblem;

class CustomHydratingResultSet extends HydratingResultSet
{
    /**
     * @var Collection
     */
    protected $collectionPrototypeClass;

    /**
     * CustomHydratingResultSet constructor.
     * @param HydratorInterface $hydrator
     * @param null $objectPrototype
     * @param $collectionPrototypeClass
     */
    public function __construct(HydratorInterface $hydrator = null, $objectPrototype = null, $collectionPrototypeClass = null)
    {
        $this->collectionPrototypeClass = $collectionPrototypeClass;
        parent::__construct($hydrator, $objectPrototype);
    }

    public function toObjectsArray(){
        $organized = Organizer::getOrganizer($this->collectionPrototypeClass)->organize($this);

        if(is_array($organized) && count($organized) == 1){
            $organized = $organized[0];
        }

        return ['response' => $organized];
    }

    public function toArray()
    {
        return $this->toArrayOneLevel($this->toObjectsArray());
    }

    protected function toArrayOneLevel($objectsArr){
        $return = [];
        foreach ($objectsArr as $key => $row) {
            $e = (is_array($row))?
                $this->toArrayOneLevel($row) : $this->hydrator->extract($row);

            if(preg_match("/^([0-9]+)$/", $key))
                $return[] = $e;
            else
                $return[$key] = $e;
        }
        return $return;
    }
}