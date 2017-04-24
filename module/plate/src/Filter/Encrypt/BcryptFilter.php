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
        $bcrypter = new Bcrypt();
        $encrypted = $bcrypter->create($value);
        return $encrypted;
    }

    /**
     * Decrypts $value with the defined settings
     *
     * @param  string $value Data to decrypt
     * @return string The decrypted data
     */
    public function decrypt($value)
    {
        // nothing to do with it
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