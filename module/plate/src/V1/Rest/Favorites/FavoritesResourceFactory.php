<?php
namespace plate\V1\Rest\Favorites;

class FavoritesResourceFactory
{
    public function __invoke($services)
    {
        return new FavoritesResource();
    }
}
