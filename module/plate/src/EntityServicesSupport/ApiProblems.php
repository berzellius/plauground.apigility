<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2017
 * Time: 17:17
 */

namespace plate\EntityServicesSupport;
use plate\Exception\ApiException;
use ZF\ApiProblem\ApiProblem;

trait ApiProblems
{
    /**
     * Ошибка доступа 403
     * @return ApiProblem
     */
    protected function notAllowed($problem = "Method not allowed!"){
        return new ApiProblem(403, $problem);
    }

    /**
     * @param $message
     * @throws ApiException
     */
    protected function notAllowedException($message){
        throw new ApiException($message, 403);
    }
}