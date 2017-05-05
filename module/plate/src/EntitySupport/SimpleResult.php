<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 25.04.2017
 * Time: 17:34
 */

namespace plate\EntitySupport;

/**
 * Class SimpleResult
 * DTO для простейшего результата, возвращаемого методами rest api
 * @package plate\EntitySupport
 */
class SimpleResult
{
    protected $status;
    protected $message;

    /**
     * SimpleResult constructor.
     * @param $status
     * @param $message
     */
    public function __construct($status, $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Cast to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $problem = [
            'status' => $this->getStatus(),
            'message' => $this->getMessage(),
        ];

        return $problem;
    }


}