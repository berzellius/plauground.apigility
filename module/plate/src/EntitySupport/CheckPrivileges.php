<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 25.04.2017
 * Time: 19:49
 */

namespace plate\EntitySupport;


use ZF\ApiProblem\ApiProblem;

trait CheckPrivileges
{
    protected function checkAdminPrivileges($adminScope = self::ADMIN_SCOPE_NAME){
        $identity = $this->getIdentity()->getAuthenticationIdentity();
        return $identity['scope'] == $adminScope;
    }

    protected function notAllowed(){
        return new ApiProblem(403, 'Method not allowed! ');
    }
}