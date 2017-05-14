<?php

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 14.05.2017
 * Time: 13:39
 */
namespace V1Test\Rest;


use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AuthTest extends AbstractHttpControllerTestCase
{
    protected $authCode = "ef0f2f4cd59f5d86fde44f65069739ba37051767";

    public function setUp()
    {
        require_once __DIR__ . '/../../../../../vendor/zendframework/zend-test/autoload/phpunit-class-aliases.php';
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
        // Grabbing the full application configuration:
            include __DIR__ . '/../../../../../config/application.config.php',
            $configOverrides
        ));
        parent::setUp();
    }

    public function testAuthEmptyPost(){
        $this->dispatch("/oauth", "POST");
        $this->assertResponseStatusCode(400);
    }

    public function testAuthAsUser(){
        $authData = [
            "grant_type" => "client_credentials",
            "username" => "main_user",
            "password" => "user1",
        ];

        $headers = new \Zend\Http\Headers;
        $headers->addHeaderLine("Authorization", "Basic bWFpbl91c2VyOnVzZXIx");
        $headers->addHeaderLine("Accept", "application/json");
        $this->getRequest()->setHeaders($headers);
        $this->dispatch("/oauth", "POST", $authData);

        $result = json_decode($this->getResponse()->getContent());
        foreach ($result as $k=>$v) {
            echo "$k = $v \n";
        }
    }

    public function testSome1(){
        $headers = new \Zend\Http\Headers;
        /*$header = $headers->fromString(
            "Authorization:Bearer 895674cc1f5c57a89a5820f32ddb884599d924ef" . "\r\n" .
            "Content-Type:application/json"
        );*/
        $headers->addHeaderLine("Authorization", "Bearer " . $this->getAuthCode());
        $headers->addHeaderLine("Accept", "application/json");
        $this->getRequest()->setHeaders($headers);
        $this->dispatch("/devices");
        $result = json_decode($this->getResponse()->getContent());
        echo $this->getResponse()->getContent() . "\n\n";
    }

    public function testSome2(){
        $headers = new \Zend\Http\Headers;
        /*$header = $headers->fromString(
            "Authorization:Bearer 895674cc1f5c57a89a5820f32ddb884599d924ef" . "\r\n" .
            "Content-Type:application/json"
        );*/
        $headers->addHeaderLine("Authorization", "Bearer " . $this->getAuthCode());
        $headers->addHeaderLine("Accept", "application/json");
        $this->getRequest()->setHeaders($headers);
        $this->dispatch("/devices", "POST", [
            "mac" => "dddddd"
        ]);
        $result = json_decode($this->getResponse()->getContent());
        echo $this->getResponse()->getContent();
    }



    /**
     * @return mixed
     */
    public function getAuthCode()
    {
        return $this->authCode;
    }

    /**
     * @param mixed $authCode
     */
    public function setAuthCode($authCode)
    {
        $this->authCode = $authCode;
    }


}