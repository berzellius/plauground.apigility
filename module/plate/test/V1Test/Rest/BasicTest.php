<?php

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 14.05.2017
 * Time: 13:39
 */
namespace V1Test\Rest;


use Herrera\Json\Exception\Exception;
use PHPUnit\Framework\Assert;
use plate\EntitySupport\Entity;
use plate\V1\Rest\Devices\DevicesService;
use V1Test\Rest\testData\DevicesTestEntity;
use V1Test\Rest\testData\FavoritesTestEntity;
use V1Test\Rest\testData\GroupsTestEntity;
use V1Test\Rest\testData\ScheduledTasksTestEntity;
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

    public function testDevicesAndGroups(){
        $this->loadEntitiesSet(\TestDatasetsPart1::basicSet());
        $this->basicGroupsDistribution();
        $this->addToFavorites();
        $this->addScheduling();


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

    protected function getGroupInRegistryIDs($user = null){
        $groups = array();

        /** @var GroupsTestEntity $item */
        foreach ($this->getRegistry()[GroupsTestEntity::class] as $item){
            echo "owner: " . $item->getOwner() . "\r\n";
            if($user == null || $item->getOwner() == $user || in_array($user, $item->getUserList()))
                $groups[] = $item->getId();
        }

        return $groups;
    }

    protected function getDevicesInRegistryIDs($user = null){
        $devices = array();

        /** @var GroupsTestEntity $item */
        foreach ($this->getRegistry()[DevicesTestEntity::class] as $item){
            if($user == null || $item->getOwner() == $user || in_array($user, $item->getUserList()))
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

    public function disributor(){
        return [
            'devices' =>
                [[0, 1, 5, 6],
                [2, 3, 8, 9]],
            'groups' =>
                [[0], [2]],
            'users' =>
                ["testUser1", "testUser2"]
        ];
    }

    /**
     * Тест добавления назначенных заданий
     */
    protected function addScheduling()
    {
        $req = [
            'action' => 'create_scheduled'
        ];

        $users = ["testUser1", "testUser2"];
        $user = $users[0];
        $groups = $this->getGroupInRegistryIDs($user);
        $devices = $this->getDevicesInRegistryIDs($user);


        $reqAbsentDevsGroupsSuccessWeekScheduling = array_merge(
            $req,
            [
                'name' => "test case scheduling",
                'week_scheduling' => [
                    [
                        'weekday' => "SUNDAY",
                        'time' => "14:30",
                        'command' => 'up'
                    ]
                ]
            ]
        );

        $reqAbsentWeekSchedulingGroupsSuccessDevs = array_merge(
            $req,
            [
                'name' => "test case scheduling",
                'devices' => [$devices[0], $devices[1]]
            ]
        );

        $reqAbsentWeekSchedulingDevsSuccessGroups = array_merge(
            $req,
            [
                'name' => "test case scheduling",
                'groups' => $groups[1]
            ]
        );

        $testRequests = [
            'fail' => [
                [
                    'request' => $req,
                    'expectedHTTPStatus' => 403
                ],
                [
                    'request' => array_merge(
                        $req,
                        [
                            'name' => "test case scheduling",
                        ]
                    ),
                    'expectedHTTPStatus' => 403
                ],
                [
                    'request' => array_merge(
                        $reqAbsentDevsGroupsSuccessWeekScheduling
                    ),
                    'expectedHTTPStatus' => 403
                ],
                [
                    'request' => array_merge(
                        $reqAbsentDevsGroupsSuccessWeekScheduling,
                        [
                            'devices' => "1,2,3"
                        ]
                    ),
                    'expectedHTTPStatus' => 403
                ],
                [
                    'request' => array_merge(
                        $reqAbsentDevsGroupsSuccessWeekScheduling,
                        [
                            'devices' => [1,2,3]
                        ]
                    ),
                    'expectedHTTPStatus' => 403
                ],
                [
                    'request' => array_merge(
                        $reqAbsentDevsGroupsSuccessWeekScheduling,
                        [
                            'name' => "test case scheduling",
                            'groups' => 1
                        ]
                    ),
                    'expectedHTTPStatus' => 403
                ],
                [
                    'request' => array_merge(
                        $reqAbsentDevsGroupsSuccessWeekScheduling,
                        [
                            'name' => "test case scheduling",
                            'groups' => [20000001,100000004]
                        ]
                    ),
                    'expectedHTTPStatus' => 403
                ],
                [
                    'request' => array_merge(
                        $reqAbsentDevsGroupsSuccessWeekScheduling,
                        [
                            'name' => "test case scheduling",
                            'groups' => "0,1"
                        ]
                    ),
                    'expectedHTTPStatus' => 403
                ],
                [
                    'request' => array_merge(
                        $reqAbsentWeekSchedulingGroupsSuccessDevs,
                        [
                            'week_scheduling' => 1
                        ]
                    ),
                    'expectedHTTPStatus' => 403
                ],
                [
                    'request' => array_merge(
                        $reqAbsentWeekSchedulingGroupsSuccessDevs,
                        [
                            'week_scheduling' => [
                                'weekday' => 'SHITDAY'
                            ]
                        ]
                    ),
                    'expectedHTTPStatus' => 403
                ],
                [
                    'request' => array_merge(
                        $reqAbsentWeekSchedulingGroupsSuccessDevs,
                        [
                            'name' => "test case scheduling",
                            'devices' => [$devices[0], $devices[1]],
                            'week_scheduling' => [
                                'weekday' => 'SUNDAY'
                            ]
                        ]
                    ),
                    'expectedHTTPStatus' => 403
                ],
                [
                    'request' => array_merge(
                        $reqAbsentWeekSchedulingGroupsSuccessDevs,
                        [
                            'week_scheduling' => [
                                'weekday' => 'SUNDAY',
                                'time' => '14:30:',
                                'command' => 'up'
                            ]
                        ]
                    ),
                    'expectedHTTPStatus' => 403
                ],
                [
                    'request' => array_merge(
                        $reqAbsentWeekSchedulingGroupsSuccessDevs,
                        [
                            'week_scheduling' => [
                                'weekday' => 'SUNDAY',
                                'time' => '14:30:0000',
                                'command' => 'up'
                            ]
                        ]
                    ),
                    'expectedHTTPStatus' => 403
                ],
                [
                    'request' => array_merge(
                        $reqAbsentWeekSchedulingGroupsSuccessDevs,
                        [
                            'week_scheduling' => [
                                'weekday' => 'SUNDAY',
                                'time' => '14:30',
                            ]
                        ]
                    ),
                    'expectedHTTPStatus' => 403
                ]
            ],
            'success' => [
                [
                    'request' => array_merge(
                        $reqAbsentDevsGroupsSuccessWeekScheduling,
                        [
                            'name' => "test case scheduling",
                            'devices' => [$devices[0], $devices[1]]
                        ]
                    ),
                    'expectedHTTPStatus' => 200
                ],
                [
                    'request' => array_merge(
                        $reqAbsentDevsGroupsSuccessWeekScheduling,
                        [
                            'name' => "test case scheduling",
                            'groups' => [$groups[0]]
                        ]
                    ),
                    'expectedHTTPStatus' => 200
                ],
                [
                    'request' => array_merge(
                        $reqAbsentDevsGroupsSuccessWeekScheduling,
                        [
                            'name' => "test case scheduling",
                            'devices' => [$devices[0], $devices[1]],
                            'groups' => [$groups[0]]
                        ]
                    ),
                    'expectedHTTPStatus' => 200
                ]
            ]
        ];


        foreach ($testRequests['fail'] as $request){
            // неуспешный запрос
            $res = $this->dispatchRequest("/scheduled_tasks_rpc", "POST", $request['request'], $user);
            Assert::assertEquals(
                $request['expectedHTTPStatus'], $res['http_status'],
                "Запрос " . json_encode($request['request']) . " вернул http статус " . $res['http_status'] .
                " вместо ожидаемого " . $request['expectedHTTPStatus'] . ", содержимое ответа: " .
                $res['content']);
        }

        $successIDs = [];

        foreach ($testRequests['success'] as $request){
            // успешный запрос
            $res = $this->dispatchRequest("/scheduled_tasks_rpc", "POST", $request['request'], $user);
            Assert::assertEquals(
                $request['expectedHTTPStatus'], $res['http_status'],
                "Запрос " . json_encode($request['request']) . " вернул http статус " . $res['http_status'] .
                " вместо ожидаемого " . $request['expectedHTTPStatus'] . ", содержимое ответа: " .
                $res['content']);

            $res = Entity::asArray(json_decode($res['content']));
            // добавляем сохраненную сущность в реестр, чтоб потом корректно удалилась
            $registry = $this->getRegistry();
            $registry[ScheduledTasksTestEntity::class][$res['id']] = new ScheduledTasksTestEntity($res['id'], $res, "", $user);
            $this->setRegistry($registry);

            // убеждаемся в существовании назначенного задания и правильном содержании
            //$resExists = $this->dispatchRequest(ScheduledTasksTestEntity::$baseUrl . "/" . $res['id'], "GET", [], $user);
            $resExists = $this->dispatchRequest(
                ScheduledTasksTestEntity::$baseUrl . "_rpc", "POST",
                [
                    'action' => 'get_weekly_scheduled_task',
                    'scheduled_task_id' => $res['id']
                ], $user);
            Assert::assertEquals(200, $resExists['http_status']);

            // проверяем, что все устройства и группы ассоциированы с будильником
            $content = json_decode($resExists['content']);

            //echo "content..\r\n";
            //print_r($content);

            if(!empty($request['request']['devices'])){
                Assert::assertTrue(@!!$content->devices, "В ответе на создание назначенного задания нет устройств!");
            }

            if(!empty($request['request']['groups'])){
                Assert::assertTrue(@!!$content->groups, "В ответе на создание назначенного задания нет групп!");
            }

            Assert::assertTrue(@!!$content->week_scheduling, "В ответе на создание назначенного задания нет расписания!");

            if(@!!$content->devices) {
                $existsDevs = [];
                foreach ($content->devices as $dev) {
                    $existsDevs[] = $dev->id;
                }

                /*echo "requested devs: \r\n";
                print_r($request['request']['devices']);
                echo "existsDevs \r\n";
                print_r($existsDevs);*/

                // 2 проверки - в совокупности проверяют, что те и только те устройства, которые передали в запросе,
                // действительно добавлены к будильнику
                self::assertArraySubset($request['request']['devices'], $existsDevs);
                self::assertArraySubset($existsDevs, $request['request']['devices']);
            }

            if(@!!$content->groups) {
                $existsGroups = [];
                foreach ($content->groups as $grp) {
                    $existsGroups[] = $grp->id;
                }

                // 2 проверки - в совокупности проверяют, что те и только те группы, которые передали в запросе,
                // действительно добавлены к будильнику
                self::assertArraySubset($request['request']['groups'], $existsGroups);
                self::assertArraySubset($existsGroups, $request['request']['groups']);
            }

            //  останавливаем будильник
            $resTurnOff = $this->dispatchRequest(
                ScheduledTasksTestEntity::$baseUrl . "_rpc", "POST",
                [
                    'action' => 'turn_scheduled',
                    'scheduled_task_id' => $res['id'],
                    'turn' => 'off'
                ], $user);

            //echo "resTurnOFF\r\n";

            Assert::assertEquals(200, $resTurnOff['http_status']);
            $resTurnOffContent = json_decode($resTurnOff['content']);
            Assert::assertEquals("PAUSED", $resTurnOffContent->state);

            // вновь запускаем будильник
            $resTurnOn = $this->dispatchRequest(
                ScheduledTasksTestEntity::$baseUrl . "_rpc", "POST",
                [
                    'action' => 'turn_scheduled',
                    'scheduled_task_id' => $res['id'],
                    'turn' => 'on'
                ], $user);

            //echo "resTurnOFF\r\n";

            Assert::assertEquals(200, $resTurnOn['http_status']);
            $resTurnOnContent = json_decode($resTurnOn['content']);
            Assert::assertEquals("ACTIVE", $resTurnOnContent->state);



            $successIDs[] = $res['id'];
        }
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

        $distr = $this->disributor();
        $devIds = $distr['devices'];
        $groupIds = $distr['groups'];
        $users = $distr['users'];

        foreach ($users as $k => $user) {
            foreach ($devIds[$k] as $deviceId) {
                $this->addDeviceToFavorite($devices[$deviceId], $user);
            }

            foreach ($groupIds[$k] as $groupId) {
                $this->addGroupToFavorite($groups[$groupId], $user);
            }
        }
    }

    /**
     * @param $devId
     * @param $user
     * @param $disableCheck - true если сущность может не создаться (тогда мы сами проверяем результат запроса)
     * @return mixed
     */
    protected function addDeviceToFavorite($devId, $user, $disableCheck = false){
        $devToFav = [
            "id_device" => $devId,
            "entity_type" => "DEVICE"
        ];

        echo "Добавляется в избранное устройство #" . $devId . " для пользователя " . $user;
        return ($disableCheck)?
            $this->createEntityInstanceWOCheck(FavoritesTestEntity::class, $devToFav, "", $user) :
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

        $devInReg = $this->getEntityInRegistry(DevicesTestEntity::class, $id);
        $userList = $devInReg->getUserList();
        $userList[] = $user;
        $devInReg->setUserList($userList);
        $this->updateEntityInRegistry($devInReg, DevicesTestEntity::class, $id);

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

        $grpInReg = $this->getEntityInRegistry(GroupsTestEntity::class, $id);
        $userList = $grpInReg->getUserList();
        $userList[] = $user;
        $grpInReg->setUserList($userList);
        $this->updateEntityInRegistry($grpInReg, GroupsTestEntity::class, $id);

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