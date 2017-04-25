<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 25.04.2017
 * Time: 19:12
 */

namespace plate\EntitySupport;


use ZF\Rest\AbstractResourceListener;

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