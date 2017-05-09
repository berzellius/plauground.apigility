<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'plate\\V1\\Rest\\Oauth_users_control\\Oauth_users_controlResource' => 'plate\\V1\\Rest\\Oauth_users_control\\Oauth_users_controlResourceFactory',
            'plate\\V1\\Rest\\Devices\\DevicesResource' => 'plate\\V1\\Rest\\Devices\\DevicesResourceFactory',
            'plate\\V1\\Rest\\Rooms\\RoomsResource' => 'plate\\V1\\Rest\\Rooms\\RoomsResourceFactory',
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
            'plate.rest.devices' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/devices[/:devices_id]',
                    'defaults' => array(
                        'controller' => 'plate\\V1\\Rest\\Devices\\Controller',
                    ),
                ),
            ),
            'plate.rest.floors' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/floors[/:floors_id]',
                    'defaults' => array(
                        'controller' => 'plate\\V1\\Rest\\Floors\\Controller',
                    ),
                ),
            ),
            'plate.rest.rooms' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/rooms[/:rooms_id]',
                    'defaults' => array(
                        'controller' => 'plate\\V1\\Rest\\Rooms\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            5 => 'plate.rest.oauth_users_control',
            0 => 'plate.rest.devices',
            6 => 'plate.rest.floors',
            7 => 'plate.rest.rooms',
            8 => 'plate.rest.rooms',
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
        'plate\\V1\\Rest\\Devices\\Controller' => array(
            'listener' => 'plate\\V1\\Rest\\Devices\\DevicesResource',
            'route_name' => 'plate.rest.devices',
            'route_identifier_name' => 'devices_id',
            'collection_name' => 'devices',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'DELETE',
                2 => 'PUT',
                3 => 'PATCH',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(
                0 => 'grp_id',
                1 => 'room_id',
            ),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'plate\\V1\\Rest\\Devices\\DevicesEntity',
            'collection_class' => 'plate\\V1\\Rest\\Devices\\DevicesCollection',
            'service_name' => 'devices',
        ),
        'plate\\V1\\Rest\\Floors\\Controller' => array(
            'listener' => 'plate\\V1\\Rest\\Floors\\FloorsResource',
            'route_name' => 'plate.rest.floors',
            'route_identifier_name' => 'floors_id',
            'collection_name' => 'floors',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'plate\\V1\\Rest\\Floors\\FloorsEntity',
            'collection_class' => 'plate\\V1\\Rest\\Floors\\FloorsCollection',
            'service_name' => 'floors',
        ),
        'plate\\V1\\Rest\\Rooms\\Controller' => array(
            'listener' => 'plate\\V1\\Rest\\Rooms\\RoomsResource',
            'route_name' => 'plate.rest.rooms',
            'route_identifier_name' => 'rooms_id',
            'collection_name' => 'rooms',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'floor_id',
            ),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'plate\\V1\\Rest\\Rooms\\RoomsEntity',
            'collection_class' => 'plate\\V1\\Rest\\Rooms\\RoomsCollection',
            'service_name' => 'rooms',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'plate\\V1\\Rest\\Oauth_users_control\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Devices\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Floors\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Rooms\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'plate\\V1\\Rest\\Oauth_users_control\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'plate\\V1\\Rest\\Devices\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'plate\\V1\\Rest\\Floors\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'plate\\V1\\Rest\\Rooms\\Controller' => array(
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
            'plate\\V1\\Rest\\Devices\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ),
            'plate\\V1\\Rest\\Floors\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ),
            'plate\\V1\\Rest\\Rooms\\Controller' => array(
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
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
            'plate\\V1\\Rest\\Devices\\DevicesEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.devices',
                'route_identifier_name' => 'devices_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'plate\\V1\\Rest\\Devices\\DevicesCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.devices',
                'route_identifier_name' => 'devices_id',
                'is_collection' => true,
            ),
            'plate\\V1\\Rest\\Floors\\FloorsEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.floors',
                'route_identifier_name' => 'floors_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'plate\\V1\\Rest\\Floors\\FloorsCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.floors',
                'route_identifier_name' => 'floors_id',
                'is_collection' => true,
            ),
            'plate\\V1\\Rest\\Rooms\\RoomsEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.rooms',
                'route_identifier_name' => 'rooms_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'plate\\V1\\Rest\\Rooms\\RoomsCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.rooms',
                'route_identifier_name' => 'rooms_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-content-validation' => array(
        'plate\\V1\\Rest\\Oauth_users_control\\Controller' => array(
            'input_filter' => 'plate\\V1\\Rest\\Oauth_users_control\\Validator',
        ),
        'plate\\V1\\Rest\\Floors\\Controller' => array(
            'input_filter' => 'plate\\V1\\Rest\\Floors\\Validator',
        ),
        'plate\\V1\\Rest\\Rooms\\Controller' => array(
            'input_filter' => 'plate\\V1\\Rest\\Rooms\\Validator',
        ),
        'plate\\V1\\Rest\\Devices\\Controller' => array(
            'input_filter' => 'plate\\V1\\Rest\\Devices\\Validator',
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
                'description' => 'MAC-адрес интерфейса',
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
                'description' => 'IP адрес устройства',
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
                'description' => 'Именование устройства (пр. "штора на кухне")',
            ),
            3 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Digits',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'group_id',
                'description' => 'Id группы устройств',
                'error_message' => 'Must be 0 or natural',
            ),
            4 => array(
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
                'description' => 'id комнаты',
            ),
            5 => array(
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
                'description' => 'Тип подключения',
            ),
            6 => array(
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
                'description' => 'Максимально допустимый ток в цепи питания двигателя в миллиамперах',
                'field_type' => 'Current, mA',
            ),
            7 => array(
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
            8 => array(
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
                'description' => 'команда, которая была обработана последней',
                'name' => 'last_command',
            ),
            9 => array(
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
                'description' => 'логический канал устройства',
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
            'plate\\V1\\Rest\\Floors\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
            'plate\\V1\\Rest\\Rooms\\Controller' => array(
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
            'plate\\V1\\Rest\\Devices\\Controller' => array(
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
        ),
    ),
    'zf-apigility' => array(
        'db-connected' => array(
            'plate\\V1\\Rest\\Floors\\FloorsResource' => array(
                'adapter_name' => 'oauth2_users',
                'table_name' => 'floors',
                'hydrator_name' => 'Zend\\Hydrator\\ArraySerializable',
                'controller_service_name' => 'plate\\V1\\Rest\\Floors\\Controller',
                'entity_identifier_name' => 'id',
                'table_service' => 'plate\\V1\\Rest\\Floors\\FloorsResource\\Table',
            ),
        ),
    ),
);
