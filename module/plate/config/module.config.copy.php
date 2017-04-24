<?php
return [
    'service_manager' => [
        'factories' => [
            \plate\V1\Rest\Motion\MotionResource::class => \plate\V1\Rest\Motion\MotionResourceFactory::class,
            \plate\V1\Rest\Status\StatusResource::class => \plate\V1\Rest\Status\StatusResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'plate.rest.motion' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/motion[/:motion_id]',
                    'defaults' => [
                        'controller' => 'plate\\V1\\Rest\\Motion\\Controller',
                    ],
                ],
            ],
            'plate.rest.api-test' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api_test[/:api_test_id]',
                    'defaults' => [
                        'controller' => 'plate\\V1\\Rest\\ApiTest\\Controller',
                    ],
                ],
            ],
            'plate.rest.oauth-clients' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/oauth_clients[/:oauth_clients_id]',
                    'defaults' => [
                        'controller' => 'plate\\V1\\Rest\\OauthClients\\Controller',
                    ],
                ],
            ],
            'plate.rest.status' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/status[/:status_id]',
                    'defaults' => [
                        'controller' => 'plate\\V1\\Rest\\Status\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'plate.rest.motion',
            2 => 'plate.rest.api-test',
            3 => 'plate.rest.oauth-clients',
            4 => 'plate.rest.status',
        ],
    ],
    'zf-rest' => [
        'plate\\V1\\Rest\\Motion\\Controller' => [
            'listener' => \plate\V1\Rest\Motion\MotionResource::class,
            'route_name' => 'plate.rest.motion',
            'route_identifier_name' => 'motion_id',
            'collection_name' => 'motion',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
                4 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \plate\V1\Rest\Motion\MotionEntity::class,
            'collection_class' => \plate\V1\Rest\Motion\MotionCollection::class,
            'service_name' => 'motion',
        ],
        'plate\\V1\\Rest\\ApiTest\\Controller' => [
            'listener' => 'plate\\V1\\Rest\\ApiTest\\ApiTestResource',
            'route_name' => 'plate.rest.api-test',
            'route_identifier_name' => 'api_test_id',
            'collection_name' => 'api_test',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \plate\V1\Rest\ApiTest\ApiTestEntity::class,
            'collection_class' => \plate\V1\Rest\ApiTest\ApiTestCollection::class,
            'service_name' => 'api_test',
        ],
        'plate\\V1\\Rest\\OauthClients\\Controller' => [
            'listener' => 'plate\\V1\\Rest\\OauthClients\\OauthClientsResource',
            'route_name' => 'plate.rest.oauth-clients',
            'route_identifier_name' => 'oauth_clients_id',
            'collection_name' => 'oauth_clients',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \plate\V1\Rest\OauthClients\OauthClientsEntity::class,
            'collection_class' => \plate\V1\Rest\OauthClients\OauthClientsCollection::class,
            'service_name' => 'oauth_clients',
        ],
        'plate\\V1\\Rest\\Status\\Controller' => [
            'listener' => \plate\V1\Rest\Status\StatusResource::class,
            'route_name' => 'plate.rest.status',
            'route_identifier_name' => 'status_id',
            'collection_name' => 'status',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \StatusLib\Entity::class,
            'collection_class' => \StatusLib\Collection::class,
            'service_name' => 'Status',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'plate\\V1\\Rest\\Motion\\Controller' => 'Json',
            'plate\\V1\\Rest\\ApiTest\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\OauthClients\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Status\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'plate\\V1\\Rest\\Motion\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'plate\\V1\\Rest\\ApiTest\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'plate\\V1\\Rest\\OauthClients\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'plate\\V1\\Rest\\Status\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'plate\\V1\\Rest\\Motion\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ],
            'plate\\V1\\Rest\\ApiTest\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ],
            'plate\\V1\\Rest\\OauthClients\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ],
            'plate\\V1\\Rest\\Status\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \plate\V1\Rest\Motion\MotionEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.motion',
                'route_identifier_name' => 'motion_id',
                'hydrator' => \Zend\Hydrator\ObjectProperty::class,
            ],
            \plate\V1\Rest\Motion\MotionCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.motion',
                'route_identifier_name' => 'motion_id',
                'is_collection' => true,
            ],
            \plate\V1\Rest\ApiTest\ApiTestEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.api-test',
                'route_identifier_name' => 'api_test_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \plate\V1\Rest\ApiTest\ApiTestCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.api-test',
                'route_identifier_name' => 'api_test_id',
                'is_collection' => true,
            ],
            \plate\V1\Rest\OauthClients\OauthClientsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.oauth-clients',
                'route_identifier_name' => 'oauth_clients_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \plate\V1\Rest\OauthClients\OauthClientsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.oauth-clients',
                'route_identifier_name' => 'oauth_clients_id',
                'is_collection' => true,
            ],
            'plate\\V1\\Rest\\Status\\StatusEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.status',
                'route_identifier_name' => 'status_id',
                'hydrator' => \Zend\Hydrator\ObjectProperty::class,
            ],
            'plate\\V1\\Rest\\Status\\StatusCollection' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.status',
                'route_identifier_name' => 'status_id',
                'is_collection' => true,
            ],
            \StatusLib\Entity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.status',
                'route_identifier_name' => 'status_id',
                'hydrator' => \Zend\Hydrator\ObjectProperty::class,
            ],
            \StatusLib\Collection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.status',
                'route_identifier_name' => 'status_id',
                'is_collection' => true,
            ],
            'plate\\V1\\Rest\\Status\\EntitySupport\\' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.status',
                'route_identifier_name' => 'status_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            'plate\\V1\\Rest\\Status\\Collection' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.status',
                'route_identifier_name' => 'status_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-content-validation' => [
        'plate\\V1\\Rest\\Motion\\Controller' => [
            'input_filter' => 'plate\\V1\\Rest\\Motion\\Validator',
        ],
        'plate\\V1\\Rest\\ApiTest\\Controller' => [
            'input_filter' => 'plate\\V1\\Rest\\ApiTest\\Validator',
        ],
        'plate\\V1\\Rest\\OauthClients\\Controller' => [
            'input_filter' => 'plate\\V1\\Rest\\OauthClients\\Validator',
        ],
        'plate\\V1\\Rest\\Status\\Controller' => [
            'input_filter' => 'plate\\V1\\Rest\\Status\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'plate\\V1\\Rest\\Motion\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'status',
                'description' => 'status of command',
            ],
        ],
        'plate\\V1\\Rest\\OauthClients\\Validator' => [
            0 => [
                'name' => 'client_id',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '80',
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'client_secret',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '80',
                        ],
                    ],
                ],
            ],
            2 => [
                'name' => 'redirect_uri',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '2000',
                        ],
                    ],
                ],
            ],
            3 => [
                'name' => 'grant_types',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '80',
                        ],
                    ],
                ],
            ],
            4 => [
                'name' => 'scope',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '2000',
                        ],
                    ],
                ],
            ],
            5 => [
                'name' => 'user_id',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '255',
                        ],
                    ],
                ],
            ],
        ],
        'plate\\V1\\Rest\\ApiTest\\Validator' => [
            0 => [
                'name' => 'name',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '255',
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'descr',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                    2 => [
                        'name' => \Zend\Filter\Encrypt::class,
                        'options' => [
                            'adapter' => \plate\Filter\Encrypt\BcryptFilter::class,
                        ],
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '255',
                        ],
                    ],
                ],
            ],
            2 => [
                'name' => 'digit',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\Digits::class,
                    ],
                ],
                'validators' => [],
            ],
        ],
        'plate\\V1\\Rest\\Status\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'message',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'timestamp',
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'user',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'plate\\V1\\Rest\\Motion\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
    'zf-apigility' => [
        'db-connected' => [
            'plate\\V1\\Rest\\ApiTest\\ApiTestResource' => [
                'adapter_name' => 'oauth2_users',
                'table_name' => 'api_test',
                'hydrator_name' => \Zend\Hydrator\ArraySerializable::class,
                'controller_service_name' => 'plate\\V1\\Rest\\ApiTest\\Controller',
                'entity_identifier_name' => 'id',
                'table_service' => 'plate\\V1\\Rest\\ApiTest\\ApiTestResource\\Table',
            ],
            'plate\\V1\\Rest\\OauthClients\\OauthClientsResource' => [
                'adapter_name' => 'oauth2_users',
                'table_name' => 'oauth_clients',
                'hydrator_name' => \Zend\Hydrator\ArraySerializable::class,
                'controller_service_name' => 'plate\\V1\\Rest\\OauthClients\\Controller',
                'entity_identifier_name' => 'id',
                'table_service' => 'plate\\V1\\Rest\\OauthClients\\OauthClientsResource\\Table',
            ],
        ],
    ],
];
