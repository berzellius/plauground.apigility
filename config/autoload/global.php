<?php
return [
    'zf-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'adapters' => [
            'dummy' => [],
            'oauth2_users' => [],
        ],
    ],
    'router' => [
        'routes' => [
            'oauth' => [
                'options' => [
                    'spec' => '%oauth%',
                    'regex' => '(?P<oauth>(/oauth))',
                ],
                'type' => 'regex',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authentication' => [
            'map' => [
                'plate\\V1' => 'oauth',
            ],
        ],
    ],
    'oauth_users_control' => [
        'db' => 'oauth2_users',
        'table' => 'oauth_clients',
    ],
    'devices' => [
        'db' => 'oauth2_users',
        'table' => 'devices',
    ],
    'devices_acl' => [
        'db' => 'oauth2_users',
        'table' => 'devices_acl',
    ],
    'rooms' => [
        'db' => 'oauth2_users',
        'table' => 'rooms',
    ],
    'application_clients' => [
        'db' => 'oauth2_users',
        'table' => 'application_clients',
    ],
];
