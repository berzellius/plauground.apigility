<?php
namespace plate\V1\Rest\Entities;

use plate\EntitySupport\collection\Collection;
use plate\EntitySupport\collection\NestedSetsCollection;
use Rhumsaa\Uuid\Console\Exception;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Join;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
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
     * свойства элементов в контексте пользователя. например, "данный элемент добавлен пользователем в избранное"
     * @var string
     */
    public static $userContextProperitesTable = 'entities_user_context';

    /**
     * имя поля таблицы $minimalLevelsTable, по которому производится поиск элемента
     * @var string
     */
    public static $minimalLevelsTableIdField = 'ent_id';

    /**
     * имя поля, содержащего флаг "заходить внутрь узла"
     * @var string
     */
    public static $passInNodeFieldName = 'isAllowed';

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
                    [
                        'isFavorite' => new Expression('COALESCE(uc.isFavorite, 0) | types.force_favorite'),
                        'isAllowed' => new Expression('COALESCE(uc.isAllowed, 0) | types.force_allowed')
                    ],
                    Join::JOIN_LEFT
                )
                ->where(new \Zend\Db\Sql\Predicate\Expression("uc.user = '" .$clientId . "'" ))
            ;
        }

        return $select;
    }
}
