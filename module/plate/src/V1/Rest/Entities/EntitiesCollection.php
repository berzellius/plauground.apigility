<?php
namespace plate\V1\Rest\Entities;

use plate\EntitySupport\collection\Collection;
use plate\EntitySupport\collection\NestedSetsCollection;
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
                        'isFavorite' => new Expression('case when uc.isFavorite is null then 0 else uc.isFavorite end'),
                        'isAllowed' => new Expression('case when uc.isAllowed is null then 0 else uc.isAllowed end')
                    ],
                    Join::JOIN_LEFT
                )
                ->where(new \Zend\Db\Sql\Predicate\Expression("uc.user = '" .$clientId . "'" ))
                //->where(new \Zend\Db\Sql\Predicate\Expression("uc.isAllowed = 1"), Predicate::COMBINED_BY_AND)
            ;
        }

        return $select;
    }

    /**
     * @param Select $select
     * @param $tableName
     * @param $idField
     * @param $levelDepth
     * @param array $typeList
     * @return Select
     */
    public static function selectFavoritesByMaxLevelDepthAndTypeList(Select $select, $tableName, $idField, $levelDepth, array $typeList = []){
        $select = self::selectByMaxLevelDepthWithJoiningTable(
            $select, $tableName, $idField, $levelDepth
        );

        $select = self::selectTypes($select, $typeList);

        $select = self::selectFavorites($select);

        return $select;
    }

    /**
     * @param $select
     * @return Select
     */
    protected static function selectFavorites(Select $select)
    {
        $select
            ->where("uc.isFavorite = 1", Where::OP_AND);

        return $select;
    }
}
