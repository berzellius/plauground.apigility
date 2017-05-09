<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014-2016 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZF\Apigility\Admin\Module as AdminModule;

/**
 * assumed as unchaged
 * $ git update-index --assume-unchanged IndexController.php
 * to undo
 * $ git update-index --no-assume-unchanged IndexController.php
 * Class IndexController
 * @package Application\Controller
 */
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        if (class_exists(AdminModule::class, false)) {
            return $this->redirect()->toRoute('zf-apigility/ui');
        }
        return new ViewModel();
    }
}
