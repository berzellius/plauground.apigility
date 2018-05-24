<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace plate\EntitySupport\tableGateway;

use plate\EntitySupport\entity\Entity;
use plate\Hydrator\CustomHydrator;
use plate\V1\Rest\BasicHierarchy\BasicHierarchyEntity;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway as ZFTableGateway;
use Zend\Hydrator\ArraySerializable;
use Zend\Hydrator\ObjectProperty as ObjectPropertyHydrator;

/**
 * Class TableGateway
 * Для создания gateway к таблицам БД
 * @package plate\EntitySupport
 */
class TableGateway extends ZFTableGateway
{
    public function __construct($table, AdapterInterface $adapter, $features = null, HydratingResultSet $hydratingResultSet = null)
    {
        if($hydratingResultSet == null) {
            $hydratingResultSet = new HydratingResultSet(new ObjectPropertyHydrator(), new Entity());
        }
        //$resultSet = new HydratingResultSet(new CustomHydrator(), new BasicHierarchyEntity());
        //$resultSet = new HydratingResultSet(new ArraySerializable(), new Entity());
        return parent::__construct($table, $adapter, $features, $hydratingResultSet);
    }
}
