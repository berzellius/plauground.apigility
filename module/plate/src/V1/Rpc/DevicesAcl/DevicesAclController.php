<?php
namespace plate\V1\Rpc\DevicesAcl;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class DevicesAclController extends AbstractActionController
{
    public function devicesAclAction()
    {
        return new ViewModel(
            array()
        );
    }
}
