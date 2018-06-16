<?php
return array(
    'zf-content-negotiation' => array(
        'selectors' => array(),
    ),
    'db' => array(
        'adapters' => array(
            'dummy' => array(),
            'oauth2_users' => array(),
        ),
    ),
    'router' => array(
        'routes' => array(
            'oauth' => array(
                'options' => array(
                    'spec' => '%oauth%',
                    'regex' => '(?P<oauth>(/oauth))',
                ),
                'type' => 'regex',
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authentication' => array(
            'map' => array(
                'plate\\V1' => 'oauth',
            ),
        ),
    ),
    'oauth_users_control' => array(
        'db' => 'oauth2_users',
        'table' => 'oauth_clients',
    ),
    'application_clients' => array(
        'db' => 'oauth2_users',
        'table' => 'application_clients'
    ),
    'entities' => array(
        'db' => 'oauth2_users',
        'table' => 'entities'
    ),
    'entities_hierarchy' => [
        'db' => 'oauth2_users',
        'table' => 'entities_hierarchy'
    ],
    'basic_hierarchy' => array(
        'db' => 'oauth2_users',
        'table' => 'basic_hierarchy'
    ),
    'types' => array(
        'db' => 'oauth2_users',
        'table' => 'hierarchy_types'
    )
);
