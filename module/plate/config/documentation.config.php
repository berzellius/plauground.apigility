<?php
return array(
    'plate\\V1\\Rest\\Motion\\Controller' => array(
        'collection' => array(
            'GET' => array(
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
            ),
        ),
    ),
    'plate\\V1\\Rest\\Rooms\\Controller' => array(
        'description' => 'Сервис для получения списка комнат',
        'collection' => array(
            'description' => 'Список комнат',
            'GET' => array(
                'description' => 'Получить список комнат',
                'response' => '{
   "_links": {
       "self": {
           "href": "/rooms"
       },
       "first": {
           "href": "/rooms?page={page}"
       },
       "prev": {
           "href": "/rooms?page={page}"
       },
       "next": {
           "href": "/rooms?page={page}"
       },
       "last": {
           "href": "/rooms?page={page}"
       }
   }
   "_embedded": {
       "rooms": [
           {
               "_links": {
                   "self": {
                       "href": "/rooms[/:rooms_id]"
                   }
               }
              "room_id": "",
              "name": ""
           }
       ]
   }
}',
            ),
        ),
        'entity' => array(
            'description' => 'Описание комнаты',
            'GET' => array(
                'description' => 'Метод для получения данных о комнате',
                'response' => '{
   "_links": {
       "self": {
           "href": "/rooms[/:rooms_id]"
       }
   }
   "room_id": "",
   "name": ""
}',
            ),
        ),
    ),
);
