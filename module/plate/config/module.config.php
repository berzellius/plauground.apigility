<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'plate\\Auth\\AuthUtils' => 'plate\\Auth\\AuthUtilFactory',
            'plate\\EntityServicesSupport\\ITableService' => 'plate\\EntityServicesSupport\\ITableServiceFactory',
            'plate\\V1\\Rest\\Oauth_users_control\\Oauth_users_controlResource' => 'plate\\V1\\Rest\\Oauth_users_control\\Oauth_users_controlResourceFactory',
            'plate\\V1\\Rest\\Application_clients\\Application_clientsResource' => 'plate\\V1\\Rest\\Application_clients\\Application_clientsResourceFactory',
            'plate\\V1\\Rest\\Entities\\EntitiesService' => 'plate\\EntityServicesSupport\\ServiceFactory',
            'plate\\V1\\Rest\\Entities\\EntitiesResource' => 'plate\\EntitySupport\\resource\\ResourceFactory',
            'plate\\V1\\Rest\\BasicHierarchy\\BasicHierarchyService' => 'plate\\EntityServicesSupport\\ServiceFactory',
            'plate\\V1\\Rest\\BasicHierarchy\\BasicHierarchyResource' => 'plate\\EntitySupport\\resource\\ResourceFactory',
            'plate\\V1\\Rest\\EntitiesUserContext\\EntitiesUserContextResource' => 'plate\\EntitySupport\\resource\\ResourceFactory',
            'plate\\V1\\Rest\\EntitiesUserContext\\EntitiesUserContextService' => 'plate\\EntityServicesSupport\\ServiceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'plate.rest.oauth_users_control' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/oauth_users_control[/:oauth_users_control_id]',
                    'defaults' => array(
                        'controller' => 'plate\\V1\\Rest\\Oauth_users_control\\Controller',
                    ),
                ),
            ),
            'plate.rest.application_clients' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/application_clients[/:application_clients_id]',
                    'defaults' => array(
                        'controller' => 'plate\\V1\\Rest\\Application_clients\\Controller',
                    ),
                ),
            ),
            'plate.rest.entities' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/entities[/:entities_id]',
                    'defaults' => array(
                        'controller' => 'plate\\V1\\Rest\\Entities\\Controller',
                    ),
                ),
            ),
            'plate.rest.basic-hierarchy' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/basic-hierarchy[/:basic_hierarchy_id]',
                    'defaults' => array(
                        'controller' => 'plate\\V1\\Rest\\BasicHierarchy\\Controller',
                    ),
                ),
            ),
            'plate.rpc.entities-rpc' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/entities_rpc',
                    'defaults' => array(
                        'controller' => 'plate\\V1\\Rpc\\EntitiesRpc\\Controller',
                        'action' => 'entitiesRpc',
                    ),
                ),
            ),
            'plate.rpc.favorites-rpc' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/favorites',
                    'defaults' => array(
                        'controller' => 'plate\\V1\\Rpc\\FavoritesRpc\\Controller',
                        'action' => 'favoritesRpc',
                    ),
                ),
            ),
            'plate.rest.entities-user-context' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/entities-user-context[/:entities_user_context_id]',
                    'defaults' => array(
                        'controller' => 'plate\\V1\\Rest\\EntitiesUserContext\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            5 => 'plate.rest.oauth_users_control',
            9 => 'plate.rest.application_clients',
            0 => 'plate.rest.entities',
            10 => 'plate.rest.basic-hierarchy',
            11 => 'plate.rpc.entities-rpc',
            12 => 'plate.rpc.favorites-rpc',
            13 => 'plate.rest.entities-user-context',
        ),
    ),
    'zf-rest' => array(
        'plate\\V1\\Rest\\Oauth_users_control\\Controller' => array(
            'listener' => 'plate\\V1\\Rest\\Oauth_users_control\\Oauth_users_controlResource',
            'route_name' => 'plate.rest.oauth_users_control',
            'route_identifier_name' => 'oauth_users_control_id',
            'collection_name' => 'oauth_users_control',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(
                0 => 'scope',
            ),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'plate\\V1\\Rest\\Oauth_users_control\\Oauth_users_controlEntity',
            'collection_class' => 'plate\\V1\\Rest\\Oauth_users_control\\Oauth_users_controlCollection',
            'service_name' => 'oauth_users_control',
        ),
        'plate\\V1\\Rest\\Application_clients\\Controller' => array(
            'listener' => 'plate\\V1\\Rest\\Application_clients\\Application_clientsResource',
            'route_name' => 'plate.rest.application_clients',
            'route_identifier_name' => 'application_clients_id',
            'collection_name' => 'application_clients',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'plate\\V1\\Rest\\Application_clients\\Application_clientsEntity',
            'collection_class' => 'plate\\V1\\Rest\\Application_clients\\Application_clientsCollection',
            'service_name' => 'application_clients',
        ),
        'plate\\V1\\Rest\\Entities\\Controller' => array(
            'listener' => 'plate\\V1\\Rest\\Entities\\EntitiesResource',
            'route_name' => 'plate.rest.entities',
            'route_identifier_name' => 'entities_id',
            'collection_name' => 'entities_hierarchy',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(
                0 => 'root_entity_id',
            ),
            'page_size' => 25,
            'page_size_param' => 'ps',
            'entity_class' => 'plate\\V1\\Rest\\Entities\\EntitiesEntity',
            'collection_class' => 'plate\\V1\\Rest\\Entities\\EntitiesCollection',
            'service_name' => 'entities',
            'dao_service' => 'plate\\V1\\Rest\\Entities\\EntitiesService',
            'referenceTables' => array(
                0 => array(
                    'referenceConfig' => 'entities',
                    'idField' => 'id',
                    'foreignColumn' => 'ent_id',
                    'entityClass' => 'plate\\V1\\Rest\\Entities\\EntitiesHierarchy',
                ),
                1 => array(
                    'referenceConfig' => 'types',
                    'idField' => 'type_id',
                    'foreignColumn' => 'type',
                    'foreignTable' => 'entities',
                    'entityClass' => 'plate\\V1\\Rest\\BasicHierarchy\\HierarchyTypes',
                ),
            ),
        ),
        'plate\\V1\\Rest\\BasicHierarchy\\Controller' => array(
            'listener' => 'plate\\V1\\Rest\\BasicHierarchy\\BasicHierarchyResource',
            'route_name' => 'plate.rest.basic-hierarchy',
            'route_identifier_name' => 'basic_hierarchy_id',
            'collection_name' => 'basic_hierarchy',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(
                0 => 'root_entity_id',
                1 => 'level_depth',
                2 => 'type_ids_list',
            ),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'plate\\V1\\Rest\\BasicHierarchy\\BasicHierarchyEntity',
            'collection_class' => 'plate\\V1\\Rest\\BasicHierarchy\\BasicHierarchyCollection',
            'dao_service' => 'plate\\V1\\Rest\\BasicHierarchy\\BasicHierarchyService',
            'service_name' => 'basicHierarchy',
            'referenceTables' => array(
                0 => array(
                    'referenceConfig' => 'types',
                    'idField' => 'type_id',
                    'foreignColumn' => 'type',
                    'entityClass' => 'plate\\V1\\Rest\\BasicHierarchy\\HierarchyTypes',
                ),
            ),
        ),
        'plate\\V1\\Rest\\EntitiesUserContext\\Controller' => array(
            'listener' => 'plate\\V1\\Rest\\EntitiesUserContext\\EntitiesUserContextResource',
            'route_name' => 'plate.rest.entities-user-context',
            'route_identifier_name' => 'entities_user_context_id',
            'collection_name' => 'entities_user_context',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'plate\\V1\\Rest\\EntitiesUserContext\\EntitiesUserContextEntity',
            'collection_class' => 'plate\\V1\\Rest\\EntitiesUserContext\\EntitiesUserContextCollection',
            'service_name' => 'EntitiesUserContext',
            'dao_service' => 'plate\\V1\\Rest\\EntitiesUserContext\\EntitiesUserContextService',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'plate\\V1\\Rest\\Oauth_users_control\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Application_clients\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Entities\\Controller' => 'JsonAlt',
            'plate\\V1\\Rest\\BasicHierarchy\\Controller' => 'JsonAlt',
            'plate\\V1\\Rpc\\EntitiesRpc\\Controller' => 'JsonAlt',
            'plate\\V1\\Rpc\\FavoritesRpc\\Controller' => 'JsonAlt',
            'plate\\V1\\Rest\\EntitiesUserContext\\Controller' => 'JsonAlt',
        ),
        'accept_whitelist' => array(
            'plate\\V1\\Rest\\Oauth_users_control\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'plate\\V1\\Rest\\Application_clients\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'plate\\V1\\Rest\\Entities\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'plate\\V1\\Rest\\BasicHierarchy\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'plate\\V1\\Rpc\\EntitiesRpc\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'plate\\V1\\Rpc\\FavoritesRpc\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'plate\\V1\\Rest\\EntitiesUserContext\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'plate\\V1\\Rest\\Oauth_users_control\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ),
            'plate\\V1\\Rest\\Application_clients\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ),
            'plate\\V1\\Rest\\Entities\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ),
            'plate\\V1\\Rest\\BasicHierarchy\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ),
            'plate\\V1\\Rpc\\EntitiesRpc\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ),
            'plate\\V1\\Rpc\\FavoritesRpc\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ),
            'plate\\V1\\Rest\\EntitiesUserContext\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ),
        ),
        'selectors' => array(
            'JsonAlt' => array(
                'plate\\Json\\JsonModelAlt' => array(
                    0 => 'application/json',
                    1 => 'application/*+json',
                ),
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'plate\\V1\\EntitySupport\\Collection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.status',
                'route_identifier_name' => 'status_id',
                'hydrator' => 'Zend\\Hydrator\\ObjectProperty',
            ),
            'plate\\V1\\Rest\\Oauth_users_control\\Oauth_users_controlEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.oauth_users_control',
                'route_identifier_name' => 'oauth_users_control_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'plate\\V1\\Rest\\Oauth_users_control\\Oauth_users_controlCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.oauth_users_control',
                'route_identifier_name' => 'oauth_users_control_id',
                'is_collection' => true,
            ),
            'plate\\V1\\Rest\\Application_clients\\Application_clientsEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.application_clients',
                'route_identifier_name' => 'application_clients_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'plate\\V1\\Rest\\Application_clients\\Application_clientsCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.application_clients',
                'route_identifier_name' => 'application_clients_id',
                'is_collection' => true,
            ),
            'plate\\V1\\Rest\\Entities\\EntitiesEntity' => array(
                'entity_identifier_name' => 'ns_id',
                'route_name' => 'plate.rest.entities',
                'route_identifier_name' => 'entities_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'plate\\V1\\Rest\\Entities\\EntitiesCollection' => array(
                'entity_identifier_name' => 'ns_id',
                'route_name' => 'plate.rest.entities',
                'route_identifier_name' => 'entities_id',
                'is_collection' => true,
            ),
            'plate\\V1\\Rest\\BasicHierarchy\\BasicHierarchyEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.basic-hierarchy',
                'route_identifier_name' => 'basic_hierarchy_id',
                'hydrator' => 'plate\\Hydrator\\CustomHydrator',
            ),
            'plate\\V1\\Rest\\BasicHierarchy\\BasicHierarchyCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.basic-hierarchy',
                'route_identifier_name' => 'basic_hierarchy_id',
                'is_collection' => true,
            ),
            'plate\\V1\\Rest\\EntitiesUserContext\\EntitiesUserContextEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.entities-user-context',
                'route_identifier_name' => 'entities_user_context_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'plate\\V1\\Rest\\EntitiesUserContext\\EntitiesUserContextCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.entities-user-context',
                'route_identifier_name' => 'entities_user_context_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-content-validation' => array(
        'plate\\V1\\Rest\\Oauth_users_control\\Controller' => array(
            'input_filter' => 'plate\\V1\\Rest\\Oauth_users_control\\Validator',
        ),
        'plate\\V1\\Rest\\Application_clients\\Controller' => array(
            'input_filter' => 'plate\\V1\\Rest\\Application_clients\\Validator',
        ),
        'plate\\V1\\Rest\\Entities\\Controller' => array(
            'input_filter' => 'plate\\V1\\Rest\\Entities\\Validator',
        ),
        'plate\\V1\\Rpc\\EntitiesRpc\\Controller' => array(
            'input_filter' => 'plate\\V1\\Rpc\\EntitiesRpc\\Validator',
            'GET' => 'plate\\V1\\Rpc\\EntitiesRpc\\Validator',
        ),
        'plate\\V1\\Rpc\\FavoritesRpc\\Controller' => array(
            'input_filter' => 'plate\\V1\\Rpc\\FavoritesRpc\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'plate\\V1\\Rest\\Motion\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(),
                'name' => 'status',
                'description' => 'status of command',
            ),
        ),
        'plate\\V1\\Rest\\OauthClients\\Validator' => array(
            0 => array(
                'name' => 'client_id',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => '80',
                        ),
                    ),
                ),
            ),
            1 => array(
                'name' => 'client_secret',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => '80',
                        ),
                    ),
                ),
            ),
            2 => array(
                'name' => 'redirect_uri',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => '2000',
                        ),
                    ),
                ),
            ),
            3 => array(
                'name' => 'grant_types',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => '80',
                        ),
                    ),
                ),
            ),
            4 => array(
                'name' => 'scope',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => '2000',
                        ),
                    ),
                ),
            ),
            5 => array(
                'name' => 'user_id',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => '255',
                        ),
                    ),
                ),
            ),
        ),
        'plate\\V1\\Rest\\ApiTest\\Validator' => array(
            0 => array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => '255',
                        ),
                    ),
                ),
            ),
            1 => array(
                'name' => 'descr',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                    2 => array(
                        'name' => 'Zend\\Filter\\Encrypt',
                        'options' => array(
                            'adapter' => 'plate\\Filter\\Encrypt\\BcryptFilter',
                        ),
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => '255',
                        ),
                    ),
                ),
            ),
            2 => array(
                'name' => 'digit',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\Digits',
                    ),
                ),
                'validators' => array(),
            ),
        ),
        'plate\\V1\\Rest\\Status\\Validator' => array(
            0 => array(
                'name' => 'timestamp',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\Digits',
                    ),
                ),
                'validators' => array(),
            ),
            1 => array(
                'name' => 'user',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                    2 => array(
                        'name' => 'Zend\\Filter\\Encrypt',
                        'options' => array(
                            'adapter' => 'plate\\Filter\\Encrypt\\BcryptFilter',
                        ),
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => '255',
                        ),
                    ),
                ),
            ),
        ),
        'plate\\V1\\Rest\\Oauth_users_control\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => '4',
                            'max' => '30',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringToLower',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                    2 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'client_id',
                'field_type' => '',
            ),
            1 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                    2 => array(
                        'name' => 'Zend\\Filter\\Encrypt',
                        'options' => array(
                            'adapter' => 'plate\\Filter\\Encrypt\\BcryptFilter',
                        ),
                    ),
                ),
                'name' => 'client_secret',
                'description' => 'password',
                'continue_if_empty' => false,
                'error_message' => 'Set',
            ),
            2 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\UriNormalize',
                        'options' => array(),
                    ),
                ),
                'name' => 'redirect_uri',
            ),
        ),
        'plate\\V1\\Rest\\DevicesAcl\\Validator' => array(
            0 => array(
                'name' => 'grp_id',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\Digits',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbNoRecordExists',
                        'options' => array(
                            'adapter' => 'oauth2_users',
                            'table' => 'devices_acl',
                            'field' => 'grp_id',
                        ),
                    ),
                ),
            ),
            1 => array(
                'name' => 'client_id',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbNoRecordExists',
                        'options' => array(
                            'adapter' => 'oauth2_users',
                            'table' => 'devices_acl',
                            'field' => 'client_id',
                        ),
                    ),
                    1 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbNoRecordExists',
                        'options' => array(
                            'adapter' => 'oauth2_users',
                            'table' => 'devices_acl',
                            'field' => 'client_id',
                        ),
                    ),
                    2 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => '255',
                        ),
                    ),
                ),
            ),
            2 => array(
                'name' => 'device_id',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\Digits',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbNoRecordExists',
                        'options' => array(
                            'adapter' => 'oauth2_users',
                            'table' => 'devices_acl',
                            'field' => 'device_id',
                        ),
                    ),
                ),
            ),
        ),
        'plate\\V1\\Rest\\Floors\\Validator' => array(
            0 => array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => '255',
                        ),
                    ),
                ),
                'description' => 'Не может быть null',
            ),
        ),
        'plate\\V1\\Rest\\Rooms\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'room_id',
                'field_type' => '',
                'description' => 'Id комнаты. Не может быть null.',
            ),
            1 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'name',
                'description' => 'Имя комнаты. Не может быть null',
            ),
        ),
        'plate\\V1\\Rest\\Devices\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
                            'message' => 'Bad mac-address format, must satisfy /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'mac',
                'description' => 'MAC-адрес интерфейса. Не может быть null',
                'field_type' => '',
                'error_message' => 'Wrong mac-address!',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Ip',
                        'options' => array(
                            'message' => 'must be valid ip',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'ip',
                'description' => 'IP адрес устройства. Не может быть null.',
                'error_message' => 'Wrong ip address!',
            ),
            2 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'description',
                'description' => 'Именование устройства (пр. "штора на кухне"). Не может быть null.',
            ),
            3 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => array(
                            'adapter' => 'oauth2_users',
                            'table' => 'rooms',
                            'field' => 'id',
                            'message' => 'must be rooms.id record',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'room_id',
                'description' => 'id комнаты. не может быть null',
            ),
            4 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\ToInt',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'type',
                'description' => 'Тип подключения. не может быть null',
            ),
            5 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\ToInt',
                        'options' => array(),
                    ),
                ),
                'name' => 'max_amp',
                'description' => 'Максимально допустимый ток в цепи питания двигателя в миллиамперах. Не может быть null',
                'field_type' => 'Current, mA',
            ),
            6 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'connection_type',
            ),
            7 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '100',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'description' => 'команда, которая была обработана последней. может быть NULL, если команд еще не поступало.',
                'name' => 'last_command',
            ),
            8 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Digits',
                        'options' => array(),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\ToInt',
                        'options' => array(),
                    ),
                ),
                'name' => 'channel',
                'description' => 'логический канал устройства. не может быть null',
            ),
        ),
        'plate\\V1\\Rest\\Application_clients\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
                            'message' => 'wrong mac address, must satisfy /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'mac',
                'description' => 'MAC адрес клиента. Не может быть null',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Ip',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'ip',
                'description' => 'IP адрес клиента. Не может быть null',
            ),
            2 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '255',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'description',
                'description' => 'Отображаемое описание клиента. Не может быть null',
            ),
            3 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => '3',
                            'max' => '255',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'hostname',
                'description' => 'Hostname (имя устройства). Не  может быть null',
            ),
        ),
        'plate\\V1\\Rest\\Scheduled_tasks\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '/^(ACTIVE|PAUSED|STOPPED)$/',
                            'message' => 'wrong state value, must be one of ACTIVE, PAUSED, STOPPED',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringToUpper',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'state',
                'description' => 'Статус задачи - ACTIVE/PAUSED/STOPPED/ENDED. Не  может быть null',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '/^(DAILY|WEEKLY|CUSTOM)$/',
                            'message' => 'period_type must be \'WEEKLY\', \'DAILY\' or \'CUSTOM\'',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringToUpper',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'period_type',
                'description' => 'тип периода - DAILY, WEEKLY, CUSTOM. Не  может быть null',
            ),
            2 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'command',
                'description' => 'Команда, которая должна быть выполнена. Не  может быть null',
            ),
            3 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '255',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'name',
                'description' => 'имя задачи по расписанию. Не  может быть null',
            ),
            4 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '(^(([0-9]+)(\\s)*(,(\\s)*|$)))',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'devices_ids',
                'description' => 'идентификаторы устройств, которые нужно добавить к назначенному заданию. Не  может быть null; если к заданию не нужно добавлять устройства, то нужно передать только поле groups_ids. Хотя бы одно из полей - devices_ids, groups_ids - должно быть заполнено.',
                'continue_if_empty' => true,
                'allow_empty' => true,
            ),
            5 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '(^(([0-9a-zA-Z]+)(\\s)*(,(\\s)*|$)))',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'stamps',
                'allow_empty' => true,
                'continue_if_empty' => true,
                'description' => 'Специальные пометки. Тип пометок зависит от значения period_type. Если period_type=WEEKLY, то это список дней недели, по которым должно выполняться задание, в верхнем регистре на английском языке через запятую. Не  может быть null',
            ),
            6 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '(^(([0-9]+)(\\s)*(,(\\s)*|$)))',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'groups_ids',
                'description' => 'Идентификаторы групп, которые нужно добавить к заданию. Не  может быть null; если к заданию не нужно добавлять групп, нужно передать только devices_ids. Хотя бы одно из полей - devides_ids, groups_ids - должно быть заполнено.',
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            7 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '(([0-1][0-9]|20|21|22|23):[0-5][0-9])',
                            'message' => 'укажите время в формате hh:mm (hh от 00 до 23)',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'time',
                'description' => 'Общее для всего расписания время срабатывания. Не  может быть null',
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
        ),
        'plate\\V1\\Rest\\Scheduled_tasks_timetable\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => array(
                            'adapter' => 'oauth2_users',
                            'field' => 'id',
                            'message' => 'there must be scheduling_task satisfying scheduling_task_id',
                            'table' => 'scheduled_tasks',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'scheduling_task_id',
                'description' => 'id задачи по расписанию',
            ),
            1 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                    2 => array(
                        'name' => 'Zend\\Filter\\DateTimeFormatter',
                        'options' => array(
                            'format' => 'YYYY-mm-dd HH:ii:ss',
                        ),
                    ),
                ),
                'name' => 'begin_dtm',
                'description' => 'unix timestamp начала работы',
            ),
            2 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\ToInt',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'repeat_period',
                'allow_empty' => true,
                'continue_if_empty' => true,
                'field_type' => '',
            ),
            3 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '/^(ACTIVE|PAUSED)$/',
                            'message' => 'state must be ACTIVE or PAUSED',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'state',
                'description' => 'состояние - запущен/остановлен - ACTIVE, PAUSED',
            ),
            4 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                    2 => array(
                        'name' => 'Zend\\Filter\\DateTimeFormatter',
                        'options' => array(
                            'format' => 'YYYY-dd-mm HH:ii:ss',
                        ),
                    ),
                ),
                'name' => 'next_dtm',
                'description' => 'unix timestamp следующего запуска',
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            5 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '255',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'special_stamp',
                'description' => 'Специальная отметка. Допускается любая строка до 255 символов длиной. Используется внешними приложениями для организации календарей (например, если предусмотрено расписание по дням недели, то здесь могут быть значения MORNING, SATURDAY и т.д.). Значения этого поля не влияют на работу серверной части. В пределах одного scheduled_tasks_id значения поля должны быть уникальны',
            ),
            6 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '255',
                            'min' => '2',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'name',
                'description' => 'Имя для отображения в ui',
            ),
        ),
        'plate\\V1\\Rest\\Groups\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => '1',
                            'max' => '255',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'name',
                'description' => 'Имя группы. Не  может быть null',
            ),
            1 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '100',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'last_command',
                'description' => 'команда, которая была обработана последней. может быть null, если команд еще не поступало.',
                'allow_empty' => false,
            ),
        ),
        'plate\\V1\\Rest\\Dev2grp\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => array(
                            'adapter' => 'oauth2_users',
                            'table' => 'devices',
                            'field' => 'id',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'device_id',
                'description' => 'Id устройства',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => array(
                            'adapter' => 'oauth2_users',
                            'table' => 'groups',
                            'field' => 'id',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                ),
                'name' => 'group_id',
                'description' => 'Id группы',
            ),
        ),
        'plate\\V1\\Rest\\Favorites\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => array(
                            'adapter' => 'oauth2_users',
                            'table' => 'devices',
                            'field' => 'id',
                            'message' => 'Must exists device with specified id',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'id_device',
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            1 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => array(
                            'adapter' => 'oauth2_users',
                            'table' => 'groups',
                            'field' => 'id',
                            'message' => 'Must exists group with specified id',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'id_group',
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            2 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '255',
                        ),
                    ),
                    1 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => array(
                            'adapter' => 'oauth2_users',
                            'table' => 'oauth_clients',
                            'field' => 'client_id',
                            'message' => 'User must exists!',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'user',
            ),
            3 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '/^(DEVICE|GROUP|SCHEDULED)$/',
                            'message' => 'entity type must be DEVICE, GROUP or SCHEDULED',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'entity_type',
                'allow_empty' => false,
                'description' => 'Тип сущности, добавляемой в Избранное. Устройство, группа или назначенное задание.',
            ),
            4 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => array(
                            'adapter' => 'oauth2_users',
                            'table' => 'scheduled_tasks',
                            'field' => 'id',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'id_scheduled_task',
                'continue_if_empty' => true,
                'allow_empty' => true,
            ),
        ),
        'plate\\V1\\Rest\\Entities\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '255',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripNewlines',
                        'options' => array(),
                    ),
                ),
                'name' => 'name',
                'description' => '',
                'field_type' => 'String',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '100',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripNewlines',
                        'options' => array(),
                    ),
                ),
                'name' => 'last_command',
                'field_type' => 'String',
            ),
        ),
        'plate\\V1\\Rpc\\EntitiesRpc\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '/^((|,)[\\d]+)+$/',
                            'breakchainonfailure' => true,
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringToLower',
                        'options' => array(),
                    ),
                ),
                'name' => 'types',
            ),
            1 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '/^[\\d]+$/',
                            'breakchainonfailure' => true,
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\ToInt',
                        'options' => array(),
                    ),
                ),
                'name' => 'level_depth',
            ),
            2 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'breakchainonfailure' => true,
                            'pattern' => '/^[0-9]+$/',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\ToInt',
                        'options' => array(),
                    ),
                ),
                'name' => 'ent_id',
            ),
            3 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'breakchainonfailure' => true,
                            'pattern' => '/^[0-9]+$/',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\ToInt',
                        'options' => array(),
                    ),
                ),
                'name' => 'ns_id',
            ),
            4 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '/^[0-9]+$/',
                            'breakchainonfailure' => true,
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\ToInt',
                        'options' => array(),
                    ),
                ),
                'name' => 'level',
                'field_type' => '',
            ),
            5 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'breakchainonfailure' => true,
                            'pattern' => '/^[0|1]$/',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\ToInt',
                        'options' => array(),
                    ),
                ),
                'name' => 'favorite',
                'description' => 'вывод только избранного',
                'field_type' => 'Integer',
            ),
        ),
        'plate\\V1\\Rpc\\FavoritesRpc\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'breakchainonfailure' => true,
                            'pattern' => '/^[\\d]+$/',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\ToInt',
                        'options' => array(),
                    ),
                ),
                'name' => 'entity_id',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'breakchainonfailure' => true,
                            'pattern' => '/^(like|dislike)$/',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'do',
                'description' => 'what to do? like/dislike',
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'plate\\V1\\Rest\\Oauth_users_control\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'plate\\V1\\Rest\\Application_clients\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'plate\\V1\\Rest\\Entities\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'plate\\V1\\Rest\\BasicHierarchy\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'plate\\V1\\Rpc\\EntitiesRpc\\Controller' => array(
                'actions' => array(
                    'EntitiesRpc' => array(
                        'GET' => true,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ),
                ),
            ),
            'plate\\V1\\Rpc\\FavoritesRpc\\Controller' => array(
                'actions' => array(
                    'FavoritesRpc' => array(
                        'GET' => true,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ),
                ),
            ),
        ),
    ),
    'zf-apigility' => array(
        'db-connected' => array(),
    ),
    'controllers' => array(
        'factories' => array(
            'plate\\V1\\Rpc\\EntitiesRpc\\Controller' => 'plate\\V1\\Rpc\\EntitiesRpc\\EntitiesRpcControllerFactory',
            'plate\\V1\\Rpc\\FavoritesRpc\\Controller' => 'plate\\V1\\Rpc\\FavoritesRpc\\FavoritesRpcControllerFactory',
        ),
    ),
    'zf-rpc' => array(
        'plate\\V1\\Rpc\\EntitiesRpc\\Controller' => array(
            'service_name' => 'entitiesRpc',
            'http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'route_name' => 'plate.rpc.entities-rpc',
        ),
        'plate\\V1\\Rpc\\FavoritesRpc\\Controller' => array(
            'service_name' => 'FavoritesRpc',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'plate.rpc.favorites-rpc',
        ),
    ),
);
