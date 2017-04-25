<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace plate\EntitySupport;

use DomainException;
use InvalidArgumentException;
use Traversable;
use Rhumsaa\Uuid\Uuid;
use Zend\Paginator\Adapter\DbTableGateway;
use Zend\Stdlib\ArrayUtils;

/**
 * Mapper implementation using a Zend\Db\TableGateway
 */
class TableGatewayMapper implements MapperInterface
{
    /**
     * @var TableGateway
     */
    protected $table;

    /**
     * @var section [zf-hal][`entity_name`]
     */
    protected $halEntityProperties;

    /**
     * @param TableGateway $table
     */
    public function __construct(TableGateway $table)
    {
        $this->table = $table;
    }

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

        //$data['id'] = Uuid::uuid4()->toString();
       
        $this->table->insert($data);
        $id = $this->table->lastInsertValue;
        $idName = $this->getIdFieldName();
        $resultSet = $this->table->select([$idName => $id]);
        if (0 === count($resultSet)) {
            throw new DomainException('Insert operation failed or did not result in new row', 500);
        }
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

        $resultSet = $this->table->select([$idName => $id]);
        if (0 === count($resultSet)) {
            throw new DomainException('Status message not found', 404);
        }
        return $resultSet->current();
    }

    /**
     * @param $params
     * @return Collection
     */
    public function fetchAll($params)
    {
        $where = [];
        foreach ($params as $k=>$v){
            $where[] = $k . " = '" . $v . "'";
        }

        return new Collection(new DbTableGateway($this->table, $where));
    }

    /**
     * @param string $id
     * @param array|Traversable|\stdClass $data
     * @return Entity
     */
    public function update($id, $data)
    {
        /*if (! Uuid::isValid($id)) {
            throw new DomainException('Invalid identifier provided', 404);
        }*/
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
