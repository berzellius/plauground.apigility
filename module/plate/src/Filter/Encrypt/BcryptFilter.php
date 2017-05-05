<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 22.04.2017
 * Time: 22:21
 */

namespace plate\Filter\Encrypt;

use Zend\Filter\Encrypt\EncryptionAlgorithmInterface;
use Zend\Crypt\Password\Bcrypt;

/**
 * Class BcryptFilter
 * Реализация методики шифрования паролей для использования при создании
 * пользователей Oauth 2.0
 * Использование в Apigility: для поля, соотвествующего паролю пользователя, добавить Filter
 * Zend\Filter\Encrypt, добавить опцию адаптер со значением, соотвествующим пути к данному классу
 * (plate\Filter\Encrypt сейчас)
 *
 *  После этого можно добавлять ouath2 пользователей, пароль при создании отправлять в явном виде -
 * он будет хеширован автоматически.
 * @package plate\Filter\Encrypt
 */
class BcryptFilter implements EncryptionAlgorithmInterface
{

    /**
     * Encrypts $value with the defined settings
     *
     * @param  string $value Data to encrypt
     * @return string The encrypted data
     */
    public function encrypt($value)
    {
        /* Zend\Crypt\Password\Bcrypt реализует нужный алгоритм.
         * при необходимости через параметр конструктора можно добавить соль.
         *
         */
        $bcrypter = new Bcrypt();
        $encrypted = $bcrypter->create($value);
        return $encrypted;
    }

    /**
     * Decrypts $value with the defined settings
     * не реализован
     *
     * @param  string $value Data to decrypt
     * @return string The decrypted data
     */
    public function decrypt($value)
    {
        // не реализован
        return null;
    }

    /**
     * Return the adapter name
     *
     * @return string
     */
    public function toString()
    {
        return "Bcrypt";
    }
}