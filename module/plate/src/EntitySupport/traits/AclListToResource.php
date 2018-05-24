<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 12.05.2017
 * Time: 22:30
 */

namespace plate\EntitySupport\traits;


use plate\EntitySupport\tableGateway\TableGatewayMapper;

trait AclListToResource
{
    protected $userAccessListMapper;

    /**
     * DevicesResource constructor.
     * @param TableGatewayMapper $mapper
     * @param TableGatewayMapper $userAccessListMapper
     */
    public function __construct(TableGatewayMapper $mapper, TableGatewayMapper $userAccessListMapper)
    {
        parent::__construct($mapper);
        $this->userAccessListMapper = $userAccessListMapper;
    }

    /**
     * @return TableGatewayMapper
     */
    public function getUserAccessListMapper()
    {
        return $this->userAccessListMapper;
    }

    /**
     * @param TableGatewayMapper $userAccessListMapper
     */
    public function setUserAccessListMapper($userAccessListMapper)
    {
        $this->userAccessListMapper = $userAccessListMapper;
    }
}