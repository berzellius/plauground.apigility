<?php
/**
 * Created by PhpStorm.
 * User: berz
 * Date: 25.04.2017
 * Time: 17:12
 */

namespace plate\EntitySupport\traits;

/**
 * Class ResourceRetrievingData
 * Трейт, реализующий метод фильтрации данных в соответствии с заданными Filter во вкладке Fields
 * интерфейса apigility
 * @package plate\EntitySupport
 */
trait ResourceRetrievingData
{
    /**
     * Retrieve data
     *
     * Retrieve data from composed input filter, if any; if none, cast the data
     * passed to the method to an array. (применение InputFilter к данным)
     *
     * @param mixed $data
     * @return array
     */
    protected function retrieveData($data)
    {
        $filter = $this->getInputFilter();
        if (null !== $filter) {
            return $filter->getValues();
        }

        return (array) $data;
    }
}