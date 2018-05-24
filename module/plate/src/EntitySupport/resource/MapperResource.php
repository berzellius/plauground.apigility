<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 25.04.2017
 * Time: 19:12
 */

namespace plate\EntitySupport\resource;


use plate\EntitySupport\resource\MapperInterface;
use ZF\Rest\AbstractResourceListener;

/**
 * Class MapperResource
 * @package plate\EntitySupport
 */
class MapperResource extends AbstractResourceListener
{
    protected $mapper;

    public function __construct(MapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @return MapperInterface
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @param MapperInterface $mapper
     */
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
    }


}