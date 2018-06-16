<?php
namespace plate\V1\Rest\BasicHierarchy;

use plate\EntitySupport\collection\Collection;
use plate\EntitySupport\collection\NestedSetsCollection;
use Zend\Paginator\Paginator;

class BasicHierarchyCollection extends NestedSetsCollection
{
    /**
     * имя таблицы, содержащей узлы иерархии наименьшего уровня для каждого элемента
     * @var string
     */
    public static $minimalLevelsTable = 'basic_hierarchy_by_type_id';

    /**
     * имя поля таблицы $minimalLevelsTable, по которому производится поиск элемента
     */
    public static $minimalLevelsTableIdField = 'type_id';

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
