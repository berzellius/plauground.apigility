<?php
namespace plate\V1\Rpc\Groups_acl;

class Groups_aclControllerFactory
{
    public function __invoke($controllers)
    {
        return new Groups_aclController();
    }
}
