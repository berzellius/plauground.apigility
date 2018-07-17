<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace plate\EntitySupport\tableGateway;

use DomainException;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use plate\Auth\AuthUtils;
use plate\ConfigSupport\ConfigReadHelper;
use plate\EntitySupport\collection\Collection;
use plate\EntitySupport\entity\Entity;
use plate\EntitySupport\resource\MapperInterface;
use Traversable;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Join;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Adapter\DbTableGateway;
use Zend\Stdlib\ArrayUtils;

/**
 * Class TableGatewayMapper
 * маппер, реализующий стандартные CRUD методы
 * @package plate\EntitySupport
 */
class TableGatewayMapper implements MapperInterface
{
    use ConfigReadHelper;

    /**
     * @var TableGateway
     */
    protected $table;

    /**
     * @var String - имя поля идентификатора
     */
    protected $idField = 'id';

    /**
     * @var mixed - класс коллекции объектов
     */
    protected $collectionClass = Collection::class;

    /**
     * @var mixed - класс экземпляра объекта
     */
    protected $entityClass = Entity::class;

    /**
     *
     */
    protected $referenceTables = [];

    /**
     * @var AuthUtils
     */
    protected $authUtils;

    /**
     * @param TableGateway $table
     */
    public function __construct(TableGateway $table)
    {
        $this->table = $table;
    }

    /**
     * @param array $referenceTable
     * @throws \Exception
     */
    public function registerForeignTable(array $referenceTable){
        if(
            isset($referenceTable['entityClass']) && isset($referenceTable['idField'])
            && isset($referenceTable['table']) && isset($referenceTable['referenceConfig'])
            && isset($referenceTable['foreignColumn'])
        ){
            $this->referenceTables[] = $referenceTable;
        }
        else{
            throw new \Exception("fatal error on adding reference table to tableGatewayMapper");
        }
    }

    /**
     * @param $rootId
     * @param null $levelDepth
     * @param array|null $typeList
     * @return Select
     * @throws \Exception
     * @internal param Select $select
     */
    public function generateSelectByRootElementIdAndMaxLevelDepthAndTypeList($rootId, $levelDepth = null, array $typeList = null){
        $selectMethodInCollection = "selectByRootElementIdAndMaxLevelDepthAndTypeList";

        if(method_exists($this->getCollectionClass(), $selectMethodInCollection)){
            $select = $this->generateBasicSelect();

            $cs = $this->getCollectionClass();
            $select = $cs::$selectMethodInCollection($select, $rootId, $levelDepth, $typeList);

            return $select;
        }
        else throw new \Exception("method " . $selectMethodInCollection . " not exists in " . $this->getCollectionClass());
    }

    /**
     * @param $rootId
     * @param int $levelDepth
     * @param array|null $typeList
     * @return Select
     * @throws \Exception
     * @internal param Select $select
     */
    public function generateSelectByRootNodeIdAndMaxLevelDepthAndTypeList($rootId, $levelDepth = null, array $typeList = []){
        $selectMethodInCollection = "selectByRootNodeIdAndMaxLevelDepthAndTypeList";

        if(method_exists($this->getCollectionClass(), $selectMethodInCollection)){
            $select = $this->generateBasicSelect();

            $cs = $this->getCollectionClass();
            $select = $cs::$selectMethodInCollection($select, $this->getTable()->table, $this->getIdField(), $rootId, $levelDepth, $typeList);

            return $select;
        }
        else throw new \Exception("method " . $selectMethodInCollection . " not exists in " . $this->getCollectionClass());
    }


    /**
     * @param int $levelDepth
     * @param array $typeList
     * @return Select
     * @throws \Exception
     */
    public function generateSelectByMaxLevelDepthAndTypeList($levelDepth = null, array $typeList = []){
        $selectMethodInCollection = "selectByMaxLevelDepthAndTypeList";

        if(method_exists($this->getCollectionClass(), $selectMethodInCollection)){
            $select = $this->generateBasicSelect();

            $cs = $this->getCollectionClass();
            $select = $cs::$selectMethodInCollection($select, $this->getTable()->table, $this->getIdField(), $levelDepth, $typeList);

            return $select;
        }
        else throw new \Exception("method " . $selectMethodInCollection . " not exists in " . $this->getCollectionClass());
    }


    /**
     * @param $typesList
     * @return Select
     * @throws \Exception
     */
    public function generateSelectByTypesOnly($typesList)
    {
        $selectMethodInCollection = "selectByTypesOnly";

        if(method_exists($this->getCollectionClass(), $selectMethodInCollection)){
            $select = $this->generateBasicSelect();

            $cs = $this->getCollectionClass();
            $select = $cs::$selectMethodInCollection($select, $this->getTable()->table, $this->getIdField(), $typesList);

            return $select;
        }
        else throw new \Exception("method " . $selectMethodInCollection . " not exists in " . $this->getCollectionClass());
    }

    /**
     * @return Select
     */
    public function generateBasicSelect(){
        $select = new Select();
        $select
            ->from(['t' => $this->getTable()->table]);

        if(is_array($this->referenceTables)){
            foreach ($this->referenceTables as $referenceTable){
                $foreignTable = isset($referenceTable['foreignTable'])? $referenceTable['foreignTable'] : "t";

                $select->join(
                    [$referenceTable['referenceConfig'] => $referenceTable['table']],
                    $foreignTable . "." . $referenceTable['foreignColumn'] . " = " . $referenceTable['referenceConfig'] . "." . $referenceTable['idField'],
                    [Select::SQL_STAR],
                    Join::JOIN_LEFT
                );
            }
        }

        if(method_exists($this->getCollectionClass(), 'processSelect')){
            $clientId =  $this->getAuthUtils()->getClientId();
            $isAdmin = (null !== $this->getAuthUtils()->checkAdminPrivileges() && $this->getAuthUtils()->checkAdminPrivileges());

            $cs = $this->getCollectionClass();
            $select = (null !== $clientId)?
                $cs::processSelect($select, $clientId, $isAdmin) : $cs::processSelect($select);
        }

        return $select;
    }

    /**
     * Соответствует полю Entity identifier name вкладки General Settings веб-интерфейса Apigility
     * @return string
     */
    public function getIdFieldName(){

        return $this->getIdField();
    }

    /**
     * @param array|Traversable|\stdClass $data
     * @return array|\ArrayObject|null
     */
    public function create($data)
    {
        if ($data instanceof Traversable) {
            $data = ArrayUtils::iteratorToArray($data);
        }
        if (is_object($data)) {
            $data = (array) $data;
        }

        if (! is_array($data)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid data provided to %s; must be an array or Traversable',
                __METHOD__
            ));
        }
       
        $this->table->insert($data);
        $id = $this->table->lastInsertValue;
        $idName = $this->getIdFieldName();
        $resultSet = $this->table->select([$idName => $id]);
        if (0 === count($resultSet)) {
            throw new DomainException('Insert operation failed or did not result in new row', 500);
        }
        // возвращаем только что созданную сущность
        return $resultSet->current();
    }

    /**
     * @param string $id
     * @return array|\ArrayObject|null
     */
    public function fetch($id)
    {
        /*if (! Uuid::isValid($id)) {
            throw new DomainException('Invalid identifier provided', 404);
        }*/
        $idName = $this->getIdFieldName();

        // параметры поиска: Entity identifier name == $id
        $resultSet = $this->table->select([$idName => $id]);
        if (0 === count($resultSet)) {
            throw new DomainException('Entity not found', 404);
        }
        return $resultSet->current();
    }

    /**
     * Получить все сущности по фильтру.
     * @param $params
     * @return Collection
     */
    public function fetchAll($params = [])
    {
        $operators = array(
            "<=>", ">=", "<=", "=", ">", "<"
        );

        $reservedParams = ["page", "pagesize"];

        // преобразуем массив параметров к массиву предикатов для orm
        //$where = [];
        $where = new Where();
        foreach ($params as $k=>$v){
            if(!in_array($k, $reservedParams)) {
                if (preg_match("/([a-zA-Z0-9\\.\\_\\-\\s]*)(" . implode("|", $operators) . ")/", $k, $m)) {
                    $operator = $m[2];
                    $param = $v;
                    $column = $m[1];


                    switch ($operator) {
                        case ">":
                            $where->greaterThan($column, $param);
                            break;
                        case ">=":
                            $where->greaterThanOrEqualTo($column, $param);
                            break;
                        case "<":
                            $where->lessThan($column, $param);
                            break;
                        case "<=":
                            $where->lessThanOrEqualTo($column, $param);
                            break;
                        case "=":
                            $where->equalTo($column, $param);
                            break;
                        case "<=>":
                            $where->notEqualTo($column, $param);
                            break;
                    }
                } else {
                    $where->equalTo($k, $v);
                }
            }
        }

        $collectionClass = $this->getCollectionClass();

        /** @var Collection $collectionClass */
        $collection = new $collectionClass(new DbTableGateway($this->table, $where));
        if(isset($params['pagesize']) && method_exists($collection, 'setItemCountPerPage')) {
            $collection->setItemCountPerPage($params['pagesize']);
        }
        if(isset($params['page']) && method_exists($collection, 'setCurrentPageNumber')) {
            $collection->setCurrentPageNumber($params['page']);
        }

        return $collection;
    }

    /**
     * Обновить сущность с id = $id
     * @param string $id
     * @param array|Traversable|\stdClass $data
     * @return array|\ArrayObject|null
     */
    public function update($id, $data)
    {
        if (is_object($data)) {
            $data = (array) $data;
        }

        $idName = $this->getIdFieldName();
        $this->table->update($data, [$idName => $id]);

        $resultSet = $this->table->select([$idName => $id]);
        if (0 === count($resultSet)) {
            throw new DomainException('Update operation failed or result in row deletion', 500);
        }
        return $resultSet->current();
    }

    /**
     * Удалить сущность с id == $id. В ответ не возвращает данных
     * @param string $id
     * @return bool
     */
    public function delete($id)
    {
        /*if (! Uuid::isValid($id)) {
            throw new DomainException('Invalid identifier provided', 404);
        }*/
        $idName = $this->getIdFieldName();
        $result = $this->table->delete([$idName => $id]);

        if (! $result) {
            return false;
        }

        return true;
    }

    /**
     * @return TableGateway
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param TableGateway $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @return String
     */
    public function getIdField()
    {
        return $this->idField;
    }

    /**
     * @param String $idField
     */
    public function setIdField($idField)
    {
        $this->idField = $idField;
    }

    /**
     * @return mixed
     */
    public function getCollectionClass()
    {
        return $this->collectionClass;
    }

    /**
     * @param mixed $collectionClass
     */
    public function setCollectionClass($collectionClass)
    {
        $this->collectionClass = $collectionClass;
    }

    /**
     * @return mixed
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * @param mixed $entityClass
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * @return AuthUtils
     */
    public function getAuthUtils()
    {
        return $this->authUtils;
    }

    /**
     * @param AuthUtils $authUtils
     */
    public function setAuthUtils($authUtils)
    {
        $this->authUtils = $authUtils;
    }
}
