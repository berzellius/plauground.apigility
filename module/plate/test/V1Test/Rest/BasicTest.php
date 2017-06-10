<?php

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 14.05.2017
 * Time: 13:39
 */
namespace V1Test\Rest;


use Herrera\Json\Exception\Exception;
use plate\EntitySupport\Entity;
use plate\V1\Rest\Devices\DevicesService;
use V1Test\Rest\testData\DevicesTestEntity;
use V1Test\Rest\testData\FavoritesTestEntity;
use V1Test\Rest\testData\GroupsTestEntity;
use V1Test\Rest\testData\TestEntity;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class BasicTest extends AbstractHttpControllerTestCase
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

        require_once "testData/includes.php";
        parent::setUp();

        /**
         * Далее готовим набор объектов для тестов
         */
    }

    public function onNotSuccessfulTest($e)
    {
        echo "обработка неуспешных тестов\r\n";
        $this->cleanUp();
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

    protected function getFavoritesData(){
        $favoritesData = [
            [
                "entity_type" => "GROUP",
                "id_group" => "3"
            ],
            [
                "entity_type" => "GROUP",
                "id_group" => "2"
            ],
            [
                "entity_type" => "GROUP",
                "id_group" => "4"
            ]
        ];

        return $favoritesData;
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
        $registry[$clazz][] = new $clazz($res['id'], $res, $scope, $user);
        $this->setRegistry($registry);
    }

    protected function trySendRequest($clazz, $method, $data, $scope, $user){
        $result = ($scope == self::ADMIN_SCOPE)?
            $this->dispatchRequestAdmin($clazz::$baseUrl, "POST", $data) :
            $this->dispatchRequest($clazz::$baseUrl, "POST", $data, $user);

        return $result;
    }

    public function ____test4loadDebbugingTest(){
        $this->loadEntitiesSet(\TestDatasetsPart1::forFavoritesSet());
        /*$devicesIds = [421, 422, 423, 424, 425];
        $groupsIds = [107, 108, 109];

        foreach($devicesIds as $k => $deviceId){
            if($k < 3) {
                $this->addRightsToDeviceWithCheck($deviceId, "testUser1");
                $this->addDeviceToGroup($deviceId, $groupsIds[0]);
                $this->addDeviceToFavorite($deviceId, "testUser1");
            }

            if($k == 3){
                $this->addRightsToDeviceWithCheck($deviceId, "testUser1");
                $this->addRightsToDeviceWithCheck($deviceId, "testUser2");
                $this->addDeviceToGroup($deviceId, $groupsIds[1]);
            }

            if($k > 3) {
                $this->addRightsToDeviceWithCheck($deviceId, "testUser2");
                $this->addDeviceToGroup($deviceId, $groupsIds[2]);
                $this->addDeviceToFavorite($deviceId, "testUser2");
            }
        }

        $this->addRightsToGroupWithCheck($groupsIds[0], "testUser1");
        $this->addRightsToGroupWithCheck($groupsIds[1], "testUser1");
        $this->addRightsToGroupWithCheck($groupsIds[1], "testUser2");
        $this->addRightsToGroupWithCheck($groupsIds[2], "testUser2");

        $this->addGroupToFavorite($groupsIds[0], "testUser1");
        $this->addGroupToFavorite($groupsIds[2], "testUser2");*/
    }

    public function testDevicesAndGroups(){
        $this->loadEntitiesSet(\TestDatasetsPart1::basicSet());
        $this->basicGroupsDistribution();
        $this->addToFavorites();

        $this->cleanUp();
    }

    protected function loadEntitiesSet(array $eset){
        foreach ($eset as $class => $set) {
            /** @var DevicesTestEntity $item */
            foreach ($set as $item) {
                $this->createEntityInstance($class, $item, self::ADMIN_SCOPE, $this->getAdminUsername());
            }
        }
    }

    protected function getGroupInRegistryIDs(){
        $groups = array();

        /** @var GroupsTestEntity $item */
        foreach ($this->getRegistry()[GroupsTestEntity::class] as $item){
            $groups[] = $item->getId();
        }

        return $groups;
    }

    protected function getDevicesInRegistryIDs(){
        $devices = array();

        /** @var GroupsTestEntity $item */
        foreach ($this->getRegistry()[DevicesTestEntity::class] as $item){
            $devices[] = $item->getId();
        }

        return $devices;
    }

    /**
     * Распределение устройств по трем группам:
     * первые 4 устройства - 1 группа
     * 3-8 устройства - 2 группа
     * остальные - 3 группа
     * группы созданы администратором, наполняются из-под него же
     *
     * доступы:
     * первый тестовый пользователь - 1,2 группа
     * второй тестовый пользователь - 2,3 группа
     */
    protected function basicGroupsDistribution()
    {
        $groups = $this->getGroupInRegistryIDs();
        $devices = $this->getDevicesInRegistryIDs();

        $i = 0;
        foreach ($devices as $id){
            if($i < 2){
                $this->addDeviceToGroup($id, $groups[0]);
                $this->addRightsToDeviceWithCheck($id, "testUser1");
            }

            if(2 <= $i and $i < 8){
                $this->addDeviceToGroup($id, $groups[0]);
                $this->addDeviceToGroup($id, $groups[1]);

                $this->addRightsToDeviceWithCheck($id, "testUser1");
                $this->addRightsToDeviceWithCheck($id, "testUser2");
            }

            if($i >= 8){
                $this->addDeviceToGroup($id, $groups[2]);
                $this->addRightsToDeviceWithCheck($id, "testUser2");
            }

            $i++;
        }

        $this->addRightsToGroupWithCheck($groups[0], "testUser1");
        $this->addRightsToGroupWithCheck($groups[1], "testUser1");
        $this->addRightsToGroupWithCheck($groups[1], "testUser2");
        $this->addRightsToGroupWithCheck($groups[2], "testUser2");
    }

    protected function addDeviceToGroup($devId, $grpId){
        $dev2grp = [
            "group_id" => $grpId,
            "device_id" => $devId
        ];

        echo "Добавляется устройство #" . $devId . " в группу #" . $grpId . "\r\n";
        $this->createEntityInstance(\Dev2grpTestEntity::class, $dev2grp, self::ADMIN_SCOPE, $this->getAdminUsername());
        echo "\r\n";
    }


    /**
     * Тест добавления в избранное
     * Первый тестовый пользователь - 1 группа; устройства 1, 2, 6, 7.
     * Второй тестовый пользователь - 3 группа; устройства 3, 4, 9, 10.
     */
    protected function addToFavorites()
    {
        $groups = $this->getGroupInRegistryIDs();
        $devices = $this->getDevicesInRegistryIDs();

        $devIds = [
            [0, 1, 5, 6],
            [2, 3, 8, 9]
        ];

        $groupIds = [[0], [2]];

        $users = ["testUser1", "testUser2"];

        foreach ($users as $k => $user) {
            foreach ($devIds[$k] as $deviceId) {
                $this->addDeviceToFavorite($devices[$deviceId], $user);
            }

            foreach ($groupIds[$k] as $groupId) {
                $this->addGroupToFavorite($groups[$groupId], $user);
            }
        }
    }

    protected function addDeviceToFavorite($devId, $user){
        $devToFav = [
            "id_device" => $devId,
            "entity_type" => "DEVICE"
        ];

        echo "Добавляется в избранное устройство #" . $devId . " для пользователя " . $user;
        $this->createEntityInstance(FavoritesTestEntity::class, $devToFav, "", $user);
    }

    protected function addGroupToFavorite($grpId, $user){
        $grpToFav = [
            "id_group" => $grpId,
            "entity_type" => "GROUP"
        ];

        echo "Добавляется в избранное группа #" . $grpId . " для пользователя " . $user;
        $this->createEntityInstance(FavoritesTestEntity::class, $grpToFav, "", $user);
    }

    public function _testFavorites(){
        foreach($this->getFavoritesData() as $item) {
            $this->createEntityInstance(FavoritesTestEntity::class, $item, "", "testUser1");
        }

        $this->cleanUp();
    }

    public function cleanUp(){
        echo "очистка данных \r\n";

        foreach ($this->getRegistry() as $clazz => $items) {
            /** @var TestEntity $item */
            foreach ($items as $item) if($item->deleteOnCleanUp()) {
                $url = $item->getUrl();
                echo $url . "\r\n";
                if($item->getScope() == self::ADMIN_SCOPE){
                    $this->dispatchRequestAdmin($url, "DELETE", []);
                }
                else{
                    $this->dispatchRequest($url, "DELETE", [], $item->getOwner());
                }
            }
        }
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

    protected function checkGettingsDevice($id, $user)
    {
        $resGettingDevice = $this->dispatchRequest("/devices/" . $id, "GET", [], $user);
        echo "Результат запроса устройства #" . $id . " пользователем " . $user . ": " . $resGettingDevice['content'] . " \r\n";
        $resGettingDevice = Entity::asArray(json_decode($resGettingDevice['content']));
        if(!($resGettingDevice['id'] == $id)){
            throw new Exception("Пользователь не получил данные устройства, обладая правами на него \r\n");
        }
        else{
            echo "Успешно \r\n";
        }
    }

    protected function addRightsToDeviceWithCheck($id, $user)
    {
        $acl = [
            "client_id" => $user,
            "device_id" => $id
        ];

        echo "Устанавливаются права на устройство #" . $id . "\r\n";
        $this->createEntityInstance(\DevicesAclRpcTestEntity::class, $acl, "", $user);
        echo "\r\n";

        $this->checkGettingsDevice($id, $user);
    }

    protected function addRightsToGroupWithCheck($id, $user)
    {
        $acl = [
            "client_id" => $user,
            "group_id" => $id
        ];

        echo "Устанавливаются права на группу #" . $id . "\r\n";
        $this->createEntityInstance(\GroupsAclRpcTestEntity::class, $acl, "", $user);
        echo "\r\n";

        $this->checkGettingsGroup($id, $user);
    }

    protected function checkGettingsGroup($id, $user)
    {
        $resGettingDevice = $this->dispatchRequest("/groups/" . $id, "GET", [], $user);
        echo "Результат запроса группы #" . $id . " пользователем " . $user . ": " . $resGettingDevice['content'] . " \r\n";
        $resGettingDevice = Entity::asArray(json_decode($resGettingDevice['content']));
        if(!($resGettingDevice['id'] == $id)){
            throw new Exception("Пользователь не получил данные группы, обладая правами на неё \r\n");
        }
        else{
            echo "Успешно \r\n";
        }
    }
}