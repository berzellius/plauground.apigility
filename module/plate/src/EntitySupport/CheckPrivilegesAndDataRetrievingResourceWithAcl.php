<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 12.05.2017
 * Time: 22:32
 */

namespace plate\EntitySupport;


abstract class CheckPrivilegesAndDataRetrievingResourceWithAcl extends CheckPrivilegesAndDataRetrievingResource
{
    use AclListToResource;
}