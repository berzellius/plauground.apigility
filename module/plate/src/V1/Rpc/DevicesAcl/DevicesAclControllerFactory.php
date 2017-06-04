<?php
namespace plate\V1\Rpc\DevicesAcl;

class DevicesAclControllerFactory
{
    public function __invoke($controllers)
    {
        return new DevicesAclController();
    }
}
