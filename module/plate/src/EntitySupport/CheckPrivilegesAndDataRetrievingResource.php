<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 25.04.2017
 * Time: 19:51
 */

namespace plate\EntitySupport;


abstract class CheckPrivilegesAndDataRetrievingResource extends DataRetrievingResource
{
    use CheckPrivileges;

    const ADMIN_SCOPE_NAME = 'main';

    protected function getLoggedInClientId(){
        $identity = $this->getIdentity()->getAuthenticationIdentity();
        return $identity['client_id'];
    }
}