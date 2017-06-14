<?php
namespace plate\V1\Rpc\ItemsLists;

class ItemsListsControllerFactory
{
    public function __invoke($controllers)
    {
        return new ItemsListsController();
    }
}
