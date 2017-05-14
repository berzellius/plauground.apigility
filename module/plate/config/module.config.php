<?php
return [
    'service_manager' => [
        'factories' => [
            \plate\V1\Rest\Oauth_users_control\Oauth_users_controlResource::class => \plate\V1\Rest\Oauth_users_control\Oauth_users_controlResourceFactory::class,
            \plate\V1\Rest\Devices\DevicesResource::class => \plate\V1\Rest\Devices\DevicesResourceFactory::class,
            \plate\V1\Rest\Rooms\RoomsResource::class => \plate\V1\Rest\Rooms\RoomsResourceFactory::class,
            \plate\V1\Rest\Application_clients\Application_clientsResource::class => \plate\V1\Rest\Application_clients\Application_clientsResourceFactory::class,
            \plate\V1\Rest\Scheduled_tasks\Scheduled_tasksResource::class => \plate\V1\Rest\Scheduled_tasks\Scheduled_tasksResourceFactory::class,
            \plate\V1\Rest\Scheduled_tasks_timetable\Scheduled_tasks_timetableResource::class => \plate\V1\Rest\Scheduled_tasks_timetable\Scheduled_tasks_timetableResourceFactory::class,
            \plate\V1\Rest\Dev2grp\Dev2grpResource::class => \plate\V1\Rest\Dev2grp\Dev2grpResourceFactory::class,
            \plate\V1\Rest\Groups\GroupsResource::class => \plate\V1\Rest\Groups\GroupsResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'plate.rest.oauth_users_control' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/oauth_users_control[/:oauth_users_control_id]',
                    'defaults' => [
                        'controller' => 'plate\\V1\\Rest\\Oauth_users_control\\Controller',
                    ],
                ],
            ],
            'plate.rest.devices' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/devices[/:devices_id]',
                    'defaults' => [
                        'controller' => 'plate\\V1\\Rest\\Devices\\Controller',
                    ],
                ],
            ],
            'plate.rest.floors' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/floors[/:floors_id]',
                    'defaults' => [
                        'controller' => 'plate\\V1\\Rest\\Floors\\Controller',
                    ],
                ],
            ],
            'plate.rest.rooms' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/rooms[/:rooms_id]',
                    'defaults' => [
                        'controller' => 'plate\\V1\\Rest\\Rooms\\Controller',
                    ],
                ],
            ],
            'plate.rest.application_clients' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/application_clients[/:application_clients_id]',
                    'defaults' => [
                        'controller' => 'plate\\V1\\Rest\\Application_clients\\Controller',
                    ],
                ],
            ],
            'plate.rest.scheduled_tasks' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/scheduled_tasks[/:scheduled_tasks_id]',
                    'defaults' => [
                        'controller' => 'plate\\V1\\Rest\\Scheduled_tasks\\Controller',
                    ],
                ],
            ],
            'plate.rest.scheduled_tasks_timetable' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/scheduled_tasks_timetable[/:scheduled_tasks_timetable_id]',
                    'defaults' => [
                        'controller' => 'plate\\V1\\Rest\\Scheduled_tasks_timetable\\Controller',
                    ],
                ],
            ],
            'plate.rest.dev2grp' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/dev2grp[/:dev2grp_id]',
                    'defaults' => [
                        'controller' => 'plate\\V1\\Rest\\Dev2grp\\Controller',
                    ],
                ],
            ],
            'plate.rest.groups' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/groups[/:groups_id]',
                    'defaults' => [
                        'controller' => 'plate\\V1\\Rest\\Groups\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            5 => 'plate.rest.oauth_users_control',
            0 => 'plate.rest.devices',
            6 => 'plate.rest.floors',
            7 => 'plate.rest.rooms',
            8 => 'plate.rest.rooms',
            9 => 'plate.rest.application_clients',
            10 => 'plate.rest.scheduled_tasks',
            11 => 'plate.rest.scheduled_tasks_timetable',
            12 => 'plate.rest.dev2grp',
            13 => 'plate.rest.groups',
        ],
    ],
    'zf-rest' => [
        'plate\\V1\\Rest\\Oauth_users_control\\Controller' => [
            'listener' => \plate\V1\Rest\Oauth_users_control\Oauth_users_controlResource::class,
            'route_name' => 'plate.rest.oauth_users_control',
            'route_identifier_name' => 'oauth_users_control_id',
            'collection_name' => 'oauth_users_control',
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
            'collection_query_whitelist' => [
                0 => 'scope',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \plate\V1\Rest\Oauth_users_control\Oauth_users_controlEntity::class,
            'collection_class' => \plate\V1\Rest\Oauth_users_control\Oauth_users_controlCollection::class,
            'service_name' => 'oauth_users_control',
        ],
        'plate\\V1\\Rest\\Devices\\Controller' => [
            'listener' => \plate\V1\Rest\Devices\DevicesResource::class,
            'route_name' => 'plate.rest.devices',
            'route_identifier_name' => 'devices_id',
            'collection_name' => 'devices',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'DELETE',
                2 => 'PUT',
                3 => 'PATCH',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'grp_id',
                1 => 'room_id',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \plate\V1\Rest\Devices\DevicesEntity::class,
            'collection_class' => \plate\V1\Rest\Devices\DevicesCollection::class,
            'service_name' => 'devices',
        ],
        'plate\\V1\\Rest\\Floors\\Controller' => [
            'listener' => 'plate\\V1\\Rest\\Floors\\FloorsResource',
            'route_name' => 'plate.rest.floors',
            'route_identifier_name' => 'floors_id',
            'collection_name' => 'floors',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \plate\V1\Rest\Floors\FloorsEntity::class,
            'collection_class' => \plate\V1\Rest\Floors\FloorsCollection::class,
            'service_name' => 'floors',
        ],
        'plate\\V1\\Rest\\Rooms\\Controller' => [
            'listener' => \plate\V1\Rest\Rooms\RoomsResource::class,
            'route_name' => 'plate.rest.rooms',
            'route_identifier_name' => 'rooms_id',
            'collection_name' => 'rooms',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [
                0 => 'floor_id',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \plate\V1\Rest\Rooms\RoomsEntity::class,
            'collection_class' => \plate\V1\Rest\Rooms\RoomsCollection::class,
            'service_name' => 'rooms',
        ],
        'plate\\V1\\Rest\\Application_clients\\Controller' => [
            'listener' => \plate\V1\Rest\Application_clients\Application_clientsResource::class,
            'route_name' => 'plate.rest.application_clients',
            'route_identifier_name' => 'application_clients_id',
            'collection_name' => 'application_clients',
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
            'entity_class' => \plate\V1\Rest\Application_clients\Application_clientsEntity::class,
            'collection_class' => \plate\V1\Rest\Application_clients\Application_clientsCollection::class,
            'service_name' => 'application_clients',
        ],
        'plate\\V1\\Rest\\Scheduled_tasks\\Controller' => [
            'listener' => \plate\V1\Rest\Scheduled_tasks\Scheduled_tasksResource::class,
            'route_name' => 'plate.rest.scheduled_tasks',
            'route_identifier_name' => 'scheduled_tasks_id',
            'collection_name' => 'scheduled_tasks',
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
            'entity_class' => \plate\V1\Rest\Scheduled_tasks\Scheduled_tasksEntity::class,
            'collection_class' => \plate\V1\Rest\Scheduled_tasks\Scheduled_tasksCollection::class,
            'service_name' => 'scheduled_tasks',
        ],
        'plate\\V1\\Rest\\Scheduled_tasks_timetable\\Controller' => [
            'listener' => \plate\V1\Rest\Scheduled_tasks_timetable\Scheduled_tasks_timetableResource::class,
            'route_name' => 'plate.rest.scheduled_tasks_timetable',
            'route_identifier_name' => 'scheduled_tasks_timetable_id',
            'collection_name' => 'scheduled_tasks_timetable',
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
            'collection_query_whitelist' => [
                0 => 'scheduling_task_id',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \plate\V1\Rest\Scheduled_tasks_timetable\Scheduled_tasks_timetableEntity::class,
            'collection_class' => \plate\V1\Rest\Scheduled_tasks_timetable\Scheduled_tasks_timetableCollection::class,
            'service_name' => 'scheduled_tasks_timetable',
        ],
        'plate\\V1\\Rest\\Dev2grp\\Controller' => [
            'listener' => \plate\V1\Rest\Dev2grp\Dev2grpResource::class,
            'route_name' => 'plate.rest.dev2grp',
            'route_identifier_name' => 'dev2grp_id',
            'collection_name' => 'dev2grp',
            'entity_http_methods' => [
                0 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \plate\V1\Rest\Dev2grp\Dev2grpEntity::class,
            'collection_class' => \plate\V1\Rest\Dev2grp\Dev2grpCollection::class,
            'service_name' => 'dev2grp',
        ],
        'plate\\V1\\Rest\\Groups\\Controller' => [
            'listener' => \plate\V1\Rest\Groups\GroupsResource::class,
            'route_name' => 'plate.rest.groups',
            'route_identifier_name' => 'groups_id',
            'collection_name' => 'groups',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'room_id',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \plate\V1\Rest\Groups\GroupsEntity::class,
            'collection_class' => \plate\V1\Rest\Groups\GroupsCollection::class,
            'service_name' => 'groups',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'plate\\V1\\Rest\\Oauth_users_control\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Devices\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Floors\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Rooms\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Application_clients\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Scheduled_tasks\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Scheduled_tasks_timetable\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Dev2grp\\Controller' => 'HalJson',
            'plate\\V1\\Rest\\Groups\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'plate\\V1\\Rest\\Oauth_users_control\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'plate\\V1\\Rest\\Devices\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'plate\\V1\\Rest\\Floors\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'plate\\V1\\Rest\\Rooms\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'plate\\V1\\Rest\\Application_clients\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'plate\\V1\\Rest\\Scheduled_tasks\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'plate\\V1\\Rest\\Scheduled_tasks_timetable\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'plate\\V1\\Rest\\Dev2grp\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'plate\\V1\\Rest\\Groups\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'plate\\V1\\Rest\\Oauth_users_control\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ],
            'plate\\V1\\Rest\\Devices\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ],
            'plate\\V1\\Rest\\Floors\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ],
            'plate\\V1\\Rest\\Rooms\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ],
            'plate\\V1\\Rest\\Application_clients\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ],
            'plate\\V1\\Rest\\Scheduled_tasks\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ],
            'plate\\V1\\Rest\\Scheduled_tasks_timetable\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ],
            'plate\\V1\\Rest\\Dev2grp\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ],
            'plate\\V1\\Rest\\Groups\\Controller' => [
                0 => 'application/vnd.plate.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            'plate\\V1\\EntitySupport\\Collection' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.status',
                'route_identifier_name' => 'status_id',
                'hydrator' => \Zend\Hydrator\ObjectProperty::class,
            ],
            \plate\V1\Rest\Oauth_users_control\Oauth_users_controlEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.oauth_users_control',
                'route_identifier_name' => 'oauth_users_control_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \plate\V1\Rest\Oauth_users_control\Oauth_users_controlCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.oauth_users_control',
                'route_identifier_name' => 'oauth_users_control_id',
                'is_collection' => true,
            ],
            \plate\V1\Rest\Devices\DevicesEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.devices',
                'route_identifier_name' => 'devices_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \plate\V1\Rest\Devices\DevicesCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.devices',
                'route_identifier_name' => 'devices_id',
                'is_collection' => true,
            ],
            \plate\V1\Rest\Floors\FloorsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.floors',
                'route_identifier_name' => 'floors_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \plate\V1\Rest\Floors\FloorsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.floors',
                'route_identifier_name' => 'floors_id',
                'is_collection' => true,
            ],
            \plate\V1\Rest\Rooms\RoomsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.rooms',
                'route_identifier_name' => 'rooms_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \plate\V1\Rest\Rooms\RoomsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.rooms',
                'route_identifier_name' => 'rooms_id',
                'is_collection' => true,
            ],
            \plate\V1\Rest\Application_clients\Application_clientsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.application_clients',
                'route_identifier_name' => 'application_clients_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \plate\V1\Rest\Application_clients\Application_clientsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.application_clients',
                'route_identifier_name' => 'application_clients_id',
                'is_collection' => true,
            ],
            \plate\V1\Rest\Scheduled_tasks\Scheduled_tasksEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.scheduled_tasks',
                'route_identifier_name' => 'scheduled_tasks_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \plate\V1\Rest\Scheduled_tasks\Scheduled_tasksCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.scheduled_tasks',
                'route_identifier_name' => 'scheduled_tasks_id',
                'is_collection' => true,
            ],
            \plate\V1\Rest\Scheduled_tasks_timetable\Scheduled_tasks_timetableEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.scheduled_tasks_timetable',
                'route_identifier_name' => 'scheduled_tasks_timetable_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \plate\V1\Rest\Scheduled_tasks_timetable\Scheduled_tasks_timetableCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.scheduled_tasks_timetable',
                'route_identifier_name' => 'scheduled_tasks_timetable_id',
                'is_collection' => true,
            ],
            \plate\V1\Rest\Dev2grp\Dev2grpEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.dev2grp',
                'route_identifier_name' => 'dev2grp_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \plate\V1\Rest\Dev2grp\Dev2grpCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.dev2grp',
                'route_identifier_name' => 'dev2grp_id',
                'is_collection' => true,
            ],
            \plate\V1\Rest\Groups\GroupsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.groups',
                'route_identifier_name' => 'groups_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \plate\V1\Rest\Groups\GroupsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'plate.rest.groups',
                'route_identifier_name' => 'groups_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-content-validation' => [
        'plate\\V1\\Rest\\Oauth_users_control\\Controller' => [
            'input_filter' => 'plate\\V1\\Rest\\Oauth_users_control\\Validator',
        ],
        'plate\\V1\\Rest\\Floors\\Controller' => [
            'input_filter' => 'plate\\V1\\Rest\\Floors\\Validator',
        ],
        'plate\\V1\\Rest\\Rooms\\Controller' => [
            'input_filter' => 'plate\\V1\\Rest\\Rooms\\Validator',
        ],
        'plate\\V1\\Rest\\Devices\\Controller' => [
            'input_filter' => 'plate\\V1\\Rest\\Devices\\Validator',
        ],
        'plate\\V1\\Rest\\Application_clients\\Controller' => [
            'input_filter' => 'plate\\V1\\Rest\\Application_clients\\Validator',
        ],
        'plate\\V1\\Rest\\Scheduled_tasks\\Controller' => [
            'input_filter' => 'plate\\V1\\Rest\\Scheduled_tasks\\Validator',
        ],
        'plate\\V1\\Rest\\Scheduled_tasks_timetable\\Controller' => [
            'input_filter' => 'plate\\V1\\Rest\\Scheduled_tasks_timetable\\Validator',
        ],
        'plate\\V1\\Rest\\Groups\\Controller' => [
            'input_filter' => 'plate\\V1\\Rest\\Groups\\Validator',
        ],
        'plate\\V1\\Rest\\Dev2grp\\Controller' => [
            'input_filter' => 'plate\\V1\\Rest\\Dev2grp\\Validator',
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
                'name' => 'timestamp',
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
            1 => [
                'name' => 'user',
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
        ],
        'plate\\V1\\Rest\\Oauth_users_control\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '4',
                            'max' => '30',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringToLower::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    2 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'client_id',
                'field_type' => '',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    2 => [
                        'name' => \Zend\Filter\Encrypt::class,
                        'options' => [
                            'adapter' => \plate\Filter\Encrypt\BcryptFilter::class,
                        ],
                    ],
                ],
                'name' => 'client_secret',
                'description' => 'password',
                'continue_if_empty' => false,
                'error_message' => 'Set',
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\UriNormalize::class,
                        'options' => [],
                    ],
                ],
                'name' => 'redirect_uri',
            ],
        ],
        'plate\\V1\\Rest\\DevicesAcl\\Validator' => [
            0 => [
                'name' => 'grp_id',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\Digits::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => 'ZF\\ContentValidation\\Validator\\DbNoRecordExists',
                        'options' => [
                            'adapter' => 'oauth2_users',
                            'table' => 'devices_acl',
                            'field' => 'grp_id',
                        ],
                    ],
                ],
            ],
            1 => [
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
                        'name' => 'ZF\\ContentValidation\\Validator\\DbNoRecordExists',
                        'options' => [
                            'adapter' => 'oauth2_users',
                            'table' => 'devices_acl',
                            'field' => 'client_id',
                        ],
                    ],
                    1 => [
                        'name' => 'ZF\\ContentValidation\\Validator\\DbNoRecordExists',
                        'options' => [
                            'adapter' => 'oauth2_users',
                            'table' => 'devices_acl',
                            'field' => 'client_id',
                        ],
                    ],
                    2 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '255',
                        ],
                    ],
                ],
            ],
            2 => [
                'name' => 'device_id',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\Digits::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => 'ZF\\ContentValidation\\Validator\\DbNoRecordExists',
                        'options' => [
                            'adapter' => 'oauth2_users',
                            'table' => 'devices_acl',
                            'field' => 'device_id',
                        ],
                    ],
                ],
            ],
        ],
        'plate\\V1\\Rest\\Floors\\Validator' => [
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
        ],
        'plate\\V1\\Rest\\Rooms\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'room_id',
                'field_type' => '',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'name',
            ],
        ],
        'plate\\V1\\Rest\\Devices\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Regex::class,
                        'options' => [
                            'pattern' => '/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
                            'message' => 'Bad mac-address format, must satisfy /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'mac',
                'description' => 'MAC-адрес интерфейса',
                'field_type' => '',
                'error_message' => 'Wrong mac-address!',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Ip::class,
                        'options' => [
                            'message' => 'must be valid ip',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'ip',
                'description' => 'IP адрес устройства',
                'error_message' => 'Wrong ip address!',
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'description',
                'description' => 'Именование устройства (пр. "штора на кухне")',
            ],
            3 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Digits::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'group_id',
                'description' => 'Id группы устройств',
                'error_message' => 'Must be 0 or natural',
            ],
            4 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => [
                            'adapter' => 'oauth2_users',
                            'table' => 'rooms',
                            'field' => 'id',
                            'message' => 'must be rooms.id record',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'room_id',
                'description' => 'id комнаты',
            ],
            5 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\ToInt::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'type',
                'description' => 'Тип подключения',
            ],
            6 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\ToInt::class,
                        'options' => [],
                    ],
                ],
                'name' => 'max_amp',
                'description' => 'Максимально допустимый ток в цепи питания двигателя в миллиамперах',
                'field_type' => 'Current, mA',
            ],
            7 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'connection_type',
            ],
            8 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '100',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'description' => 'команда, которая была обработана последней',
                'name' => 'last_command',
            ],
            9 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Digits::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\ToInt::class,
                        'options' => [],
                    ],
                ],
                'name' => 'channel',
                'description' => 'логический канал устройства',
            ],
        ],
        'plate\\V1\\Rest\\Application_clients\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Regex::class,
                        'options' => [
                            'pattern' => '/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
                            'message' => 'wrong mac address, must satisfy /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'mac',
                'description' => 'MAC адрес клиента',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Ip::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'ip',
                'description' => 'IP адрес клиента',
            ],
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '255',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'description',
                'description' => 'Отображаемое описание клиента',
            ],
            3 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '3',
                            'max' => '255',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'hostname',
                'description' => 'Hostname (имя устройства)',
            ],
        ],
        'plate\\V1\\Rest\\Scheduled_tasks\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Regex::class,
                        'options' => [
                            'pattern' => '/^(ACTIVE|PAUSED|STOPPED)$/',
                            'message' => 'wrong state value, must be one of ACTIVE, PAUSED, STOPPED',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringToUpper::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'state',
                'description' => 'Статус задачи - ACTIVE/PAUSED/STOPPED/ENDED',
            ],
            1 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => [
                            'adapter' => 'oauth2_users',
                            'table' => 'devices',
                            'field' => 'id',
                            'message' => 'Must be device with specified id',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'id_device',
                'description' => 'id устройства',
                'continue_if_empty' => true,
                'allow_empty' => true,
            ],
            2 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => [
                            'adapter' => 'oauth2_users',
                            'table' => 'devices',
                            'field' => 'group_id',
                            'message' => 'Must be device with specified id_group',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'id_group',
                'description' => 'id группы устройств',
                'allow_empty' => true,
                'continue_if_empty' => true,
            ],
            3 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Regex::class,
                        'options' => [
                            'pattern' => '/^(DEVICE|GROUP)$/',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringToUpper::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'grp_dev_type',
                'description' => 'тип привязанной сущности - устройство (DEVICE) или группа устройств (GROUP)',
            ],
            4 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Regex::class,
                        'options' => [
                            'pattern' => '/^(DAILY|WEEKLY|CUSTOM)$/',
                            'message' => 'period_type must be \'WEEKLY\', \'DAILY\' or \'CUSTOM\'',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringToUpper::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'period_type',
                'description' => 'тип периода - DAILY, WEEKLY, CUSTOM',
            ],
            5 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'command',
                'description' => 'Команда, которая должна быть выполнена',
            ],
            6 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '255',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'name',
                'description' => 'имя задачи по расписанию',
            ],
        ],
        'plate\\V1\\Rest\\Scheduled_tasks_timetable\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => [
                            'adapter' => 'oauth2_users',
                            'field' => 'id',
                            'message' => 'there must be scheduling_task satisfying scheduling_task_id',
                            'table' => 'scheduled_tasks',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'scheduling_task_id',
                'description' => 'id задачи по расписанию',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    2 => [
                        'name' => \Zend\Filter\DateTimeFormatter::class,
                        'options' => [
                            'format' => 'YYYY-mm-dd HH:ii:ss',
                        ],
                    ],
                ],
                'name' => 'begin_dtm',
                'description' => 'unix timestamp начала работы',
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\ToInt::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'repeat_period',
                'allow_empty' => true,
                'continue_if_empty' => true,
                'field_type' => '',
            ],
            3 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Regex::class,
                        'options' => [
                            'pattern' => '/^(ACTIVE|PAUSED)$/',
                            'message' => 'state must be ACTIVE or PAUSED',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'state',
                'description' => 'состояние - запущен/остановлен - ACTIVE, PAUSED',
            ],
            4 => [
                'required' => false,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    2 => [
                        'name' => \Zend\Filter\DateTimeFormatter::class,
                        'options' => [
                            'format' => 'YYYY-dd-mm HH:ii:ss',
                        ],
                    ],
                ],
                'name' => 'next_dtm',
                'description' => 'unix timestamp следующего запуска',
                'allow_empty' => true,
                'continue_if_empty' => true,
            ],
            5 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '255',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'special_stamp',
                'description' => 'Специальная отметка. Допускается любая строка до 255 символов длиной. Используется внешними приложениями для организации календарей (например, если предусмотрено расписание по дням недели, то здесь могут быть значения MORNING, SATURDAY и т.д.). Значения этого поля не влияют на работу серверной части. В пределах одного scheduled_tasks_id значения поля должны быть уникальны',
            ],
            6 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '255',
                            'min' => '2',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'name',
                'description' => 'Имя для отображения в ui',
            ],
        ],
        'plate\\V1\\Rest\\Groups\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '1',
                            'max' => '255',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'name',
                'description' => 'Имя группы',
            ],
        ],
        'plate\\V1\\Rest\\Dev2grp\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => [
                            'adapter' => 'oauth2_users',
                            'table' => 'devices',
                            'field' => 'id',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'device_id',
                'description' => 'Id устройства',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => [
                            'adapter' => 'oauth2_users',
                            'table' => 'groups',
                            'field' => 'id',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'group_id',
                'description' => 'Id группы',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'plate\\V1\\Rest\\Oauth_users_control\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'plate\\V1\\Rest\\Floors\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
            'plate\\V1\\Rest\\Rooms\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'plate\\V1\\Rest\\Devices\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'plate\\V1\\Rest\\Application_clients\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'plate\\V1\\Rest\\Scheduled_tasks\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'plate\\V1\\Rest\\Scheduled_tasks_timetable\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'plate\\V1\\Rest\\Groups\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
            ],
            'plate\\V1\\Rest\\Dev2grp\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
    'zf-apigility' => [
        'db-connected' => [
            'plate\\V1\\Rest\\Floors\\FloorsResource' => [
                'adapter_name' => 'oauth2_users',
                'table_name' => 'floors',
                'hydrator_name' => \Zend\Hydrator\ArraySerializable::class,
                'controller_service_name' => 'plate\\V1\\Rest\\Floors\\Controller',
                'entity_identifier_name' => 'id',
                'table_service' => 'plate\\V1\\Rest\\Floors\\FloorsResource\\Table',
            ],
        ],
    ],
];
