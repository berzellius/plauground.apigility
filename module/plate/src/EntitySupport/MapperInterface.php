<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace plate\EntitySupport;

/**
 * Interface for StatusLib mappers
 */
interface MapperInterface
{
    /**
     * @param array|\Traversable|\stdClass $data 
     * @return Entity
     */
    public function create($data);

    /**
     * @param string $id 
     * @return Entity
     */
    public function fetch($id);

    /**
     * @param $params
     * @return Collection
     */
    public function fetchAll($params);

    /**
     * @param string $id 
     * @param array|\Traversable|\stdClass $data 
     * @return Entity
     */
    public function update($id, $data);

    /**
     * @param string $id 
     * @return bool
     */
    public function delete($id);
}
