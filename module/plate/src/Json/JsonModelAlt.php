<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace plate\Json;

use JsonSerializable;
use Zend\Json\Json;
use Zend\Stdlib\JsonSerializable as StdlibJsonSerializable;
use Zend\View\Model\JsonModel as BaseJsonModel;
use ZF\ContentNegotiation\JsonModel;
use ZF\Hal\Entity as HalEntity;
use ZF\Hal\Collection as HalCollection;

class JsonModelAlt extends JsonModel
{
    /**
     * Формирование Json - с корректировками
     *
     * @return string
     */
    public function serialize()
    {
        $variables = $this->getVariables();

        // 'payload' == payload for HAL representations
        if (isset($variables['payload'])) {
            $variables = $variables['payload'];
        }

        // Use ZF\Hal\Entity's composed entity
        if ($variables instanceof HalEntity) {
            $variables = method_exists($variables, 'getEntity')
                ? $variables->getEntity() // v1.2+
                : $variables->entity;     // v1.0-1.1.*
        }

        // Use ZF\Hal\Collection's composed collection
        if ($variables instanceof HalCollection) {
            $variables = $variables->getCollection();
            //$variables->getCurrentItems()['some'] = 'other';
        }

        if (null !== $this->jsonpCallback) {
            return $this->jsonpCallback.'('.Json::encode($variables).');';
        }

        $serialized = Json::encode($variables);

        if (false === $serialized) {
            $this->raiseError(json_last_error());
        }

        return $serialized;
    }
}
