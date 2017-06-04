<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 31.05.2017
 * Time: 20:42
 */

namespace plate\V1\Rest\Favorites;


use plate\EntityServicesSupport\EntityService;
use plate\EntitySupport\Entity;
use plate\V1\Rest\DevicesAcl\UserAccessUtilsForServices;
use plate\V1\Rest\Scheduled_tasks\Scheduled_tasksEntity;
use plate\V1\Rest\Scheduled_tasks\Scheduled_tasksResource;
use ZF\Apigility\Documentation\Api;
use ZF\ApiProblem\ApiProblem;

class FavoritesService extends EntityService
{
    use UserAccessUtilsForServices;

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @param  mixed $retrievedData
     * @return mixed|ApiProblem
     */
    public function create($data, $retrievedData)
    {
        $type = $retrievedData['entity_type'];
        switch ($type){
            case "DEVICE":
                if(!isset($retrievedData['id_device'])){
                    return new ApiProblem(403, "for 'DEVICE' record you must set id_device");
                }

                if(isset($retrievedData['id_group']) || isset($retrievedData['id_scheduled_task'])){
                    return new ApiProblem(403, "for 'DEVICE' record id_group or id_scheduled_task cant be set");
                }
                break;
            case "GROUP":
                if(!isset($retrievedData['id_group'])){
                    return new ApiProblem(403, "for 'GROUP' record you must set id_group");
                }

                if(isset($retrievedData['id_device']) || isset($retrievedData['id_scheduled_task'])){
                    return new ApiProblem(403, "for 'GROUP' record id_device or id_scheduled_task cant be set");
                }
                break;
            case "SCHEDULED":
                if(!isset($retrievedData['id_scheduled_task'])){
                    return new ApiProblem(403, "for 'SCHEDULED' record you must set id_device");
                }

                if(isset($retrievedData['id_group']) || isset($retrievedData['id_device'])){
                    return new ApiProblem(403, "for 'SCHEDULED' record id_group or id_device cant be set");
                }
                break;
        }

        if(!$this->checkPrivileges($retrievedData)){
            return $this->notAllowed();
        }

        if(!$this->getAuthUtils()->checkAdminPrivileges()){
            $retrievedData['user'] = $this->getAuthUtils()->getClientId();
        }


        return $this->getTableMapper()->create($retrievedData);
    }

    public function delete($id)
    {
        $entity = $this->getTableMapper()->fetch($id);
        if(!$this->checkPrivileges($entity)){
            return $this->notAllowed();
        }

        return $this->getTableMapper()->delete($id);
    }

    protected function checkPrivileges($data)
    {
        if($this->getAuthUtils()->checkAdminPrivileges())
            return true;

        if($data instanceof Entity){
            $data = Entity::asArray($data);
        }

        $type = isset($data['entity_type'])? $data['entity_type'] : false;
        if(!$type)
            return false;

        $params = [];
        switch ($type){
            case "GROUP":
                if(!isset($data['id_group']))
                    return false;

                $params = [
                    "grp_id" => $data['id_group'],
                    "client_id" => $this->getAuthUtils()->getClientId()
                ];
                break;
            case "DEVICE":
                if(!isset($data['id_device']))
                    return false;

                $params = [
                    "device_id" => $data['id_device'],
                    "client_id" => $this->getAuthUtils()->getClientId()
                ];
                break;
            case "SCHEDULED":
                if(!isset($data['id_scheduled_task']))
                    return false;

                $scheduledTask = $this->getScheduledTasksMapper()->fetch($data['id_scheduled_task']);
                $scheduledTask = Entity::asArray($scheduledTask);
                if(Scheduled_tasksEntity::getEntityDevGrpType($scheduledTask) == "GROUP"){
                    $params = [
                        "grp_id" => $scheduledTask['id_group'],
                        "client_id" => $this->getAuthUtils()->getClientId()
                    ];
                }

                if(Scheduled_tasksEntity::getEntityDevGrpType($scheduledTask) == "DEVICE"){
                    $params = [
                        "device_id" => $scheduledTask['id_device'],
                        "client_id" => $this->getAuthUtils()->getClientId()
                    ];
                }

                break;
            default:
                return false;
        }
        return $this->checkPrivilegesByFilter($params);
    }

    public function deleteByEntityTypeAndId($entity_type, $entity_id)
    {
        $data = array(
            'entity_type' => $entity_type
        );

        switch ($entity_type){
            case "GROUP":
                $data['id_group'] = $entity_id;
                break;

            case "DEVICE":
                $data['id_device'] = $entity_id;
                break;

            case "SCHEDULED_TASK":
                $data['id_scheduled_task'] = $entity_id;
                break;

            default:
                return $this->notAllowed();
        }

        if(!$this->checkPrivileges($data)){
            return $this->notAllowed();
        }

        $found = $this->getTableMapper()->fetchAll($data);
        $foundItems = $found->getCurrentItems();

        if($found->getCurrentItemCount() == 0)
            return new ApiProblem(404, "record not found!");

        $toDelete = $foundItems[0];
        return $this->delete($toDelete['id']);
    }

    protected function getScheduledTasksMapper(){
        return $this->getITableService()->getTableMapperByKey(Scheduled_tasksResource::class);
    }

    public function fetchAll($params)
    {
        return $this->getTableMapper()->fetchAll($params);
    }
}