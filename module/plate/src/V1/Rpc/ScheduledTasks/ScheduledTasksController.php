<?php
namespace plate\V1\Rpc\ScheduledTasks;

use plate\ControllerSupport\ControllerSupportUtils;
use plate\ControllerSupport\RpcController;
use plate\V1\Rest\Scheduled_tasks\ScheduledTasksService;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\Apigility\Documentation\Api;
use ZF\ApiProblem\ApiProblem;
use ZF\ContentNegotiation\ViewModel;

class ScheduledTasksController extends RpcController
{

    protected $scheduledTasksService;

    /**
     * ScheduledTasksController constructor.
     * @param ScheduledTasksService $scheduledTasksService
     */
    public function __construct(ScheduledTasksService $scheduledTasksService)
    {
        $this->setScheduledTasksService($scheduledTasksService);
    }

    public function scheduledTasksAction()
    {
        $queryParams = $this->getRequest()->isPost()? $this->bodyParams() : $this->params()->fromQuery();
        ControllerSupportUtils::assertParameterSet($queryParams, "action", "`action` parameter required!");
        $action = $queryParams['action'];

        switch ($action){
            case "create_scheduled":
                return $this->createScheduledTaskExtended($queryParams);
                break;
            case "change_week_days":
                return //$this->changeWeekday($queryParams);
                    new ApiProblem(403, "reconstruction...");
                break;
            case "change_time":
                return $this->changeTimeForWeeklyTask($queryParams);
                break;
            case "turn_scheduled":
                return $this->turnScheduled($queryParams);
                break;
            case "get_scheduled_tasks":
                $params = [];
                if(isset($queryParams['room_id'])){
                    $params['room_id'] = $queryParams['room_id'];
                }
                $res = $this->getScheduledTasksService()->fetchAllToArray($params, "WEEKLY")->getItems();
                return $res;
            case "get_weekly_scheduled_task":
                if(!isset($queryParams['scheduled_task_id'])){
                    return new ApiProblem(500, "scheduled_task_id parameter missing");
                }
                $res = $this->getScheduledTasksService()->fetch($queryParams['scheduled_task_id'], 'WEEKLY');

                return $res;
            default:
                throw new \Exception("no processor for action " . $action);
        }
    }

    /**
     * Включить/отключить день недели
     * @param $params
     * @return \plate\EntitySupport\Entity|ApiProblem
     */
    public function changeWeekday($params){
        $scheduled_task_id = ControllerSupportUtils::assertParameterSet($params, "scheduled_task_id", "`scheduled_task_id` parameter required!");
        $weekday = ControllerSupportUtils::assertParameterSet($params, "weekday", "`weekday` parameter required!");
        $turn = ControllerSupportUtils::assertParameterSet($params, "turn", "`turn` parameter required!");

        $res = $this->getScheduledTasksService()->changeWeekday($scheduled_task_id, $weekday, $turn);
        return $res;
    }

    /**
     * Сменить время срабатывания для еженедельных заданий
     * @param $queryParams
     * @return \plate\EntitySupport\Entity|ApiProblem
     */
    public function changeTimeForWeeklyTask($queryParams)
    {
        $scheduled_task_id = ControllerSupportUtils::assertParameterSet($queryParams, "scheduled_task_id", "`scheduled_task_id` parameter required!");
        $weekday = ControllerSupportUtils::assertParameterSet($queryParams, "weekday", "`weekday` parameter required!");
        $time = ControllerSupportUtils::assertParameterSet($queryParams, "time", "`time` parameter required!");
        $new_time = ControllerSupportUtils::assertParameterSet($queryParams, "new_time", "`new_time` parameter required!");

        return $this->getScheduledTasksService()->changeTimeForWeeklyTask($scheduled_task_id, $weekday, $time, $new_time);
    }

    /**
     * Включение и отключение назначенного задания
     * @param $queryParams
     * @return \plate\EntitySupport\Entity|ApiProblem
     */
    public function turnScheduled($queryParams)
    {
        $scheduled_task_id = ControllerSupportUtils::assertParameterSet($queryParams, "scheduled_task_id", "`scheduled_task_id` parameter required!");
        $turn = ControllerSupportUtils::assertParameterSet($queryParams, "turn", "`turn` parameter required!");

        return $this->getScheduledTasksService()->turnScheduled($scheduled_task_id, $turn);
    }

    /**
     * Создать назначенное задание в расширенном режиме
     * с возможностью задавать произвольное количество выполнения разных команд
     * в разное время, в разные дни
     * @param $queryParams
     * @return int|ApiProblem
     */
    public function createScheduledTaskExtended($queryParams)
    {
        return $this->getScheduledTasksService()->createScheduledTaskExtended(@$queryParams);
    }

    /**
     * @return ScheduledTasksService
     */
    public function getScheduledTasksService()
    {
        return $this->scheduledTasksService;
    }

    /**
     * @param ScheduledTasksService $scheduledTasksService
     */
    public function setScheduledTasksService($scheduledTasksService)
    {
        $this->scheduledTasksService = $scheduledTasksService;
    }
}
