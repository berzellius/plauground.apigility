<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 24.05.2018
 * Time: 0:17
 */

namespace plate\Organizer;


use Iterator;
use plate\EntitySupport\collection\Collection;

class NestedSetsOrganizer extends Organizer
{

    /**
     * @param Iterator $iterator
     * @param string $collectionPrototypeClass
     * @return array
     */
    public function organize(Iterator $iterator, $collectionPrototypeClass = null)
    {
        $collectionPrototypeClass = ($this->getCollectionPrototypeClass() != null)? $this->getCollectionPrototypeClass() : ($collectionPrototypeClass != null)? $collectionPrototypeClass : null;

        // TODO: пока что, для пробы - обычная сортировка
        $res = ['res1' => []];
        foreach ($iterator as $item) {
            $res['res1'][] = $item;
        }

        return $res;
    }
}