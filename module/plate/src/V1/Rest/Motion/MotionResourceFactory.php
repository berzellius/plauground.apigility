<?php
namespace plate\V1\Rest\Motion;

class MotionResourceFactory
{
    public function __invoke($services)
    {
        return new MotionResource();
    }
}
