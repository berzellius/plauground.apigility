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
            ),
        ),
        'entity' => array(
            'description' => 'Описание комнаты',
            'GET' => array(
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
            ),
        ),
    ),
    'plate\\V1\\Rest\\Floors\\Controller' => array(
        'description' => 'Сервис для получения списка этажей. Предоставляется только авторизованным пользователям, позволяет читать информацию об этажах здания.
url: /floors[/:floors_id]',
        'collection' => array(
            'description' => 'Метод позволяет получать список этажей.',
            'GET' => array(
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
            ),
        ),
        'entity' => array(
            'description' => 'Метод позволяет получить информацию по конкретному этажу.',
            'GET' => array(
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
            ),
        ),
    ),
    'plate\\V1\\Rest\\Devices\\Controller' => array(
        'description' => 'Сервис для предоставления авторизованным пользователям информации об устройствах, которыми можно управлять (электрокарнизы, окна, шторы и т.д.) и группах устройств. 
Авторизованным пользователям позволяет читать список устройств и подробную информацию по устройству. При этом в списках будут отображаться только устройства, к которым политиками безопасности для авторизованного пользователя предоставлены разрешения.
Пользователям, авторизованным под учетной записью администратора, позволяет также добавлять, удалять, изменять устройства.

Url: /devices[/:devices_id]',
        'collection' => array(
            'description' => 'Метод позволяет получить список доступных устройств для управления ими. Список можно запрашивать с параметрами:
grp_id - получение устройств в группе.
      для получения списка необходимо явно предоставленное право пользователя на группу устройств в таблице списках доступа, либо права администратора;
room_id - получение списка устройств в комнате (если задан grp_id, room_id игнорируется):
     *      возвращает  полный список устройств в комнате (для аккаунта администратора);
     *      возвращает список устройств в комнате, которым явно предоставлено разрешение в таблице devices_acl.
Без параметров - только для аккаунта администратора - список всех устройств в системе.',
            'GET' => array(
                'description' => 'Получить список устройств. В качестве параметров запроса доступны grp_id, room_id.',
                'response' => '{
  "_links": {
    "self": {
      "href": "http://localhost:8080/devices?page=1"
    },
    "first": {
      "href": "http://localhost:8080/devices"
    },
    "last": {
      "href": "http://localhost:8080/devices?page=1"
    }
  },
  "_embedded": {
    "devices": [
      {
        "id": "1",
        "mac": "94:B1:0A:F8:47:B8",
        "ip": "192.168.10.101",
        "channel": "1",
        "description": "some dev",
        "group_id": "1",
        "room_id": "1",
        "type": "1",
        "max_amp": "250",
        "connection_type": "1",
        "_links": {
          "self": {
            "href": "http://localhost:8080/devices/1"
          }
        }
      },
      {
        "id": "2",
        "mac": "D0:E7:82:6E:B8:09",
        "ip": "192.168.10.101",
        "channel": "2",
        "description": "some other dev",
        "group_id": "1",
        "room_id": "1",
        "type": "1",
        "max_amp": "600",
        "connection_type": "2",
        "_links": {
          "self": {
            "href": "http://localhost:8080/devices/2"
          }
        }
      },
      {
        "id": "3",
        "mac": "60:A4:4C:32:11:C3",
        "ip": "192.168.10.102",
        "channel": "1",
        "description": "dev01 on 102",
        "group_id": "2",
        "room_id": "2",
        "type": "1",
        "max_amp": "170",
        "connection_type": "1",
        "_links": {
          "self": {
            "href": "http://localhost:8080/devices/3"
          }
        }
      },
      {
        "id": "4",
        "mac": "B8:27:EB:F0:B5:D4",
        "ip": "192.168.10.103",
        "channel": "1",
        "description": "dev01 on 103 ",
        "group_id": "2",
        "room_id": "1",
        "type": "1",
        "max_amp": "350",
        "connection_type": "1",
        "_links": {
          "self": {
            "href": "http://localhost:8080/devices/4"
          }
        }
      },
      {
        "id": "6",
        "mac": "B8:27:EB:F0:B5:D4",
        "ip": "192.168.10.103",
        "channel": "2",
        "description": "dev02 on 103 ",
        "group_id": "2",
        "room_id": "1",
        "type": "1",
        "max_amp": "350",
        "connection_type": "1",
        "_links": {
          "self": {
            "href": "http://localhost:8080/devices/6"
          }
        }
      }
    ]
  },
  "page_count": 1,
  "page_size": 25,
  "total_items": 5,
  "page": 1
}',
            ),
            'POST' => array(
                'request' => '{
        "mac": "94:B1:0A:F8:47:B8",
        "ip": "192.168.10.112",
        "channel": "1",
        "description": "логический канал 1 устройства на 10.112",
        "group_id": "1",
        "room_id": "1",
        "type": "1",
        "max_amp": "0.25",
        "connection_type": "1"
}',
                'description' => 'Добавить устройство (только для администраторов)',
                'response' => '{
  "id": "9",
  "mac": "94:B1:0A:F8:47:B8",
  "ip": "192.168.10.112",
  "channel": "1",
  "description": "логический канал 1 устройства на 10.112",
  "group_id": "1",
  "room_id": "1",
  "type": "1",
  "max_amp": "0.25",
  "connection_type": "1",
  "_links": {
    "self": {
      "href": "http://localhost:8080/devices/9"
    }
  }
}',
            ),
        ),
        'entity' => array(
            'description' => 'Метод позволяет получить данные по конкретному устройству, обновить их, а также удалить устройство',
            'GET' => array(
                'description' => 'Получить данные',
                'response' => '{
  "id": "9",
  "mac": "94:B1:0A:F8:47:B8",
  "ip": "192.168.10.112",
  "channel": "1",
  "description": "логический кана 1 устройства на 10.112",
  "group_id": "0",
  "room_id": "1",
  "type": "1",
  "max_amp": "0.25",
  "connection_type": "1",
  "_links": {
    "self": {
      "href": "http://localhost:8080/devices/9"
    }
  }
}',
            ),
            'PUT' => array(
                'description' => 'Полное обновление данных об устройстве. Стоит иметь в виду, что полное обновление переопределяет значение поля last_command, которое обновляется RPC-командами управления устройствами. Для того, чтобы избежать потери значения last_command, следует использовать частичное обновление http методом PATCH.',
                'request' => '{ 
  "mac": "94:B1:0A:F8:47:B8",
  "ip": "192.168.10.101",
  "channel": "1",
  "description": "some dev",
  "group_id": "1",
  "room_id": "1",
  "type": "1",
  "max_amp": "0.25",
  "connection_type": "1",
  "last_command": "up" 
}',
                'response' => '{
  "id": "1",
  "mac": "94:B1:0A:F8:47:B8",
  "ip": "192.168.10.101",
  "channel": "1",
  "description": "some dev",
  "group_id": "1",
  "room_id": "1",
  "type": "1",
  "max_amp": "0",
  "connection_type": "1",
  "last_command": null,
  "_links": {
    "self": {
      "href": "http://localhost:8080/devices/1"
    }
  }
}',
            ),
            'DELETE' => array(
                'description' => 'Удалить запись. Метод не возвращает данных. Http status = 204 (No content) при успешном удалении.',
            ),
            'PATCH' => array(
                'description' => 'Частичное обновление данных об устройстве. Использование метода PATCH при редактировании устройств предпочтительно, так как можно не передавать актуальное состояние поля last_command и оно не будет перезаписано.',
                'request' => '{ 
  "mac": "94:B1:0A:F8:47:B8",
  "ip": "192.168.10.101",
  "channel": "1",
  "description": "some dev",
  "group_id": "1",
  "room_id": "1",
  "type": "1",
  "max_amp": "250",
  "connection_type": "1"
}',
                'response' => '{
  "id": "1",
  "mac": "94:B1:0A:F8:47:B8",
  "ip": "192.168.10.101",
  "channel": "1",
  "description": "some dev",
  "group_id": "1",
  "room_id": "1",
  "type": "1",
  "max_amp": "250",
  "connection_type": "1",
  "last_command": "up",
  "_links": {
    "self": {
      "href": "http://localhost:8080/devices/1"
    }
  }
}',
            ),
        ),
    ),
);
