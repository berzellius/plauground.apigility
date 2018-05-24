<?php
namespace plate\V1\Rest\Entities;

use plate\EntitySupport\collection\Collection;
use Zend\Paginator\Paginator;

/**
 * Класс для маппинга коллекций (обязателен для работы REST API сервисов Apigility)
 * Class EntitiesCollection
 * @package plate\V1\Rest\Entities
 */
class EntitiesCollection extends Collection
{
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
