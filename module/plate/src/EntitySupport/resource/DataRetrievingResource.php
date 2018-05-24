<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 25.04.2017
 * Time: 17:18
 */

namespace plate\EntitySupport\resource;
use plate\EntitySupport\resource\MapperInterface;
use plate\EntitySupport\resource\MapperResource;
use plate\EntitySupport\traits\ResourceRetrievingData;
use plate\EntitySupport\tableGateway\TableGatewayMapper;
use ZF\Rest\AbstractResourceListener;

/**
 * Class DataRetrievingResource
 * plate\EntitySupport\MapperResource, дополненный трейтом ResourceRetrievingData, предоставляющим метод
 * для фильтрации данных фильтрами Apigility и get/set - террами mapper
 * @package plate\EntitySupport
 */
abstract class DataRetrievingResource extends  MapperResource
{
    use ResourceRetrievingData;

    /**
        * @return MapperInterface|TableGatewayMapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @param TableGatewayMapper $mapper
     */
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
    }
}