<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 25.04.2017
 * Time: 17:18
 */

namespace plate\EntitySupport;
use ZF\Rest\AbstractResourceListener;

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