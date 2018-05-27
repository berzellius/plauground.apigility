<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 24.05.2018
 * Time: 0:17
 */

namespace plate\Organizer;
use Iterator;
use plate\EntitySupport\collection\Collection;
use plate\EntitySupport\entity\Entity;
use plate\Organizer\exceptions\EntityFieldsOrganizerException;
use plate\Organizer\exceptions\OrganizerException;

class NestedSetsOrganizer extends Organizer
{

    /**
     * Организует объекты, хранимые в iterator, в NestedSets
     * @param Iterator $iterator - хранилище объектов (предполагается, что они отсортированы по lkey!)
     * @param string $collectionPrototypeClass
     * @return array
     * @throws \Exception
     */
    public function organize(Iterator $iterator, $collectionPrototypeClass = null)
    {
        // имена атрибутов NestedSets - level, (right/left)key, container
        // (дочерние объекты складываются в поле ->{$container} родителя)
        $fields = $this->getFieldsFromCollectionClass($collectionPrototypeClass);

        $initLevel = null;
        // $path будет хранить текущее состояние обхода объектов
        $path = [];
        $res = [];

        foreach ($iterator as $item) {
            $this->checkFieldsExists($fields, $item);


            $currentLevel = $item->{$fields->levelFieldName};
            $container = $item->{$fields->containerFieldName};

            if($initLevel == null){
                $initLevel = $currentLevel;
            }

            $lastLevel = $this->getPathLastLevel($path);
            if($lastLevel == null || $lastLevel <= $currentLevel){
                // идем вглубь иерархиий
                $this->addToPath($path, $item, $currentLevel, $container);
            }
            else{
                // возврат на уровень $currentLevel
                $this->wrapPath($path, $currentLevel);
                $this->addToPath($path, $item, $currentLevel, $container);

                if($currentLevel == $initLevel){
                    $res[] = $path[0]->e;
                    $path = [];
                    $this->addToPath($path, $item, $currentLevel, $container);
                }
            }
        }

        // остался необработанный path, требует сворачивания
        if(count($path) > 1){
            $this->wrapPath($path, $path[1]->level);
        }

        // остался необработанный path, уже свернут
        if(count($path) == 1){
            $res[] = $path[0]->e;
        }

        return $res;
    }

    /**
     * @param \stdClass $fields
     * @param Entity $item
     * @throws OrganizerException
     */
    protected function checkFieldsExists(\stdClass $fields, Entity $item){
        foreach ($fields as $field){
            if(!property_exists($item, $field) || !isset($item->$field) || $item->$field === ""){
                throw new EntityFieldsOrganizerException(
                    "entity of class " . get_class($item) . " has not field " . $field . " or field not filled");
            }
        }
    }

    /**
     * получить имена полей level, (left/right)key, container
     * @param $collectionPrototypeClass
     * @return \stdClass
     * @throws \Exception
     */
    protected function getFieldsFromCollectionClass($collectionPrototypeClass){
        $collectionPrototypeClass =
            ($collectionPrototypeClass == null)? $this->getCollectionPrototypeClass() : $collectionPrototypeClass;

        if($collectionPrototypeClass == null){
            throw new \Exception("$collectionPrototypeClass not set => cannot organize object in NestedSets structure");
        }

        $fields = ['lkeyFieldName', 'rkeyFieldName', 'containerFieldName', 'levelFieldName'];

        $res = new \stdClass();

        foreach ($fields as $field) {
            if (! property_exists($collectionPrototypeClass, $field)) {
                throw new \Exception("in $collectionPrototypeClass must be declared $field static field for NestedSets structure to be created");
            }

            $res->$field = $collectionPrototypeClass::$$field;
        }

        return $res;
    }

    /**
     * Добавление элемента в $path
     * @param $path
     * @param $element - элемент
     * @param $level - уровень
     * @param $container - имя контейнера
     */
    protected function addToPath(&$path, $element, $level, $container){
        $e = new \stdClass();
        $e->e = $element;
        $e->level = $level;
        $e->container = $container;

        $path[] = $e;
    }

    /**
     * Свернуть $path
     * @param $path
     * @param $currentLevel - до какого уровня
     */
    protected function wrapPath(&$path, $currentLevel){
        $reverseKeys = array_reverse(array_keys($path));
        // снизу вверх по ключам, до уровня $currentLevel включительно
        while (@($key = array_shift($reverseKeys))) if($path[$key]->level >= $currentLevel){
            $lastLevel = $this->getPathLastLevel($path);
            // от $reverseKeys отрезан 1й ключ
            foreach ($reverseKeys as $kkey){
                // идем наверх по ключам, пока не найдем родительский объект
                if($path[$kkey]->level < $lastLevel){
                    // $elem перетаскиваем снизу в родительский объект
                    $elem = array_pop($path);
                    $container = $elem->e->container;
                    $path[$kkey]->e->{$container}[] = $elem->e;
                    break;
                }
            }
        }
    }

    /**
     * @param $path
     * @return null|mixed
     */
    protected function getPathLastLevel(&$path)
    {
        return sizeof($path) > 0 ? end($path)->level : null;
    }
}