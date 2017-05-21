<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 21.05.2017
 * Time: 17:17
 */

namespace plate\EntityServicesSupport;
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
}