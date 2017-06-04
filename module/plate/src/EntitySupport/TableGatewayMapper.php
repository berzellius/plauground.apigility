<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace plate\EntitySupport;

use DomainException;
use InvalidArgumentException;
use Traversable;
use Zend\Db\Adapter\Adapter;
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
    /**
     * @var TableGateway
     */
    protected $table;

    /**
     * @var array section [zf-hal][`entity_name`]
     */
    protected $halEntityProperties;

    /**
     * @param TableGateway $table
     */
    public function __construct(TableGateway $table)
    {
        $this->table = $table;
    }

    /**
     * Соответствует полю Entity identifier name вкладки General Settings веб-интерфейса Apigility
     * @return string
     */
    public function getIdFieldName(){
        if($this->getHalEntityProperties()){
            $idName = $this->getHalEntityProperties()['entity_identifier_name'];
            return $idName? $idName : "id";
        }
        else return "id";
    }

    /**
     * @param array|Traversable|\stdClass $data
     * @return Entity
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
     * @return Entity
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

        // преобразуем массив параметров к массиву предикатов для orm
        //$where = [];
        $where = new Where();
        foreach ($params as $k=>$v){
            if(preg_match("/([a-zA-Z0-9\\.\\_\\-\\s]*)(" . implode("|", $operators) . ")/", $k, $m)){
                $operator = $m[2];
                $param = $v;
                $column = $m[1];


                switch ($operator){
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
            }
            else{
                $where->equalTo($k, $v);
            }
        }

        return new Collection(new DbTableGateway($this->table, $where));
    }

    /**
     * Обновить сущность с id = $id
     * @param string $id
     * @param array|Traversable|\stdClass $data
     * @return Entity
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
     * @return mixed
     */
    public function getHalEntityProperties()
    {
        return $this->halEntityProperties;
    }

    /**
     * @param mixed $halEntityProperties
     */
    public function setHalEntityProperties($halEntityProperties)
    {
        $this->halEntityProperties = $halEntityProperties;
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


}
