<?php
namespace plate\V1\Rest\BasicHierarchy;

use plate\EntitySupport\collection\Collection;
use plate\EntitySupport\collection\NestedSetsCollection;
use Zend\Paginator\Paginator;

class BasicHierarchyCollection extends NestedSetsCollection
{

    /**
     * BasicHierarchyCollection constructor.
     * @param \Zend\Paginator\Adapter\AdapterInterface|\Zend\Paginator\AdapterAggregateInterface $adapter
     */
    public function __construct($adapter)
    {
        parent::__construct($adapter);
        $this->setCollectionListName('basic_hierarchy');
        $this->setCollectionEntityName('basic_hierarchy_node');
    }
}
