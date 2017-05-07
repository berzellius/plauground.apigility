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
    'plate\\V1\\Rest\\Rooms\\Controller' => [
        'description' => 'Сервис для получения списка комнат',
        'collection' => [
            'description' => 'Список комнат',
            'GET' => [
                'description' => 'Получить список комнат.
Возвращает полный список комнат одинаково для любого авторизованного пользователя.',
                'response' => '{
  "_links": {
    "self": {
      "href": "http://localhost:8080/rooms?page=1"
    },
    "first": {
      "href": "http://localhost:8080/rooms"
    },
    "last": {
      "href": "http://localhost:8080/rooms?page=1"
    }
  },
  "_embedded": {
    "rooms": [
      {
        "id": "1",
        "floor_id": "1",
        "name": "Гостиная",
        "_links": {
          "self": {
            "href": "http://localhost:8080/rooms/1"
          }
        }
      },
      {
        "id": "2",
        "floor_id": "1",
        "name": "Санузел#1",
        "_links": {
          "self": {
            "href": "http://localhost:8080/rooms/2"
          }
        }
      },
      {
        "id": "3",
        "floor_id": "1",
        "name": "Топка",
        "_links": {
          "self": {
            "href": "http://localhost:8080/rooms/3"
          }
        }
      },
      {
        "id": "4",
        "floor_id": "1",
        "name": "Кухня",
        "_links": {
          "self": {
            "href": "http://localhost:8080/rooms/4"
          }
        }
      },
      {
        "id": "5",
        "floor_id": "1",
        "name": "Столовая",
        "_links": {
          "self": {
            "href": "http://localhost:8080/rooms/5"
          }
        }
      },
      {
        "id": "6",
        "floor_id": "1",
        "name": "Веранда",
        "_links": {
          "self": {
            "href": "http://localhost:8080/rooms/6"
          }
        }
      },
      {
        "id": "7",
        "floor_id": "2",
        "name": "Спальня#1",
        "_links": {
          "self": {
            "href": "http://localhost:8080/rooms/7"
          }
        }
      },
      {
        "id": "8",
        "floor_id": "2",
        "name": "Санузел#2",
        "_links": {
          "self": {
            "href": "http://localhost:8080/rooms/8"
          }
        }
      },
      {
        "id": "9",
        "floor_id": "2",
        "name": "Спальня#2",
        "_links": {
          "self": {
            "href": "http://localhost:8080/rooms/9"
          }
        }
      },
      {
        "id": "10",
        "floor_id": "2",
        "name": "Коридор",
        "_links": {
          "self": {
            "href": "http://localhost:8080/rooms/10"
          }
        }
      },
      {
        "id": "11",
        "floor_id": "3",
        "name": "Спальня#3",
        "_links": {
          "self": {
            "href": "http://localhost:8080/rooms/11"
          }
        }
      },
      {
        "id": "12",
        "floor_id": "3",
        "name": "Санузел#3",
        "_links": {
          "self": {
            "href": "http://localhost:8080/rooms/12"
          }
        }
      }
    ]
  },
  "page_count": 1,
  "page_size": 25,
  "total_items": 12,
  "page": 1
}',
            ],
        ],
        'entity' => [
            'description' => 'Описание комнаты',
            'GET' => [
                'description' => 'Метод для получения данных о комнате',
                'response' => '{
  "id": "1",
  "floor_id": "1",
  "name": "Гостиная",
  "_links": {
    "self": {
      "href": "http://localhost:8080/rooms/1"
    }
  }
}',
            ],
        ],
    ],
    'plate\\V1\\Rest\\Floors\\Controller' => [
        'description' => 'Сервис для получения списка этажей. Предоставляется только авторизованным пользователям, позволяет читать информацию об этажах здания.
url: /floors[/:floors_id]',
        'collection' => [
            'description' => 'Метод позволяет получать список этажей.',
            'GET' => [
                'description' => 'Получить список этажей',
                'response' => '{
  "_links": {
    "self": {
      "href": "http://localhost:8080/floors?page=1"
    },
    "first": {
      "href": "http://localhost:8080/floors"
    },
    "last": {
      "href": "http://localhost:8080/floors?page=1"
    }
  },
  "_embedded": {
    "floors": [
      {
        "id": "1",
        "name": "Первый этаж",
        "_links": {
          "self": {
            "href": "http://localhost:8080/floors/1"
          }
        }
      },
      {
        "id": "2",
        "name": "Второй Этаж",
        "_links": {
          "self": {
            "href": "http://localhost:8080/floors/2"
          }
        }
      },
      {
        "id": "3",
        "name": "Третий этаж",
        "_links": {
          "self": {
            "href": "http://localhost:8080/floors/3"
          }
        }
      },
      {
        "id": "4",
        "name": "Четвертый этаж",
        "_links": {
          "self": {
            "href": "http://localhost:8080/floors/4"
          }
        }
      }
    ]
  },
  "page_count": 1,
  "page_size": 25,
  "total_items": 4,
  "page": 1
}',
            ],
        ],
        'entity' => [
            'description' => 'Метод позволяет получить информацию по конкретному этажу.',
            'GET' => [
                'response' => '{
  "id": "4",
  "name": "Четвертый этаж",
  "_links": {
    "self": {
      "href": "http://localhost:8080/floors/4"
    }
  }
}',
                'description' => 'Получить информацию по этажу.',
            ],
        ],
    ],
];
