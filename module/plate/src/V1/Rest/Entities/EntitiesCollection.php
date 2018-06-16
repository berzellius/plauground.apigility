<?php
namespace plate\V1\Rest\Entities;

use plate\EntitySupport\collection\Collection;
use plate\EntitySupport\collection\NestedSetsCollection;
use Zend\Paginator\Paginator;

/**
 * Класс для маппинга коллекций (обязателен для работы REST API сервисов Apigility)
 * Class EntitiesCollection
 * @package plate\V1\Rest\Entities
 */
class EntitiesCollection extends NestedSetsCollection
{
    /**
     * имя таблицы, содержащей узлы иерархии наименьшего уровня для каждого элемента
     * @var string
     */
    public static $minimalLevelsTable = 'entity_hierarchy_by_ent_id';

    /**
     * имя поля таблицы $minimalLevelsTable, по которому производится поиск элемента
     */
    public static $minimalLevelsTableIdField = 'ent_id';

    /**
     * EntitiesCollection constructor.
     * @param \Zend\Paginator\Adapter\AdapterInterface|\Zend\Paginator\AdapterAggregateInterface $adapter
     */
    public function __construct($adapter)
    {
        parent::__construct($adapter);
        $this->setCollectionListName('entities');
        $this->setCollectionEntityName('entity');
    }


}
