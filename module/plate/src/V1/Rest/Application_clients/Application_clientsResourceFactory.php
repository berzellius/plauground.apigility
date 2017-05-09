<?php
namespace plate\V1\Rest\Application_clients;

class Application_clientsResourceFactory
{
    public function __invoke($services)
    {
        return new Application_clientsResource();
    }
}
