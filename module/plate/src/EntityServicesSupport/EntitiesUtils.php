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
     * @param array $entities
     * @param string $grouping
     * @param array $map
     * @return array
     */
    public function groupEntities($entities, $grouping, $map)
    {
        $middle = [];

        foreach ($entities as $entity){
            $idField = ($grouping == '')? "id" : $grouping . ".id";

            if(!isset($middle[$entity[$idField]])){
                $middle[$entity[$idField]] = $this->getEntityPart($entity, $grouping);
            }

            foreach ($map as $part => $prefix) {
                $epart = $this->getEntityPart($entity, $prefix);
                if(!$this->nullArr($epart)) {
                    $middle[$entity[$idField]][$part][] = $epart;
                }
            }
        }

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