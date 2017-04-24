<?php

namespace plate\V1\Rest\Status;
use plate\EntitySupport\Entity;


/**
 * Created by PhpStorm.
 * User: berz
 * Date: 23.04.2017
 * Time: 23:13
 */
class Status extends Entity
{
    /**
     * @var mixed
     */
    public $id;

    /**
     * @var string
     */
    //public $message;

    /**
     * @var int
     */
    public $timestamp;

    /**
     * @var string
     */
    public $user;
}