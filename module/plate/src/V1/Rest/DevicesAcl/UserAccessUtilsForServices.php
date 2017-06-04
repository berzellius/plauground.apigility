<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 03.06.2017
 * Time: 17:04
 */

namespace plate\V1\Rest\DevicesAcl;


trait UserAccessUtilsForServices
{
    protected function getUserAccessListMapper(){
        return $this->getITableService()->getTableMapperByKey(DevicesAclResource::class);
    }

    protected function getUserAccessListMapperTableName(){
        $mapper = $this->getUserAccessListMapper();
        return $mapper->getTable()->table;
    }

    protected function checkPrivilegesByFilter(array $filter){
        return ($this->getUserAccessListMapper()->fetchAll($filter)->getCurrentItemCount() > 0);
    }
}