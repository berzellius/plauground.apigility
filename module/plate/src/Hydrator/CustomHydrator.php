<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 23.05.2018
 * Time: 21:02
 */

namespace plate\Hydrator;


use plate\EntitySupport\entity\Entity;
use Zend\Hydrator\ObjectProperty;

/**
 * Реализация hydrator'а, более подходящая в данном проекте
 * Class CustomHydrator
 * @package plate\Hydrator
 */
class CustomHydrator extends ObjectProperty
{
    /**
     * @param array $data
     * @param object $object
     * @return object
     */
    public function hydrate(array $data, $object){

        if($object instanceof Entity){
            $prototype = EntityMapperFactory::getEntityObject($data, $object);

            // у каждого класса свой набор полей
            if(method_exists($prototype, 'getFieldsMap')){
                $map = $prototype::getFieldsMap();

                foreach ($data as $k => $v){
                    if(!in_array($k, $map)){
                        unset($data[$k]);
                    }
                }
            }
        }
        else {
            $prototype = $object;
        }

        $result = parent::hydrate($data, $prototype);
        return $result;
    }
}