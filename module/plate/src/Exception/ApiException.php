<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 07.08.2018
 * Time: 22:25
 */

namespace plate\Exception;

class ApiException extends \Exception
{
    protected $httpCode;

    /**
     * ApiException constructor.
     * @param $message
     * @param int $httpCode
     */
    public function __construct($message, $httpCode = 500)
    {
        parent::__construct($message);
        $this->setHttpCode($httpCode);
    }

    /**
     * @return integer
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @param integer $httpCode
     */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;
    }
}