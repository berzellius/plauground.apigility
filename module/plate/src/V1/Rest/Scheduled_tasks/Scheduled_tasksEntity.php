<?php
namespace plate\V1\Rest\Scheduled_tasks;

use plate\EntitySupport\Entity;

class Scheduled_tasksEntity extends Entity
{
    /**
     * @param array $entity - сущность Scheduled_task в виде ассоциативного массива
     * @return mixed - тип назначенного задания: привязанное к группе устройств или к устройству
     */
    public static function getEntityDevGrpType(array $entity){
        if(!isset($entity['grp_dev_type'])){
            throw new \LogicException("given ScheduledTasks entity has not field 'grp_dev_type'");
        }

        if($entity['grp_dev_type'] != 'GROUP' && $entity['grp_dev_type'] != 'DEVICE'){
            throw new \LogicException("given ScheduledTasks entity has wrong 'grp_dev_type' value");
        }

        return $entity['grp_dev_type'];
    }
}
