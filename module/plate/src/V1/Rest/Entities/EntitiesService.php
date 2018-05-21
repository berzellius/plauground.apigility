<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 20.05.2018
 * Time: 22:54
 */

namespace plate\V1\Rest\Entities;


use plate\EntityServicesSupport\EntityService;

/**
 * Бизнес-логика работы с Entities
 * Class EntitiesService
 * @package plate\V1\Rest\Entities
 */
class EntitiesService extends EntityService
{

    public function fetchAll($params)
    {
        if(!$this->getAuthUtils()->checkAdminPrivileges()){
            return $this->notAllowed();
        }

        return $this->getTableMapper()->fetchAll($params);
    }
}