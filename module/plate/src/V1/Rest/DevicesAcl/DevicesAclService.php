<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 09.06.2017
 * Time: 21:46
 */

namespace plate\V1\Rest\DevicesAcl;


use plate\EntityServicesSupport\EntityService;

class DevicesAclService extends EntityService
{
    public function addRightsToDevice($user, $deviceId){
        $data = [
            'client_id' => $user,
            'device_id' => $deviceId
        ];

        return $this->getTableMapper()->create($data);
    }

    public function addRightsToGroup($user, $groupID)
    {
        $data = [
            'client_id' => $user,
            'grp_id' => $groupID
        ];

        return $this->getTableMapper()->create($data);
    }
}