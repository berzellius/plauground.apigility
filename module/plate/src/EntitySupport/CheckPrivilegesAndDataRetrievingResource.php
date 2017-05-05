<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 25.04.2017
 * Time: 19:51
 */

namespace plate\EntitySupport;

/**
 * Class CheckPrivilegesAndDataRetrievingResource
 * Класс plate\EntitySupport\DataRetrievingResource, дополненный методом получения
 * имени залогиненного пользователя и трейтом CheckPrivileges для проверки привилегий администратора
 * @package plate\EntitySupport
 */
abstract class CheckPrivilegesAndDataRetrievingResource extends DataRetrievingResource
{
    use CheckPrivileges;

    // Значение можно переопределить в классе-наследнике. Иначе будет использовано текущее занчение константы:
    const ADMIN_SCOPE_NAME = 'main';

    /**
     * Получить client_id (Имя пользователя)
     * @return mixed
     */
    protected function getLoggedInClientId(){
        $identity = $this->getIdentity()->getAuthenticationIdentity();
        return $identity['client_id'];
    }
}