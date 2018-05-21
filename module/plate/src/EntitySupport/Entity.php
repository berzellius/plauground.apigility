<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace plate\EntitySupport;

use Zend\Stdlib\ArrayObject;

/**
 * Class Entity
 * Класс, который наследуют мапперы сущностей
 * @package plate\EntitySupport
 */
class Entity extends ArrayObject
{
    /**
     * Представить объект ассоциативным массивом
     * @param $entity
     * @return mixed
     */
    public static function asArray($entity)
    {
        return json_decode(json_encode($entity), true);
    }
}
