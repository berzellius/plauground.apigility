<?php
namespace plate\V1\Rpc\FavoritesRpc;

class FavoritesRpcControllerFactory
{
    public function __invoke($controllers)
    {
        return new FavoritesRpcController();
    }
}
