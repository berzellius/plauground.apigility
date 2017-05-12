<?php
namespace plate\V1\Rest\Groups;

use plate\EntitySupport\CheckPrivilegesAndDataRetrievingResourceWithAcl;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use ZF\ApiProblem\ApiProblem;
use plate\EntitySupport\Collection;

class GroupsResource extends CheckPrivilegesAndDataRetrievingResourceWithAcl
{
    /**
     * Create a resource.
     * Обычному пользователю автоматически назначет доступ на созданную группу
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $data = $this->retrieveData($data);
        $cresult = $this->getMapper()->create($data);
        $newGrpId = $cresult->id;

        if(!$this->checkAdminPrivileges()) {
            $this->getUserAccessListMapper()->create(
                [
                    "grp_id" => $newGrpId,
                    "client_id" => $this->getLoggedInClientId()
                ]
            );
        }

        return $cresult;
    }

    /**
     * Delete a resource.
     * Если к группе имеет доступ более чем 1 пользователь,
     * то удалить ее может только админ
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        if($this->checkAdminPrivileges()){
            return $this->getMapper()->delete($id);
        }

        $aclDataOwnedCount = $this->getUserAccessListMapper()->fetchAll([
                "grp_id" => $id,
                "client_id" => $this->getLoggedInClientId()
            ])
            ->getCurrentItemCount();

        if($aclDataOwnedCount === 0){
            return new ApiProblem(403,"you have not access to this group");
        }

        $aclDataNotOwnedCount = $this->getUserAccessListMapper()->fetchAll([
            "grp_id" => $id,
            "client_id<=>" => $this->getLoggedInClientId()
        ]);

        if($aclDataNotOwnedCount > 0){
            $users = [];
            foreach ($aclDataNotOwnedCount as $user) {
                $users[] = $user->client_id;
            }
            return new ApiProblem(
                403,
                "cant delete: not only you have access to this group -> users: " . implode(", ", $users)
            );
        }

        return $this->getMapper()>$this->delete($id);
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $params = [
            "grp_id" => $id,
            "client_id" => $this->getLoggedInClientId()
        ];

        if(
            !$this->checkAdminPrivileges() &&
            $this->getUserAccessListMapper()->fetchAll($params)->getCurrentItemCount() == 0
        ){
            return $this->notAllowed();
        }

        return $this->getMapper()->fetch($id);
    }

    /**
     * Получить список групп. Для обычного пользователя
     * будут получены только группы, к которым предоставлен доступ
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        if($this->checkAdminPrivileges()){
            return $this->getMapper()->fetchAll($params);
        }

        $select = $this->getGroupsBySelector([]);

        $adapter = new Adapter(
            $this->getMapper()->getTable()->getAdapter()->getDriver(),
            $this->getMapper()->getTable()->getAdapter()->getPlatform()
        );

        $dbSelect = new DbSelect($select, $adapter);

        return new Collection($dbSelect);
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        $params = [
            "grp_id" => $id,
            "client_id" => $this->getLoggedInClientId()
        ];

        if(
            !$this->checkAdminPrivileges() &&
            $this->getUserAccessListMapper()->fetchAll($params)->getCurrentItemCount() == 0
        ){
            return $this->notAllowed();
        }

        $data = $this->retrieveData($data);
        return $this->getMapper()->update($id, $data);
    }

    /**
     * Возвращает Zend\Db\Sql\Select из тадлицы групп устройств с заданным фильтром $params
     * для обычных пользователей возвращает только те объекты, к которым есть разрешение в acl
     *
     * @param $params
     * @return Select
     */
    protected function getGroupsBySelector($params){
        $groupsTableName = $this->getMapper()->getTable()->table;
        $idFieldName = $this->getMapper()->getIdFieldName();

        if($this->checkAdminPrivileges()) {
            // админ
            $select = new Select();
            $select
                ->from($groupsTableName);

            foreach ($params as $pname => $pvalue) {
                $select->
                where(
                    $groupsTableName . "." . $pname . " = '" . $pvalue . "'"
                );
            }

            return $select;
        }
        else{
            // обычный пользователь - groups join devices_acl
            $clientId =  $this->getLoggedInClientId();
            $devicesACLTableName = $this->getUserAccessListMapper()->getTable()->table;

            $select = new Select();
            $select
                ->from($devicesACLTableName)
                ->join(
                    $groupsTableName,
                    $groupsTableName . "." . $idFieldName .
                    " = " .
                    $devicesACLTableName . ".grp_id"
                )
                ->columns([])
                ->where(
                    $devicesACLTableName . ".client_id = '$clientId'"
                );

            foreach($params as $pname => $pvalue) {
                $select->where(
                    $groupsTableName . "." . $pname . " = '" . $pvalue . "'"
                );
            }

            return $select;
        }
    }
}
