<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 20.05.2018
 * Time: 22:54
 */

namespace plate\V1\Rest\Entities;


use plate\EntityServicesSupport\EntityService;
use plate\Json\JsonModelAlt;
use Zend\View\Helper\ViewModel;

/**
 * Бизнес-логика работы с Entities
 * Class EntitiesService
 * @package plate\V1\Rest\Entities
 */
class EntitiesService extends EntityService
{

    public function fetchAll($params)
    {
        // работа с Entities напрямую - только админу
        if(!$this->getAuthUtils()->checkAdminPrivileges() && false){
            return $this->notAllowed();
        }

        $res = $this->getTableMapper()->fetchAll($params);
        //$json = new JsonModelAlt();
        //$json->setVariables($res->getCurrentItems());
        //die($json->serialize());
        //return new ViewModel($res->getCurrentItems());

        return $res;
    }
}