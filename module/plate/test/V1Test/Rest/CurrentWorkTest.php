<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 25.03.2018
 * Time: 18:56
 */

namespace V1Test\Rest;

use PHPUnit\Framework\Assert;
use plate\EntitySupport\entity\Entity;
use plate\V1\Rest\Scheduled_tasks\Scheduled_tasksEntity;
use V1Test\Rest\BasicTest;
use V1Test\Rest\testData\FavoritesTestEntity;
use V1Test\Rest\testData\ScheduledTasksTestEntity;

require_once "BasicTest.php";

class CurrentWorkTest extends BasicTest
{
    public function testSimple(){
        /*$this->loadEntitiesSet(\TestDatasetsPart1::basicSet());


        $this->cleanUp();

        foreach ($successIDs as $id){
            // убеждаемся, что назначенное задание удалено
            $resDeleted = $this->dispatchRequest(ScheduledTasksTestEntity::$baseUrl . "/" . $id, "GET", [], $user);
            Assert::assertEquals(403, $resDeleted['http_status'], "Назаначенное задание #" . $id . " не удалено в ходе очистки");
        }*/
    }

    public function testCurrentWorkCases(){
        //echo "Успешный тест";
        $this->loadEntitiesSet(\TestDatasetsPart1::basicSet());

        //$this->doTheWorkForTestCurrentCode();
        $this->doTheCurrentWorkCases_schedulingServices();

        $this->cleanUp();
    }

    protected function doTheCurrentWorkCases_schedulingServices(){
        $this->basicGroupsDistribution();

        $users = ["testUser1", "testUser2"];
        $user = $users[0];
        $groups = $this->getGroupInRegistryIDs($user);
        $devices = $this->getDevicesInRegistryIDs($user);

        //print_r($groups);
        //print_r($devices);


        $data = [
            'devices_ids' => $devices[0] . ", " . $devices[1],
            'groups_ids' => $groups[0],
            'state' => 'ACTIVE',
            'command' => 'up',
            'name' => 'TEST_SCH_TASK_1',
            'stamps' => 'SUNDAY, MONDAY',
            'time' => '15:10',
            'period_type' => 'WEEKLY',
            'some_json' => ["a" => ["b", "c"]]
        ];
        $id = $this->createEntityInstance(ScheduledTasksTestEntity::class, $data, "", $user);

        /*
        $ch_weekdays = [
            'action' => 'change_week_days',
            'scheduled_tasks_id' => $id,
            'weekday' => 'SUNDAY',
            'turn' => 'off',
            'json' => ['a' => 'b', 'c' => [1, 3, ['d' => 'e']]]
        ];

        $this->dispatchRequest("/scheduled_tasks_rpc", "POST", $ch_weekdays, $user);
        */

        // что еще проверить по будильникам?
    }

    protected function doTheWorkForTestCurrentCode(){
        // СЮДА пишем код для тестирования текущих вещей
        $groups = $this->getGroupInRegistryIDs();
        $devices = $this->getDevicesInRegistryIDs();

        $users = ["testUser1", "testUser2"];

        $devId = $devices[3];
        $user = $users[1];

        $this->addRightsToDeviceWithCheck($devId, $user);

        // дважды добавляем в избранное..
        $id = $this->addDeviceToFavorite($devId, $user);
        // на второй вызов 3й параметр true чтоб не вызвать исключение когда сущность не будет создана в базе
        $res = $this->addDeviceToFavorite($devId, $user, true);

        // нельзя дважды добавлять в избранное
        Assert::assertEquals(403, $res['status']);


        // теперь тестируем группы
        $grpId = $groups[2];

        $this->addRightsToGroupWithCheck($grpId, $user);
        //  еще раз
        $this->addRightsToGroupWithCheck($grpId, $user);


        // и для нотификаторов
    }

}