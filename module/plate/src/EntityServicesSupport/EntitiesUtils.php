<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 11.06.2017
 * Time: 21:13
 */

namespace plate\EntityServicesSupport;


class EntitiesUtils
{
    /**
     * Распределить сущности разных типов по вложенным массивам
     * @param array $entities - входной массив
     * @param $joining - тип сущности, которая объединяет другие сущности, например, favorite для Избранного
     * @return array
     */
    public function sortDiffrerentTypeEntities(array $entities, $joining){
        $res = [
            'devices' => [],
            'groups' => [],
            'scheduled_tasks' => []
        ];

        $jkey = $joining . '.entity_type';

        foreach ($entities as $entity){
            if(isset($entity[$jkey])){
                switch (strtolower($entity[$jkey])){
                    case "device":
                        $res['devices'][] = $this->getEntityPart($entity, "device");
                        break;
                    case "group":
                        $res['groups'][] = $this->getEntityPart($entity, "group");
                        break;
                    case "scheduled":
                        $res['scheduled_tasks'][] = $this->getEntityPart($entity, "scheduled");
                }
            }
        }

        $res['scheduled_tasks'] = $this->groupEntities($res['scheduled_tasks'], '', ['groups' => 'group', 'devices' => 'device']);

        return $res;
    }

    protected function getEntityPart($entity, $key)
    {
        $res = [];
        foreach ($entity as $k => $value) {
            if($key != '' && strpos($k, $key . ".") === 0){
                $res[str_replace($key . ".", "", $k)] = $value;
            }

            if($key == '' && strpos($k, ".") === false){
                $res[$k] = $value;
            }
        }

        return $res;
    }


    /**
     * Группировка сущностей одного типа по контейнерам
     *
     * @param array $entities - входной массив. Содержит в себе плоскую структуру вида
     * [
     *      {
     *          'scheduled.id' : 1,
     *          'scheduled.name' : 'some name1',
     *          'device.id' : 3,
     *          'device.name' : 'some dev 1'
     *      },
     *      {
     *          'scheduled.id' : 2,
     *          'scheduled.name' : 'some name2',
     *          'device.id' : 4,
     *          'device.name' : 'some dev 2'
     *      }
     * ]
     * @param string $grouping - задает главную сущность, например 'scheduled'
     * @param array $map - задает соответствие "название контейнера, куда складывать объекты - префикс в именах полей",
     *  например, ['devices' => 'device']
     * @param array $idmap, опционально - перечень соответствий "название контейнера - название id"
     * @return array - результат  работы, для рассмотренного примера
     * [
     * {
     * 'id' : 1,
     * 'name' : 'some name 1',
     * 'devices' : [
     * {'id': 3, 'name' : 'some dev 1'}
     * ]
     * },
     * (...)
     * ]
     */
    public function groupEntities(array $entities, $grouping, array $map, array $idmap = null)
    {
        $middle = [];
        $usedEntities = [];

        foreach ($entities as $entity){
            $idField = ($grouping == '')? "id" : $grouping . ( ($idmap == null || !isset($idmap[$grouping]))? ".id" : "." . $idmap[$grouping]);

            if(!isset($middle[$entity[$idField]])){
                $middle[$entity[$idField]] = $this->getEntityPart($entity, $grouping);
            }

            foreach ($map as $part => $prefix) {
                $epart = $this->getEntityPart($entity, $prefix);
                if(!$this->nullArr($epart)) {
                    if($idmap != null && isset($idmap[$part])) {
                        if(!@($usedEntities[$part][$epart[$idmap[$part]]] == 1)) {
                            $usedEntities[$part][$epart[$idmap[$part]]] = 1;
                            $middle[$entity[$idField]][$part][] = $epart;
                        }
                    }
                    else
                        $middle[$entity[$idField]][$part][] = $epart;
                }

            }
        }

        //print_r($usedEntities);
        //print_r($middle);

        return array_values($middle);
    }

    /**
     * @param array $arr
     * @return bool
     */
    protected function nullArr(array $arr){
        foreach ($arr as $item) {
            if($item != null)
                return false;
        }

        return true;
    }
}