<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 04.08.2018
 * Time: 16:37
 */

namespace plate\V1\Rest\EntitiesUserContext;


use plate\EntityServicesSupport\EntityService;
use plate\Hydrator\CustomHydratingResultSet;
use Rhumsaa\Uuid\Console\Exception;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Where;
use ZF\ApiProblem\ApiProblem;

class EntitiesUserContextService extends EntityService
{
    /**
     * @param $entityId
     * @return void
     * @throws \plate\Exception\ApiException
     */
    public function likeEntity($entityId)
    {
        $this->toggleFavorite($entityId, 1);
    }

    /**
     * @param $entityId
     * @return void
     * @throws \plate\Exception\ApiException
     */
    public function dislikeEntity($entityId)
    {
        $this->toggleFavorite($entityId, 0);
    }

    /**
     * @param int $entityID
     * @return bool
     */
    public function checkRights($entityID){
        if($this->getAuthUtils()->checkAdminPrivileges()){
            return true;
        }

        $select = new Select($this->getTableName());
        $select
            ->where($this->buildWhereByEntityIdAndCurrentUser($entityID));

        /**
         * @var CustomHydratingResultSet
         */
        $res = $this->getTableMapper()->getTable()->selectWith($select)->toObjectsArray();

        if(0 == count($res)){
            return false;
        }

        if(1 == count($res)){
            return $res['response']->isAllowed == 1;
        }

        $this->exceptionMisconfigurationMoreThanOneUserContextForEntity(count($res));
        return false;
    }

    /**
     * @param $entityID integer
     * @param $favorite integer
     * @return void
     * @throws \plate\Exception\ApiException
     */
    protected function toggleFavorite(
        $entityID, $favorite
    ){
        $this->beginTransaction();

        if(! $this->checkRights($entityID)){
            $this->rollbackTransaction();
            $this->notAllowedException("user has not rights for entity#" . $entityID);
        };

        $update = new Update($this->getTableName());
        $update
            ->set(["isFavorite" => $favorite])
            ->where($this->buildWhereByEntityIdAndCurrentUser($entityID));

        /**
         * @var int - количество затронутых строк
         */
        $res = $this->getTableMapper()->getTable()->updateWith($update);

        if(1 == $res) {
            $this->commitTransaction();
        }

        if(1 < $res) {
            $this->exceptionMisconfigurationMoreThanOneUserContextForEntity($res);
        }
    }

    protected function buildWhereByEntityIdAndCurrentUser($entityID){
        $where = new Where();
        $where
            ->expression("ent_id = ?", $entityID)
            ->expression("user = ?", $this->getAuthUtils()->getClientId());

        return $where;
    }

    /**
     * Обработка случая, когда есть более одной записи userContext
     * для конкретной сущности и конкретного пользователя
     * @param $count
     */
    protected function exceptionMisconfigurationMoreThanOneUserContextForEntity($count)
    {
        throw new Exception("error while `like` operation. for one entity we have $count `user-context` row. maybe misconfiguration or wrong sql code");
    }
}