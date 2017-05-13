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
    'devices' => array(
        'db' => 'oauth2_users',
        'table' => 'devices',
    ),
    'devices_acl' => array(
        'db' => 'oauth2_users',
        'table' => 'devices_acl',
    ),
    'rooms' => array(
        'db' => 'oauth2_users',
        'table' => 'rooms',
    ),
    'application_clients' => array(
        'db' => 'oauth2_users',
        'table' => 'application_clients'
    ),
    'scheduled_tasks' => array(
        'db' => 'oauth2_users',
        'table' => 'scheduled_tasks'
    ),
    'scheduled_tasks_timetable' => array(
        'db' => 'oauth2_users',
        'table' => 'scheduled_tasks_timetable'
    ),
    'groups' => array(
        'db' => 'oauth2_users',
        'table' => 'groups'
    ),
    'dev2grp' => array(
        'db' => 'oauth2_users',
        'table' => 'dev2grp'
    )
);
