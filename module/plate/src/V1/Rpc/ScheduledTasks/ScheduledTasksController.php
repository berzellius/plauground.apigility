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
        $queryParams = $this->bodyParams();
        ControllerSupportUtils::assertParameterSet($queryParams, "action", "`action` parameter required!");
        $action = $queryParams['action'];

        switch ($action){
            case "change_week_days":
                return $this->changeWeekday($queryParams);
                break;
            case "change_time":
                return $this->changeTimeForWeeklyTask($queryParams);
                break;
            case "turn_scheduled":
                return $this->turnScheduled($queryParams);
                break;
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
        $time = ControllerSupportUtils::assertParameterSet($queryParams, "time", "`time` parameter required!");

        return $this->getScheduledTasksService()->changeTimeForWeeklyTask($scheduled_task_id, $time);
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
