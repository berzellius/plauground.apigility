<?php

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 14.05.2017
 * Time: 13:39
 */
namespace plate\test\V1Test\ControllerCallTests;


use Herrera\Json\Exception\Exception;
use PHPUnit\Framework\Assert;
use plate\EntitySupport\collection\NestedSetsCollection;
use plate\EntitySupport\entity\Entity;
use plate\Organizer\Organizer;
use V1Test\Rest\testData\TestEntity;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class BasicUnitHttpTestHelper
 * @package V1Test\Rest
 */
abstract class BasicUnitHttpTestHelper extends AbstractHttpControllerTestCase
{
    const ADMIN_SCOPE = "main";

    // users cred
    protected $authCodes = [
        "testUser1" => "ab0330e97eba18b42cdbaeb1067a5f2ed270065a",
        "testUser2" => "41ca898116d19966caeb301285211c8cb679107d"
    ];

    // admin cred
    protected $adminAuthCode = "36b01d6a0ec2c52fa4ffd4f2f348958bd5b71c90";

    // admin user
    protected $adminUsername = "main_user";

    /**
     * @var array реестр созданных в ходе тестирования объектов
     */
    protected $registry = array();

    public function testSimple(){
        echo 'doing nothing.. ' . PHP_EOL;
        Assert::assertEquals("", "");

        echo 'dispatch something for fun.. ' . PHP_EOL;
        $res = $this->dispatchRequest('/basic-hierarchy', "GET", [], "testUser1");
        print_r($res);
    }

    public function setUp()
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        //die(__DIR__ . '/../../../../../config/application.config.php');
        $this->setApplicationConfig(ArrayUtils::merge(
        // конфиг нашего приложения
            include 'config/application.config.php',
            $configOverrides
        ));

        require_once "testData/includes.php";
        parent::setUp();

        /**
         * Далее готовим набор объектов для тестов
         */
    }

    public function onNotSuccessfulTest($e)
    {
        echo "обработка неуспешных тестов\r\n";

        if(method_exists($this, 'cleanUp')) {
            $this->cleanUp();
        }
        parent::onNotSuccessfulTest($e);
    }

    public function getAdminAuthHeaders(){
        $headers = new \Zend\Http\Headers;
        $headers->addHeaderLine("Authorization", "Bearer " . $this->getAdminAuthCode());
        $headers->addHeaderLine("Accept", "application/json");

        return $headers;
    }

    public function getAuthHeaders($user){
        $headers = new \Zend\Http\Headers;
        $headers->addHeaderLine("Authorization", "Bearer " . $this->getAuthCodes()[$user]);
        $headers->addHeaderLine("Accept", "application/json");

        return $headers;
    }

    public function dispatchRequestAdmin($url, $method = "GET", array $data = []){
        $this->getRequest()->setHeaders($this->getAdminAuthHeaders());
        return $this->doRequestJob($url, $method, $data, $this->getAdminUsername());
    }

    public function dispatchRequest($url, $method = "GET", array $data = [], $user){
        $this->getRequest()->setHeaders($this->getAuthHeaders($user));
        return $this->doRequestJob($url, $method, $data);
    }

    protected function doRequestJob($url, $method, $data){
        if($method == "GET"){
            $this->dispatch($url);
        }
        else{
            $this->dispatch($url, $method, $data);
        }
        $content = $this->getResponse()->getContent();
        $httpStatus = $this->getResponse()->getStatusCode();
        $this->reset();
        return [
            'content' => $content,
            'http_status' => $httpStatus
        ];
    }

    protected function createEntityInstanceWOCheck($clazz, $data, $scope = "", $user){
        $result = ($scope == self::ADMIN_SCOPE)?
            $this->dispatchRequestAdmin($clazz::$baseUrl, "POST", $data) :
            $this->dispatchRequest($clazz::$baseUrl, "POST", $data, $user);
        $res = Entity::asArray(json_decode($result['content']));

        if(isset($res['id'])){
            echo "Создан объект " . $clazz . "#" . $res['id'] . "\r\n";

            $registry = $this->getRegistry();
            $registry[$clazz][] = new $clazz($res['id'], $res, $scope, $user);
            $this->setRegistry($registry);
        }

        return $res;
    }

    protected function createEntityInstance($clazz, $data, $scope = "", $user){
        $result = ($scope == self::ADMIN_SCOPE)?
            $this->dispatchRequestAdmin($clazz::$baseUrl, "POST", $data) :
            $this->dispatchRequest($clazz::$baseUrl, "POST", $data, $user);
        $res = Entity::asArray(json_decode($result['content']));

        if(!isset($res['id'])){
            print_r($res);
            throw new \Exception("Сущность не была создана либо не был автоматически сгенерирован id");
        }

        echo "Создан объект " . $clazz . "#" . $res['id'] . "\r\n";

        $registry = $this->getRegistry();
        $registry[$clazz][$res['id']] = new $clazz($res['id'], $res, $scope, $user);

        $this->setRegistry($registry);

        return $res['id'];
    }

    protected function trySendRequest($clazz, $method, $data, $scope, $user){
        $result = ($scope == self::ADMIN_SCOPE)?
            $this->dispatchRequestAdmin($clazz::$baseUrl, "POST", $data) :
            $this->dispatchRequest($clazz::$baseUrl, "POST", $data, $user);

        return $result;
    }

    protected function loadEntitiesSet(array $eset){
        foreach ($eset as $class => $set) {
            /** @var DevicesTestEntity $item */
            foreach ($set as $item) {
                $this->createEntityInstance($class, $item, self::ADMIN_SCOPE, $this->getAdminUsername());
            }
        }
    }

    /**
     * @param TestEntity $entity
     * @param $clazz
     * @param $id
     */
    public function updateEntityInRegistry($entity, $clazz, $id){
        if(isset($this->getRegistry()[$clazz][$id])){
            $this->getRegistry()[$clazz][$id] = $entity;
        }
    }

    /**
     * @param $clazz
     * @param $id
     * @return TestEntity|null
     */
    public function getEntityInRegistry($clazz, $id){
        return (isset($this->getRegistry()[$clazz][$id]))? $this->getRegistry()[$clazz][$id] : null;
    }

    /**
     * @return mixed
     */
    public function getAuthCodes()
    {
        return $this->authCodes;
    }

    /**
     * @param mixed $authCodes
     */
    public function setAuthCodes($authCodes)
    {
        $this->authCodes = $authCodes;
    }

    /**
     * @return string
     */
    public function getAdminAuthCode()
    {
        return $this->adminAuthCode;
    }

    /**
     * @param string $adminAuthCode
     */
    public function setAdminAuthCode($adminAuthCode)
    {
        $this->adminAuthCode = $adminAuthCode;
    }

    /**
     * @return array
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    /**
     * @param array $registry
     */
    public function setRegistry($registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return string
     */
    public function getAdminUsername()
    {
        return $this->adminUsername;
    }

    /**
     * @param string $adminUsername
     */
    public function setAdminUsername($adminUsername)
    {
        $this->adminUsername = $adminUsername;
    }
}