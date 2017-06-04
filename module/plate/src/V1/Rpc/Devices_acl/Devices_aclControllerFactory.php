<?php
namespace plate\V1\Rpc\Devices_acl;

class Devices_aclControllerFactory
{
    public function __invoke($controllers)
    {
        return new Devices_aclController();
    }
}
