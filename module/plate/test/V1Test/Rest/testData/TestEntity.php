<?php

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 04.06.2017
 * Time: 15:59
 */
namespace V1Test\Rest\testData;

use ReflectionClass;

abstract class TestEntity
{

    public function __construct($id, $data, $scope, $user)
    {
        $this->setId($id);
        $this->setData($data);
        $this->setScope($scope);
        $this->setOwner($user);
    }

    /**
     * @var mixed - базовый url, например, /devices
     */
    public static $baseUrl;
    /**
     * @var mixed - id созданного в ходе тестов экземпляра
     */
    protected $id;
    /**
     * @var mixed - admin, если права на удаление есть только у администратора
     */
    protected $scope;
    /**
     * @var array - данные, сохраненные в базе в ходе теста
     */
    protected $data;
    /**
     * @var mixed - владелец, учетная запись, из-под которой был создан объект
     */
    protected $owner;
    /**
     * @var array - список пользователей, имеющих доступ к объекту
     */
    protected $userList = [];

    /**
     * @return mixed
     */
    public function getUserList()
    {
        return $this->userList;
    }

    /**
     * @param mixed $userList
     */
    public function setUserList($userList)
    {
        $this->userList = $userList;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param mixed $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return bool
     */
    public function deleteOnCleanUp(){
        return true;
    }

    /**
     * @return string - url объекта
     */
    public function getUrl(){
        $c = new ReflectionClass($this);
        return $c->getStaticPropertyValue("baseUrl") . "/" . $this->getId();
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }
}