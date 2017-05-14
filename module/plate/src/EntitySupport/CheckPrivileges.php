<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 25.04.2017
 * Time: 19:49
 */

namespace plate\EntitySupport;


use ZF\ApiProblem\ApiProblem;

/**
 * Class CheckPrivileges
 * Трейт, содержащий методы проверки привилегий администратора
 * и реализующий возврат ошибки доступа
 * @package plate\EntitySupport
 */
trait CheckPrivileges
{
    /**
     * ADMIN_SCOPE_NAME => поле scope в таблице пользователей
     * @param $adminScope
     * @return bool
     */
    protected function checkAdminPrivileges($adminScope = self::ADMIN_SCOPE_NAME){
        $identity = $this->getIdentity()->getAuthenticationIdentity();
        return $identity['scope'] == $adminScope;
    }

    /**
     * Ошибка доступа 403
     * @return ApiProblem
     */
    protected function notAllowed($problem = "Method not allowed!"){
        return new ApiProblem(403, $problem);
    }
}