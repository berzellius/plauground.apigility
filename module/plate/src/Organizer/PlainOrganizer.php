<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 24.05.2018
 * Time: 0:15
 */

namespace plate\Organizer;


use Iterator;
use plate\EntitySupport\collection\Collection;

class PlainOrganizer extends Organizer
{

    /**
     * @param Iterator $iterator
     * @param string $collectionPrototypeClass
     * @return array
     */
    public function organize(Iterator $iterator, $collectionPrototypeClass = null)
    {
        $collectionPrototypeClass = ($this->getCollectionPrototypeClass() != null)? $this->getCollectionPrototypeClass() : ($collectionPrototypeClass != null)? $collectionPrototypeClass : null;

        $res = [];
        foreach ($iterator as $item) {
            $res[] = $item;
        }

        return $res;
    }
}