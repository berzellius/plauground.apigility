<?php

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 14.06.2017
 * Time: 21:12
 */
namespace plate\ControllerSupport;

use plate\Exception\ApiException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use ZF\ApiProblem\ApiProblem;
use ZF\ContentNegotiation\ViewModel;

class RpcController extends AbstractActionController
{
    /**
     * Execute the request
     *
     * @param  MvcEvent $e
     * @return mixed
     */
    public function onDispatch(MvcEvent $e){
        try{
            $result = parent::onDispatch($e);
            if($result instanceof ApiProblem){
                /** @var ApiProblem $result */
                $problem = $result;

                $e->setResult($problem->toArray());
                $e->getResponse()->setStatusCode($problem->toArray()['status']);
            }

            return $result;
        }
        catch (\Exception $exception){
            $result = new ViewModel(["error" => $exception->getMessage()]);
            $e->setResult($result);

            if($exception instanceof ApiException){
                $e->getResponse()->setStatusCode($exception->getHttpCode());
            }

            return $result;
        }
    }

}