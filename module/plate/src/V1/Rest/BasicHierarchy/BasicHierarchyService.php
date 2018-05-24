<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2018
 * Time: 19:31
 */

namespace plate\V1\Rest\BasicHierarchy;


use Interop\Container\ContainerInterface;
use plate\EntityServicesSupport\EntityService;
use plate\EntitySupport\collection\Collection;
use plate\EntitySupport\collection\NestedSetsCollection;
use plate\EntitySupport\resource\ResourceFactory;
use plate\EntitySupport\tableGateway\TableGatewayMapper;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Join;
use Zend\Db\Sql\Select;
use Zend\Hydrator\ObjectProperty;
use Zend\Paginator\Adapter\DbSelect;

/**
 * Бизнес-логика раоты с базовой иерархией системы
 * Class BasicHierarchyService
 * @package plate\V1\Rest\BasicHierarchy
 */
class BasicHierarchyService extends EntityService
{
    public function fetchAll($params)
    {
        $select = $this->getTableMapper()->generateBasicSelect();

        /**
         * @var HydratingResultSet
         */
        $res = $this->getTableMapper()->getTable()->selectWith($select);

        /**
         * @var ObjectProperty на данный момент
         */
        $hyd = $res->getHydrator();

        // $res->current() иммет тип Entity, что соответствует конструктору общего TableGateway
        //die(get_class($res->current()));

        /*die(get_class($hyd));

        die(get_class($res));

        $dbSelect = new DbSelect($select, $this->getAdapter());



        return new BasicHierarchyCollection($dbSelect);*/

       // $current = $res->current();
//        die(print_r($current));

        // это нормальный результат!!

        return $res;
    }
}