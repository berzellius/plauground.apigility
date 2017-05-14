<?php
namespace plate\V1\Rest\Dev2grp;

use plate\EntitySupport\CheckPrivilegesAndDataRetrievingResourceWithAcl;
use plate\EntitySupport\Collection;
use plate\EntitySupport\TableGatewayMapper;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class Dev2grpResource extends CheckPrivilegesAndDataRetrievingResourceWithAcl
{
    protected $oauthUsersControlTableGatewayMapper;

    /**
     * Dev2grpResource constructor.
     */
    public function __construct(
        TableGatewayMapper $mapper,
        TableGatewayMapper $userAccessListMapper,
        TableGatewayMapper $oauthUsersControlTableGatewayMapper
    )
    {
        parent::__construct($mapper, $userAccessListMapper);
        $this->setOauthUsersControlTableGatewayMapper($oauthUsersControlTableGatewayMapper);
    }


    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $data = $this->retrieveData($data);
        $grp_id = $data['group_id'];
        $dev_id = $data['device_id'];

        // проверяем права на группу
        if(
            !$this->checkAdminPrivileges() &&
            $this->getUserAccessListMapper()
                ->fetchAll([
                    'grp_id' => $grp_id,
                    'client_id' => $this->getLoggedInClientId()
                ])
                ->getCurrentItemCount() == 0
        ){
            return $this->notAllowed("У вас нет доступа к группе#" . $grp_id);
        }

        // проверяем права на устройство
        if(
            !$this->checkAdminPrivileges() &&
            $this->getUserAccessListMapper()
                ->fetchAll([
                    'device_id' => $dev_id,
                    'client_id' => $this->getLoggedInClientId()
                ])
                ->getCurrentItemCount() == 0
        ){
                return $this->notAllowed("У вас нет доступа к устройству#" . $dev_id);
        }

        // проверяем, что нет пользователей, у которых есть права на группу,
        // но нет прав на добавляемое устройство
        $userAccessListTable = $this->getUserAccessListMapper()->getTable()->table;
        $usersControlTable = $this->getOauthUsersControlTableGatewayMapper()->getTable()->table;

        $select = new Select();
        $select->from(
            array('da1' => $userAccessListTable)
        )
        ->join(
            array('ou' => $usersControlTable),
            new Expression("ou.client_id = da1.client_id and da1.grp_id = " . $grp_id . ""),
            ["client_id"],
            Select::JOIN_RIGHT
        )
        ->join(
            array('da2' => $userAccessListTable),
            new Expression("ou.client_id = da2.client_id and da2.device_id = " . $dev_id . ""),
            [],
            Select::JOIN_LEFT
        )
        ->columns([])
        ->where("da2.id is null")
        ->where("da1.id is not null", Predicate::OP_AND);

        $adapter = new Adapter(
            $this->getOauthUsersControlTableGatewayMapper()->getTable()->getAdapter()->getDriver(),
            $this->getOauthUsersControlTableGatewayMapper()->getTable()->getAdapter()->getPlatform()
        );

        $dbSelect = new DbSelect($select, $adapter);
        $collection = new Collection($dbSelect);
        if($collection->getCurrentItemCount() > 0){
            $users = [];
            foreach($collection->getCurrentItems() as $item){
                $users[] = $item->client_id;
            }
            return new ApiProblem(
                422,
                'Невозможно добавить устройство в группу: есть пользвователи, не имеющие доступ к устройству#' . $dev_id .
                ' и имеющие доступ к группе#' . $grp_id . '; сначала предоставьте доступ к устройству#' . $dev_id .
                ' следующим пользователям: ' . implode(',', $users)
            );
        }

        return $this->getMapper()->create($data);
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $data = $this->getMapper()->fetch($id);

        $grp_id = $data['group_id'];
        $dev_id = $data['device_id'];

        // проверяем права на группу
        if(
            !$this->checkAdminPrivileges() &&
            $this->getUserAccessListMapper()
                ->fetchAll([
                    'grp_id' => $grp_id,
                    'client_id' => $this->getLoggedInClientId()
                ])
                ->getCurrentItemCount() == 0
        ){
            return $this->notAllowed("У вас нет доступа к группе#" . $grp_id);
        }

        // проверяем права на устройство
        if(
            !$this->checkAdminPrivileges() &&
            $this->getUserAccessListMapper()
                ->fetchAll([
                    'device_id' => $dev_id,
                    'client_id' => $this->getLoggedInClientId()
                ])
                ->getCurrentItemCount() == 0
        ){
            return $this->notAllowed("У вас нет доступа к устройству#" . $dev_id);
        }

        return $this->getMapper()->delete($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        if($this->checkAdminPrivileges()){
            return $this->getMapper()->fetchAll($params);
        }

        $userAccessListTable = $this->getUserAccessListMapper()->getTable()->table;
        $devGrpTable = $this->getMapper()->getTable()->table;
        $clientId = $this->getLoggedInClientId();

        $select = new Select();
        $select
            ->from(['da1' => $userAccessListTable])
            ->join(
                ['dev' => $devGrpTable],
                "dev.device_id = da1.device_id",
                ["id", "device_id", "group_id"],
                Select::JOIN_RIGHT
            )
            ->join(
                ['da2' => $userAccessListTable],
                "dev.group_id = da2.grp_id",
                [],
                Select::JOIN_LEFT
            )
            ->columns([])
            ->where("da1.id is not null")
            ->where("da1.client_id = '" . $clientId . "'", Predicate::OP_AND)
            ->where("da2.id is not null", Predicate::OP_AND)
            ->where("da2.client_id = '" . $clientId . "'", Predicate::OP_AND);

        foreach($params as $pname => $pvalue){
            $select->where("dev." . $pname . " = " . $pvalue);
        }

        $adapter = new Adapter(
            $this->getMapper()->getTable()->getAdapter()->getDriver(),
            $this->getMapper()->getTable()->getAdapter()->getPlatform()
        );

        $dbSelect = new DbSelect($select, $adapter);
        return new Collection($dbSelect);
    }

    /**
     * @return TableGatewayMapper
     */
    public function getOauthUsersControlTableGatewayMapper()
    {
        return $this->oauthUsersControlTableGatewayMapper;
    }

    /**
     * @param TableGatewayMapper $oauthUsersControlTableGatewayMapper
     */
    public function setOauthUsersControlTableGatewayMapper($oauthUsersControlTableGatewayMapper)
    {
        $this->oauthUsersControlTableGatewayMapper = $oauthUsersControlTableGatewayMapper;
    }


}
