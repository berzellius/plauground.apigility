<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 12.06.2017
 * Time: 14:13
 */

namespace plate\V1\Rest\Scheduled_tasks;


use Interop\Container\ContainerInterface;
use plate\EntityServicesSupport\EntitiesUtils;
use plate\EntitySupport\Entity;
use plate\EntitySupport\TableGatewayMapper;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Paginator\Adapter\DbSelect;

class ScheduledDbSelect extends DbSelect
{
    protected $entitiesUtils;
    protected $select;

    /**
     * ScheduledDbSelect constructor.
     * @param EntitiesUtils $entitiesUtils
     * @param Select $select
     * @param Adapter|Sql $adapterOrSqlObject
     * @param null|ResultSetInterface $resultSetPrototype
     * @param null $countSelect
     * @internal param ContainerInterface $container
     */
    public function __construct(EntitiesUtils $entitiesUtils, Select $select, $adapterOrSqlObject, $resultSetPrototype = null, $countSelect = null)
    {
        $this->setEntitiesUtils($entitiesUtils);
        $this->setSelect($select);
        parent::__construct($select, $adapterOrSqlObject, $resultSetPrototype, $countSelect);
    }

    public function getItems($offset, $itemCountPerPage)
    {
        // todo пересчет $offset и $itemCountPerPage на лету
        $arr = parent::getItems(0, 1000);
        return $this->getEntitiesUtils()->groupEntities($arr, "scheduled", ["devices" => "device", "groups" => "group"]);
    }

    /**
     * @return EntitiesUtils
     */
    public function getEntitiesUtils()
    {
        return $this->entitiesUtils;
    }

    /**
     * @param EntitiesUtils $entitiesUtils
     */
    public function setEntitiesUtils($entitiesUtils)
    {
        $this->entitiesUtils = $entitiesUtils;
    }

    /**
     * @return Select
     */
    public function getSelect()
    {
        return $this->select;
    }

    /**
     * @param Select $select
     */
    public function setSelect($select)
    {
        $this->select = $select;
    }



    public function fetch(TableGatewayMapper $tableGatewayMapper, $id){
        $res = [];
        $resultSet = $tableGatewayMapper->getTable()->selectWith($this->getSelect());

        foreach ($resultSet as $item) {
            $res[] = Entity::asArray($item);
        }

        return $this->getEntitiesUtils()->groupEntities(
            $res, "scheduled", ["devices" => "device", "groups" => "group"]
        )[0];
    }
}