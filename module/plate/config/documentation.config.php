<?php
return [
    'plate\\V1\\Rest\\Motion\\Controller' => [
        'collection' => [
            'GET' => [
                'description' => 'methods for motion of electro window',
                'response' => '{
   "_links": {
       "self": {
           "href": "/motion"
       },
       "first": {
           "href": "/motion?page={page}"
       },
       "prev": {
           "href": "/motion?page={page}"
       },
       "next": {
           "href": "/motion?page={page}"
       },
       "last": {
           "href": "/motion?page={page}"
       }
   }
   "_embedded": {
       "motion": [
           {
               "_links": {
                   "self": {
                       "href": "/motion[/:motion_id]"
                   }
               }
              "status": "status of command"
           }
       ]
   }
}',
            ],
        ],
    ],
];
