<?php
namespace plate\V1\Rest\Rooms;

use plate\EntitySupport\CheckPrivilegesAndDataRetrievingResource;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

/**
 * Class RoomsResource
 * Класс, реализующий маппинг методов обращения к коллециям и сущностям комнат
 * по запросам rest api /rooms[/:rooms_id]
 *
 * Абстрактный класс CheckPrivilegesAndDataRetrievingResource
 * реализует проверку данных залогиненного пользователя, маппинг к связанной таблице БД,
 * применение фильтров Apigility.
 *
 * @package plate\V1\Rest\Rooms
 */
class RoomsResource extends CheckPrivilegesAndDataRetrievingResource
{
    /**
     * Create a resource
     * Создание комнат через API не предусмотрено
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     * Удаление комнат через API не предусмотрено
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * Удаление списка комнат через API не предусмотрено
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * Получить данные о комнате по id
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->getMapper()->fetch($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * Получить список комнат
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->getMapper()->fetchAll($params);
    }

    /**
     * Patch (partial in-place update) a resource
     * Частичное обновление сущности комнаты через API не предусмотрено
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     * Частичное обновление списка комнат через API не предусмотрено
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     * Замена списка комнат через API не предусмотрена
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     * Полное обновление комнаты предусмотрено
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
