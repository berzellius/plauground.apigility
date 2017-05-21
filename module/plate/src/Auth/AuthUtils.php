<?php

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2017
 * Time: 16:33
 */
namespace plate\Auth;

use Zend\Permissions\Rbac\AbstractRole;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;

class AuthUtils
{
    // Значение можно переопределить в классе-наследнике. Иначе будет использовано текущее занчение константы:
    const ADMIN_SCOPE_NAME = 'main';

    protected $authentificatedIdentity;

    /**
     * AuthUtils constructor.
     * @param AbstractRole $authentificatedIdentity
     */
    public function __construct(AbstractRole $authentificatedIdentity)
    {
        $this->authentificatedIdentity = $authentificatedIdentity;
    }

    /**
     * @return AbstractRole
     */
    public function getAuthentificatedIdentity()
    {
        return $this->authentificatedIdentity;
    }

    /**
     * @param AbstractRole $authentificatedIdentity
     */
    public function setAuthentificatedIdentity(AuthenticatedIdentity $authentificatedIdentity)
    {
        $this->authentificatedIdentity = $authentificatedIdentity;
    }

    public function getClientId(){
        if(!$this->checkAuthentificatedIdentity()){
            return null;
        }

        return $this->getAuthentificatedIdentity()->getAuthenticationIdentity()['client_id'];
    }

    /**
     * ADMIN_SCOPE_NAME => поле scope в таблице пользователей
     * @param $adminScope
     * @return bool
     */
    public function checkAdminPrivileges($adminScope = self::ADMIN_SCOPE_NAME){
        if(!$this->checkAuthentificatedIdentity()){
            return false;
        }

        $identity = $this->getAuthentificatedIdentity()->getAuthenticationIdentity();
        return $identity['scope'] == $adminScope;
    }

    protected function checkAuthentificatedIdentity(){
        return $this->getAuthentificatedIdentity() instanceof AuthenticatedIdentity;
    }

}