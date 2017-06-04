<?php
namespace plate\V1\Rpc\GroupsAcl;

class GroupsAclControllerFactory
{
    public function __invoke($controllers)
    {
        return new GroupsAclController();
    }
}
