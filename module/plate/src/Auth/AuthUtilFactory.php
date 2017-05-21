<?php

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2017
 * Time: 16:35
 */
namespace plate\Auth;

use Interop\Container\ContainerInterface;

class AuthUtilFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $authIdentity = $services->get('api-identity');
        return new AuthUtils($authIdentity);
    }
}