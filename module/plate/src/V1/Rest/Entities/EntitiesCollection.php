<?php
namespace plate\V1\Rest\Entities;

use plate\EntitySupport\collection\Collection;
use plate\EntitySupport\collection\NestedSetsCollection;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Join;
use Zend\Db\Sql\Select;
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

    public static $userContextProperitesTable = 'entities_user_context';

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

    /**
     * @param Select $select
     * @param $clientId
     * @param bool $isAdmin
     * @return Select
     */
    public static function processSelect(Select $select, $clientId = null, $isAdmin = false){
        $select = parent::processSelect($select, $clientId);

        if(! $isAdmin) {
            $select
                ->join(
                    ['uc' => self::$userContextProperitesTable],
                    't.ent_id = uc.ent_id',
                    ['isFavorite' => new Expression('case when uc.isFavorite is null then 0 else uc.isFavorite end')],
                    Join::JOIN_LEFT
                )
                ->where(new \Zend\Db\Sql\Predicate\Expression("uc.user = '" .$clientId . "' or uc.user is null" ));
        }

        return $select;
    }
}
