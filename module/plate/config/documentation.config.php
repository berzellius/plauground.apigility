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
    'plate\\V1\\Rest\\Application_clients\\Controller' => array(
        'description' => 'Сервис для предоставления администраторам информации о мобильных устройствах, на которых установлены приложения для управления устройствами.',
        'collection' => array(
            'description' => 'Позволяет работать со списком мобильных устройств.',
            'GET' => array(
                'description' => 'Получить список устройств. Параметры не поддерживаются.',
                'response' => '{
  "_links": {
    "self": {
      "href": "http://localhost:8080/application_clients?page=1"
    },
    "first": {
      "href": "http://localhost:8080/application_clients"
    },
    "last": {
      "href": "http://localhost:8080/application_clients?page=1"
    }
  },
  "_embedded": {
    "application_clients": [
      {
        "id": "1",
        "mac": "00:25:d1:f5:e8:aa",
        "ip": "192.168.1.110",
        "description": "fathers iphone",
        "hostname": "IvanOl_tel",
        "_links": {
          "self": {
            "href": "http://localhost:8080/application_clients/1"
          }
        }
      },
      {
        "id": "2",
        "mac": "df:54:dd:ff:ea:aa",
        "ip": "192.168.1.111",
        "description": "mothers iphone6s",
        "hostname": "Andrea k",
        "_links": {
          "self": {
            "href": "http://localhost:8080/application_clients/2"
          }
        }
      }
    ]
  },
  "page_count": 1,
  "page_size": 25,
  "total_items": 2,
  "page": 1
}',
            ),
            'POST' => array(
                'description' => 'Добавление мобильного устройства.',
                'request' => '{
        "mac": "df:54:dd:ff:ea:ab",
        "ip": "192.168.1.112",
        "description": "mothers iphone5",
        "hostname": "Andrea 1k"
}',
                'response' => '{
  "id": "7",
  "mac": "df:54:dd:ff:ea:ab",
  "ip": "192.168.1.112",
  "description": "mothers iphone5",
  "hostname": "Andrea 1k",
  "_links": {
    "self": {
      "href": "http://localhost:8080/application_clients/7"
    }
  }
}',
            ),
        ),
        'entity' => array(
            'description' => 'Позволяет работать с мобильным устройством',
            'GET' => array(
                'description' => 'Получить информацию о мобильном устройстве',
                'response' => '{
  "id": "2",
  "mac": "df:54:dd:ff:ea:aa",
  "ip": "192.168.1.111",
  "description": "mothers iphone6s",
  "hostname": "Andrea k",
  "_links": {
    "self": {
      "href": "http://localhost:8080/application_clients/2"
    }
  }
}',
            ),
            'PATCH' => array(
                'request' => '{
        "mac": "df:54:dd:ff:ea:aa",
        "ip": "192.168.1.111",
        "description": "mothers iphone6s",
        "hostname": "Andrea k"
}',
                'description' => 'Частичное обновление данных о мобильном устройстве',
                'response' => '{
  "id": "2",
  "mac": "df:54:dd:ff:ea:aa",
  "ip": "192.168.1.111",
  "description": "mothers iphone6s",
  "hostname": "Andrea k",
  "_links": {
    "self": {
      "href": "http://localhost:8080/application_clients/2"
    }
  }
}',
            ),
            'PUT' => array(
                'description' => 'Полное обновление данных о мобильном устройстве',
                'request' => '{
        "mac": "df:54:dd:ff:ea:aa",
        "ip": "192.168.1.111",
        "description": "mothers iphone6s",
        "hostname": "Andrea k"
}',
                'response' => '{
  "id": "2",
  "mac": "df:54:dd:ff:ea:aa",
  "ip": "192.168.1.111",
  "description": "mothers iphone6s",
  "hostname": "Andrea k",
  "_links": {
    "self": {
      "href": "http://localhost:8080/application_clients/2"
    }
  }
}',
            ),
            'DELETE' => array(
                'description' => 'Удалить запись. Метод не возвращает данных. Http status = 204',
            ),
        ),
    ),
    'plate\\V1\\Rest\\Scheduled_tasks_timetable\\Controller' => array(
        'description' => 'Сервис для работы с расписаниями назначенных заданий. Для всех методов права доступа определяются правами доступа к соответствующим назначенным заданиям.',
        'collection' => array(
            'description' => 'Работа со списком расписаний назначенных заданий.',
            'GET' => array(
                'description' => 'Получить расписания назначенных заданий. Принимает параметр \'scheduling_task_id\' - id назначенного задания, который является обязательным для всех, кроме администраторов.',
            ),
            'POST' => array(
                'description' => 'Создать элемент расписания назначенного задания.',
            ),
        ),
        'entity' => array(
            'description' => 'Работа со строкой расписания назначенного задания.',
            'GET' => array(
                'description' => 'Получить строку расписания.',
            ),
            'PATCH' => array(
                'description' => 'Частичное обновление строки расписания.',
            ),
            'PUT' => array(
                'description' => 'Полное обновление строки расписания.',
            ),
            'DELETE' => array(
                'description' => 'Удаление строки расписания.',
            ),
        ),
    ),
    'plate\\V1\\Rpc\\Commands2devGroups\\Controller' => array(
        'POST' => array(
            'request' => '{
   "group": "Id группы, которой нужно отправить команду",
   "command": "Команда"
}',
            'response' => '{
  "status": "ok",
  "message": "command sent",
  "device": [
    {
      "id": "1",
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
      "max_amp": "0.6",
      "connection_type": "2",
      "last_command": "up"
    }
  ]
}',
            'description' => 'используется только метод POST',
        ),
        'description' => 'Сервис для отправки команды ("up", "down") группе устройств',
    ),
    'plate\\V1\\Rpc\\Commands2devices\\Controller' => array(
        'POST' => array(
            'request' => '{
   "device": "id устройства, на которое подается команда",
   "command": "команда, которую нужно отправить"
}',
            'response' => '{
  "status": "ok",
  "message": "command sent",
  "device": {
    "id": "1",
    "mac": "94:B1:0A:F8:47:B8",
    "ip": "192.168.10.101",
    "channel": "1",
    "description": "some dev",
    "group_id": "1",
    "room_id": "1",
    "type": "1",
    "max_amp": "0.25",
    "connection_type": "1",
    "last_command": "down"
  }
}',
            'description' => 'используется только метод POST',
        ),
        'description' => 'Позволяет отправлять команды ("up", "down") устройствам',
    ),
    'plate\\V1\\Rest\\Dev2grp\\Controller' => array(
        'description' => 'Управление распределением устройств по группам',
        'collection' => array(
            'description' => 'Управление списком элементов',
            'GET' => array(
                'description' => 'Получить записи соответствия устройство->группа  с учетом доступа к устройствам и группам. Подразумевается, что если пользователь имеет доступ к группе устройств, то он имеет доступ и ко все устройствам в этой группе.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/dev2grp"
       },
       "first": {
           "href": "/dev2grp?page={page}"
       },
       "prev": {
           "href": "/dev2grp?page={page}"
       },
       "next": {
           "href": "/dev2grp?page={page}"
       },
       "last": {
           "href": "/dev2grp?page={page}"
       }
   }
   "_embedded": {
       "dev2grp": [
           {
               "_links": {
                   "self": {
                       "href": "/dev2grp[/:dev2grp_id]"
                   }
               }
              "device_id": "Id устройства",
              "group_id": "Id группы"
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Добавить соответствие устройство->группа. При этом должны быть выполнены условия: 1) пользователь имеет право доступа к устройству; 2) пользователь имеет право доступа к группе; 3) в системе нет пользователей, которые имеют доступ к группе, но не имеют доступа к устройству.',
                'request' => '{
   "device_id": "Id устройства",
   "group_id": "Id группы"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/dev2grp[/:dev2grp_id]"
       }
   }
   "device_id": "Id устройства",
   "group_id": "Id группы"
}',
            ),
        ),
        'entity' => array(
            'description' => 'Управление записью устройство->группа. Доступно только удаление',
            'DELETE' => array(
                'description' => 'Удаление записи устройство->группа. Как устройство, так и группа должны быть доступны пользователю.',
                'request' => '{
   "device_id": "Id устройства",
   "group_id": "Id группы"
}',
            ),
        ),
    ),
    'plate\\V1\\Rest\\Groups\\Controller' => array(
        'description' => 'Управление группами устройств',
        'collection' => array(
            'description' => 'Управление списком групп устройств',
            'GET' => array(
                'response' => '{
   "_links": {
       "self": {
           "href": "/groups"
       },
       "first": {
           "href": "/groups?page={page}"
       },
       "prev": {
           "href": "/groups?page={page}"
       },
       "next": {
           "href": "/groups?page={page}"
       },
       "last": {
           "href": "/groups?page={page}"
       }
   }
   "_embedded": {
       "groups": [
           {
               "_links": {
                   "self": {
                       "href": "/groups[/:groups_id]"
                   }
               }
              "name": "Имя группы"
           }
       ]
   }
}',
                'description' => 'Получить список групп. Обычный пользователь получит все группы, к которым у него есть доступ, администратор - полный список групп',
            ),
            'POST' => array(
                'description' => 'Создать группу. Доступно как администратору, так и обычному пользователю. Обычному пользователю автоматически добавляет созданную группу в список доступа.',
                'request' => '{
   "name": "Имя группы"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/groups[/:groups_id]"
       }
   }
   "name": "Имя группы"
}',
            ),
        ),
        'entity' => array(
            'description' => 'Управление группой',
            'GET' => array(
                'description' => 'Получить группу. Для обычного пользователя должен быть предоставлен доступ.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/groups[/:groups_id]"
       }
   }
   "name": "Имя группы"
}',
            ),
            'PUT' => array(
                'description' => 'Обновить группу. Для обычного пользователя должен быть предоставлен доступ.',
                'request' => '{
   "name": "Имя группы"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/groups[/:groups_id]"
       }
   }
   "name": "Имя группы"
}',
            ),
            'DELETE' => array(
                'description' => 'Удалить группу. Для обычного пользователя должен быть предоставлен доступ.',
                'request' => '{
   "name": "Имя группы"
}',
                'response' => '',
            ),
            'PATCH' => array(
                'description' => 'Частичное обновление группы. Для обычного пользователя должен быть предоставлен доступ.',
                'request' => '{
   "name": "Имя группы",
   "last_command": "команда, которая была обработана последней"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/groups[/:groups_id]"
       }
   }
   "name": "Имя группы",
   "last_command": "команда, которая была обработана последней"
}',
            ),
        ),
    ),
    'plate\\V1\\Rest\\Favorites\\Controller' => array(
        'description' => 'Сервис для добавления элемента в избранное и удаления из избранного',
        'collection' => array(
            'POST' => array(
                'request' => '{
   "id_device": "",
   "id_group": "",
   "user": "",
   "entity_type": "Тип сущности, добавляемой в Избранное. Устройство, группа или назначенное задание.",
   "id_scheduled_task": ""
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/favorites[/:favorites_id]"
       }
   }
   "id_device": "",
   "id_group": "",
   "user": "",
   "entity_type": "Тип сущности, добавляемой в Избранное. Устройство, группа или назначенное задание.",
   "id_scheduled_task": ""
}',
                'description' => 'Поле user можно не передавать; entity_type должно содержать одно из трех значений: DEVICE, GROUP, SCHEDULED в зависимости от того, что мы добавляем в избранное. Соответственно, в зависимости от entity_type должно быть заполнено одно из полей id_device, id_group, id_scheduled_task',
            ),
            'description' => 'Для получения всех объектов из избранного используется RPC-метод GET /favorites_rpc, см. ссылку FavoritesRpc в левой колонке',
        ),
        'entity' => array(
            'DELETE' => array(
                'request' => '',
                'response' => '{
   "_links": {
       "self": {
           "href": "/favorites[/:favorites_id]"
       }
   }
   "id_device": "",
   "id_group": "",
   "user": "",
   "entity_type": "Тип сущности, добавляемой в Избранное. Устройство, группа или назначенное задание.",
   "id_scheduled_task": ""
}',
                'description' => 'DELETE /favorites/[id] удаляет элемент по id - идентификатор объекта из избранного',
            ),
        ),
    ),
    'plate\\V1\\Rest\\Scheduled_tasks\\Controller' => array(
        'description' => 'Сервис для работы с назначенными заданиями.',
        'collection' => array(
            'description' => 'Работа со списком назначенным заданием.',
            'GET' => array(
                'description' => 'Метод для получения списка заданий. Администраторам возвращается полный список заданий. Обычные пользователи видят только те задания, которые привязаны к устройствам или группам, к которым им предоставлен доступ (см. сервис devices)',
                'response' => '{
  "_links": {
    "self": {
      "href": "http://localhost:8080/scheduled_tasks?page=1"
    },
    "first": {
      "href": "http://localhost:8080/scheduled_tasks"
    },
    "last": {
      "href": "http://localhost:8080/scheduled_tasks?page=1"
    }
  },
  "_embedded": {
    "scheduled_tasks": [
      {
        "id": "2",
        "state": "ACTIVE",
        "id_device": "1",
        "id_group": null,
        "grp_dev_type": "DEVICE",
        "period_type": "WEEKLY",
        "command": "up",
        "name": "задача#1",
        "_links": {
          "self": {
            "href": "http://localhost:8080/scheduled_tasks/2"
          }
        }
      },
      {
        "id": "6",
        "state": "ACTIVE",
        "id_device": "7",
        "id_group": null,
        "grp_dev_type": "DEVICE",
        "period_type": "WEEKLY",
        "command": "up",
        "name": "задача#8",
        "_links": {
          "self": {
            "href": "http://localhost:8080/scheduled_tasks/6"
          }
        }
      },
      {
        "id": "7",
        "state": "ACTIVE",
        "id_device": "7",
        "id_group": null,
        "grp_dev_type": "DEVICE",
        "period_type": "WEEKLY",
        "command": "up",
        "name": "задача#7",
        "_links": {
          "self": {
            "href": "http://localhost:8080/scheduled_tasks/7"
          }
        }
      },
      {
        "id": "3",
        "state": "ACTIVE",
        "id_device": "9",
        "id_group": null,
        "grp_dev_type": "DEVICE",
        "period_type": "WEEKLY",
        "command": "up",
        "name": "задача#9.1",
        "_links": {
          "self": {
            "href": "http://localhost:8080/scheduled_tasks/3"
          }
        }
      },
      {
        "id": "1",
        "state": "ACTIVE",
        "id_device": null,
        "id_group": "1",
        "grp_dev_type": "GROUP",
        "period_type": "WEEKLY",
        "command": "up",
        "name": "задача#0",
        "_links": {
          "self": {
            "href": "http://localhost:8080/scheduled_tasks/1"
          }
        }
      },
      {
        "id": "4",
        "state": "ACTIVE",
        "id_device": null,
        "id_group": "1",
        "grp_dev_type": "GROUP",
        "period_type": "WEEKLY",
        "command": "up",
        "name": "задача#гр.1",
        "_links": {
          "self": {
            "href": "http://localhost:8080/scheduled_tasks/4"
          }
        }
      },
      {
        "id": "5",
        "state": "ACTIVE",
        "id_device": null,
        "id_group": "2",
        "grp_dev_type": "GROUP",
        "period_type": "WEEKLY",
        "command": "up",
        "name": "задача#гр.1",
        "_links": {
          "self": {
            "href": "http://localhost:8080/scheduled_tasks/5"
          }
        }
      }
    ]
  },
  "page_count": 1,
  "page_size": 25,
  "total_items": 7,
  "page": 1
}',
            ),
            'POST' => array(
                'description' => 'Создать назначенное задание. 
Нужно передать поля назначенного задания, а также
stamps - перечень отметок (для еженедельных заданий это дни недели) через запятую - например, MONDAY, FRIDAY, SUNDAY если задание должно выполняться в понедельник, пятницу, воскресенье
devices_ids - идентификаторы устройств, которые нужно привязать к заданию
groups_ids - идентификаторы устройств, которые нужно привязать к заданию',
                'request' => '{
	"state" : "ACTIVE",
	"period_type" : "WEEKLY",
	"command" : "up",
	"name" : "test#2",
	"stamps" : "  MONDAY,wedww    ,  wef",
	"devices_ids" : "422,424",
	"groups_ids" : "108,107",
	"time" : "23:59"
}',
                'response' => '{
    "id": "32",
    "name": "test#2",
    "state": "ACTIVE",
    "command": "up",
    "period_type": "WEEKLY",
    "stamps": "MONDAY",
    "time": "23:59:00",
    "devices": [
        {
            "id": "422",
            "mac": "98:BE:A4:EE:25:02",
            "ip": "10.121.0.101",
            "channel": "2",
            "description": "устройство для откладки #2",
            "room_id": "2",
            "type": "1",
            "max_amp": "250",
            "connection_type": "1",
            "last_command": null
        },
        {
            "id": "424",
            "mac": "98:BE:A4:EE:25:04",
            "ip": "10.121.0.101",
            "channel": "4",
            "description": "устройство для откладки #4",
            "room_id": "3",
            "type": "1",
            "max_amp": "250",
            "connection_type": "1",
            "last_command": null
        }
    ],
    "groups": [
        {
            "id": "108",
            "name": "группа для отладки #2",
            "last_command": null
        },
        {
            "id": "107",
            "name": "группа для отладки#1",
            "last_command": null
        }
    ],
    "_links": {
        "self": {
            "href": "http://localhost:8080/scheduled_tasks/32"
        }
    }
}',
            ),
        ),
        'entity' => array(
            'description' => 'Работа с записью о назначенном задании.',
            'GET' => array(
                'description' => 'Метод для получения записи о назначенном задании.',
            ),
            'PATCH' => array(
                'description' => 'Метод для частичного обновления записи  о назначенном задании.',
            ),
            'PUT' => array(
                'description' => 'Метод для полного обновления записи  о назначенном задании.',
            ),
            'DELETE' => array(
                'description' => 'Метод для удаления о назначенном задании.',
            ),
        ),
    ),
    'plate\\V1\\Rpc\\ItemsLists\\Controller' => array(
        'description' => 'Получение списка всех основных объектов в системе (устройств, групп, назначенных заданий)',
        'GET' => array(
            'description' => 'Получить список всех объектов в виде контейнеров devices, groups, scheduled_tasks. Возможно получение объектов по id комнаты (get параметр room_id)',
            'response' => '{
    "devices": [
        {
            "id": "421",
            "mac": "98:BE:A4:EE:25:00",
            "ip": "10.121.0.101",
            "channel": "1",
            "description": "устройство для откладки #1",
            "room_id": "1",
            "type": "1",
            "max_amp": "250",
            "connection_type": "1",
            "last_command": null
        },
        {
            "id": "422",
            "mac": "98:BE:A4:EE:25:02",
            "ip": "10.121.0.101",
            "channel": "2",
            "description": "устройство для откладки #2",
            "room_id": "2",
            "type": "1",
            "max_amp": "250",
            "connection_type": "1",
            "last_command": null
        },
        {
            "id": "423",
            "mac": "98:BE:A4:EE:25:03",
            "ip": "10.121.0.101",
            "channel": "3",
            "description": "устройство для откладки #3",
            "room_id": "1",
            "type": "1",
            "max_amp": "250",
            "connection_type": "1",
            "last_command": null
        },
        {
            "id": "424",
            "mac": "98:BE:A4:EE:25:04",
            "ip": "10.121.0.101",
            "channel": "4",
            "description": "устройство для откладки #4",
            "room_id": "3",
            "type": "1",
            "max_amp": "250",
            "connection_type": "1",
            "last_command": null
        }
    ],
    "groups": [
        {
            "id": "107",
            "name": "группа для отладки#1",
            "last_command": null
        },
        {
            "id": "108",
            "name": "группа для отладки #2",
            "last_command": null
        }
    ],
    "scheduled_tasks": [
        {
            "id": "2",
            "name": "задача#1",
            "state": "ACTIVE",
            "command": "up",
            "period_type": "WEEKLY",
            "stamps": "f,f1",
            "time": null,
            "devices": [
                {
                    "id": "3",
                    "mac": "60:A4:4C:32:11:C3",
                    "ip": "192.168.10.102",
                    "channel": "1",
                    "description": "dev01 on 102",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "170",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "423",
                    "mac": "98:BE:A4:EE:25:03",
                    "ip": "10.121.0.101",
                    "channel": "3",
                    "description": "устройство для откладки #3",
                    "room_id": "1",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "425",
                    "mac": "98:BE:A4:EE:25:05",
                    "ip": "10.121.0.101",
                    "channel": "5",
                    "description": "устройство для откладки #5",
                    "room_id": "1",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "119",
                    "name": "всякие девайсы",
                    "last_command": null
                },
                {
                    "id": "2",
                    "name": "мои шторы",
                    "last_command": null
                }
            ]
        },
        {
            "id": "3",
            "name": "задача#9.1",
            "state": "ACTIVE",
            "command": "up",
            "period_type": "WEEKLY",
            "stamps": null,
            "time": null,
            "devices": [
                {
                    "id": "6",
                    "mac": "B8:27:EB:F0:B5:D4",
                    "ip": "192.168.10.103",
                    "channel": "2",
                    "description": "dev02 on 103 ",
                    "room_id": "1",
                    "type": "1",
                    "max_amp": "350",
                    "connection_type": "1",
                    "last_command": null
                }
            ]
        },
        {
            "id": "22",
            "name": "test#1",
            "state": "ACTIVE",
            "command": "up",
            "period_type": "WEEKLY",
            "stamps": null,
            "time": null,
            "devices": [
                {
                    "id": "422",
                    "mac": "98:BE:A4:EE:25:02",
                    "ip": "10.121.0.101",
                    "channel": "2",
                    "description": "устройство для откладки #2",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "424",
                    "mac": "98:BE:A4:EE:25:04",
                    "ip": "10.121.0.101",
                    "channel": "4",
                    "description": "устройство для откладки #4",
                    "room_id": "3",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "107",
                    "name": "группа для отладки#1",
                    "last_command": null
                }
            ]
        },
        {
            "id": "23",
            "name": "test#1",
            "state": "ACTIVE",
            "command": "up",
            "period_type": "WEEKLY",
            "stamps": null,
            "time": null,
            "devices": [
                {
                    "id": "422",
                    "mac": "98:BE:A4:EE:25:02",
                    "ip": "10.121.0.101",
                    "channel": "2",
                    "description": "устройство для откладки #2",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "424",
                    "mac": "98:BE:A4:EE:25:04",
                    "ip": "10.121.0.101",
                    "channel": "4",
                    "description": "устройство для откладки #4",
                    "room_id": "3",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "107",
                    "name": "группа для отладки#1",
                    "last_command": null
                }
            ]
        },
        {
            "id": "24",
            "name": "test#1",
            "state": "ACTIVE",
            "command": "up",
            "period_type": "WEEKLY",
            "stamps": null,
            "time": null,
            "devices": [
                {
                    "id": "422",
                    "mac": "98:BE:A4:EE:25:02",
                    "ip": "10.121.0.101",
                    "channel": "2",
                    "description": "устройство для откладки #2",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "424",
                    "mac": "98:BE:A4:EE:25:04",
                    "ip": "10.121.0.101",
                    "channel": "4",
                    "description": "устройство для откладки #4",
                    "room_id": "3",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "107",
                    "name": "группа для отладки#1",
                    "last_command": null
                }
            ]
        },
        {
            "id": "25",
            "name": "test#1",
            "state": "ACTIVE",
            "command": "up",
            "period_type": "WEEKLY",
            "stamps": null,
            "time": null,
            "devices": [
                {
                    "id": "422",
                    "mac": "98:BE:A4:EE:25:02",
                    "ip": "10.121.0.101",
                    "channel": "2",
                    "description": "устройство для откладки #2",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "424",
                    "mac": "98:BE:A4:EE:25:04",
                    "ip": "10.121.0.101",
                    "channel": "4",
                    "description": "устройство для откладки #4",
                    "room_id": "3",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "107",
                    "name": "группа для отладки#1",
                    "last_command": null
                }
            ]
        },
        {
            "id": "26",
            "name": "test#1",
            "state": "ACTIVE",
            "command": "up",
            "period_type": "WEEKLY",
            "stamps": null,
            "time": null,
            "devices": [
                {
                    "id": "422",
                    "mac": "98:BE:A4:EE:25:02",
                    "ip": "10.121.0.101",
                    "channel": "2",
                    "description": "устройство для откладки #2",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "424",
                    "mac": "98:BE:A4:EE:25:04",
                    "ip": "10.121.0.101",
                    "channel": "4",
                    "description": "устройство для откладки #4",
                    "room_id": "3",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "107",
                    "name": "группа для отладки#1",
                    "last_command": null
                }
            ]
        },
        {
            "id": "27",
            "name": "test#1",
            "state": "ACTIVE",
            "command": "up",
            "period_type": "WEEKLY",
            "stamps": null,
            "time": null,
            "devices": [
                {
                    "id": "422",
                    "mac": "98:BE:A4:EE:25:02",
                    "ip": "10.121.0.101",
                    "channel": "2",
                    "description": "устройство для откладки #2",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "424",
                    "mac": "98:BE:A4:EE:25:04",
                    "ip": "10.121.0.101",
                    "channel": "4",
                    "description": "устройство для откладки #4",
                    "room_id": "3",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "107",
                    "name": "группа для отладки#1",
                    "last_command": null
                }
            ]
        },
        {
            "id": "28",
            "name": "test#1",
            "state": "ACTIVE",
            "command": "up",
            "period_type": "WEEKLY",
            "stamps": null,
            "time": null,
            "devices": [
                {
                    "id": "422",
                    "mac": "98:BE:A4:EE:25:02",
                    "ip": "10.121.0.101",
                    "channel": "2",
                    "description": "устройство для откладки #2",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "424",
                    "mac": "98:BE:A4:EE:25:04",
                    "ip": "10.121.0.101",
                    "channel": "4",
                    "description": "устройство для откладки #4",
                    "room_id": "3",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "107",
                    "name": "группа для отладки#1",
                    "last_command": null
                }
            ]
        },
        {
            "id": "29",
            "name": "test#1",
            "state": "ACTIVE",
            "command": "up",
            "period_type": "WEEKLY",
            "stamps": null,
            "time": null,
            "devices": [
                {
                    "id": "422",
                    "mac": "98:BE:A4:EE:25:02",
                    "ip": "10.121.0.101",
                    "channel": "2",
                    "description": "устройство для откладки #2",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "424",
                    "mac": "98:BE:A4:EE:25:04",
                    "ip": "10.121.0.101",
                    "channel": "4",
                    "description": "устройство для откладки #4",
                    "room_id": "3",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "107",
                    "name": "группа для отладки#1",
                    "last_command": null
                }
            ]
        },
        {
            "id": "30",
            "name": "test#1",
            "state": "ACTIVE",
            "command": "up",
            "period_type": "WEEKLY",
            "stamps": "TUESDAY",
            "time": "17:10:00",
            "devices": [
                {
                    "id": "422",
                    "mac": "98:BE:A4:EE:25:02",
                    "ip": "10.121.0.101",
                    "channel": "2",
                    "description": "устройство для откладки #2",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "424",
                    "mac": "98:BE:A4:EE:25:04",
                    "ip": "10.121.0.101",
                    "channel": "4",
                    "description": "устройство для откладки #4",
                    "room_id": "3",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "107",
                    "name": "группа для отладки#1",
                    "last_command": null
                }
            ]
        },
        {
            "id": "31",
            "name": "test#1",
            "state": "ACTIVE",
            "command": "up",
            "period_type": "WEEKLY",
            "stamps": "MONDAY",
            "time": null,
            "devices": [
                {
                    "id": "422",
                    "mac": "98:BE:A4:EE:25:02",
                    "ip": "10.121.0.101",
                    "channel": "2",
                    "description": "устройство для откладки #2",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "424",
                    "mac": "98:BE:A4:EE:25:04",
                    "ip": "10.121.0.101",
                    "channel": "4",
                    "description": "устройство для откладки #4",
                    "room_id": "3",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "107",
                    "name": "группа для отладки#1",
                    "last_command": null
                }
            ]
        },
        {
            "id": "32",
            "name": "test#2",
            "state": "ACTIVE",
            "command": "up",
            "period_type": "WEEKLY",
            "stamps": "MONDAY",
            "time": "23:59:00",
            "devices": [
                {
                    "id": "422",
                    "mac": "98:BE:A4:EE:25:02",
                    "ip": "10.121.0.101",
                    "channel": "2",
                    "description": "устройство для откладки #2",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "424",
                    "mac": "98:BE:A4:EE:25:04",
                    "ip": "10.121.0.101",
                    "channel": "4",
                    "description": "устройство для откладки #4",
                    "room_id": "3",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "107",
                    "name": "группа для отладки#1",
                    "last_command": null
                }
            ]
        }
    ]
}',
        ),
    ),
    'plate\\V1\\Rpc\\ScheduledTasks\\Controller' => array(
        'description' => 'Сервис для специальных действий с назначенными заданиями: включение/отключение задания, включение/отключение дней в еженедельных заданиях, изменение времени срабатывания. Также возможно получение списка всех назначенных заданий  в rpc-формате.',
        'POST' => array(
            'description' => 'Действия выполняются POST-запросом.
Обязательные поля:

action - тип действия: 
    turn_scheduled - включение/выключение задания; требует дополнительных параметров: turn=on/off;scheduled_task_id - id задания, к которому нужно применить действие; 

    change_time - изменить время срабатывания; требует дополнительных параметров: new_time в формате hh:mm, например, 15:45 - новое время срабатывания; time в формате hh:mm, например, 15:45 - текущее время срабатывания; weekday - день недели; scheduled_task_id - id задания, к которому нужно применить действие; 
 
    change_week_days - на данный момент недоступен, ждем когда появится UI...

    get_scheduled_tasks - получить все назначенные задания;

    get_weekly_scheduled_task - получить одно назначенное задание; требует дополнительного параметра - scheduled_task_id - id задания, к которому нужно применить действие; 

create_scheduled - создать еженедельное назначенное задание. Пример:
[
    \'name\' => \'test case scheduler\',
    \'devices\' => [3, 14, 22],
    \'groups\' => [2,3,4],
    \'week_scheduling\' => [
        [
            \'weekday\' => \'MONDAY\',
            \'time\' => \'11:21:12\',
            \'command\' => \'up\'
        ],
        [
            \'weekday\' => \'TUESDAY\',
            \'time\' => \'21:00:00\',
            \'command\' => \'down\'
        ],
        (...)
    ]
]',
            'request' => '{
	"action" : "change_time",
	"scheduled_task_id" : 30,
	"time" : "17:10",
        "weekday" : "SUNDAY",
        "new_time": "19:30"
}

{
	"action" : "turn_scheduled",
	"scheduled_task_id" : 30,
	"turn" : "on"
}

{

}',
        ),
        'GET' => array(
            'description' => 'GET запрос позволяет получить список всех назначенных заданий в простом rpc формате (без постраничного вывода и embedded). Требует передачи get параметра action=get_scheduled_tasks. Также можно передать параметр room_id для получения списка заданий по id комнаты.',
            'response' => '[
    {
        "id": "2",
        "name": "задача#1",
        "state": "ACTIVE",
        "command": "up",
        "period_type": "WEEKLY",
        "stamps": "f,f1",
        "time": null,
        "devices": [
            {
                "id": "3",
                "mac": "60:A4:4C:32:11:C3",
                "ip": "192.168.10.102",
                "channel": "1",
                "description": "dev01 on 102",
                "room_id": "2",
                "type": "1",
                "max_amp": "170",
                "connection_type": "1",
                "last_command": null
            },
            {
                "id": "423",
                "mac": "98:BE:A4:EE:25:03",
                "ip": "10.121.0.101",
                "channel": "3",
                "description": "устройство для откладки #3",
                "room_id": "1",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            },
            {
                "id": "425",
                "mac": "98:BE:A4:EE:25:05",
                "ip": "10.121.0.101",
                "channel": "5",
                "description": "устройство для откладки #5",
                "room_id": "1",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            }
        ],
        "groups": [
            {
                "id": "108",
                "name": "группа для отладки #2",
                "last_command": null
            },
            {
                "id": "119",
                "name": "всякие девайсы",
                "last_command": null
            },
            {
                "id": "2",
                "name": "мои шторы",
                "last_command": null
            }
        ]
    },
    {
        "id": "3",
        "name": "задача#9.1",
        "state": "ACTIVE",
        "command": "up",
        "period_type": "WEEKLY",
        "stamps": null,
        "time": null,
        "devices": [
            {
                "id": "6",
                "mac": "B8:27:EB:F0:B5:D4",
                "ip": "192.168.10.103",
                "channel": "2",
                "description": "dev02 on 103 ",
                "room_id": "1",
                "type": "1",
                "max_amp": "350",
                "connection_type": "1",
                "last_command": null
            }
        ]
    },
    {
        "id": "22",
        "name": "test#1",
        "state": "ACTIVE",
        "command": "up",
        "period_type": "WEEKLY",
        "stamps": null,
        "time": null,
        "devices": [
            {
                "id": "422",
                "mac": "98:BE:A4:EE:25:02",
                "ip": "10.121.0.101",
                "channel": "2",
                "description": "устройство для откладки #2",
                "room_id": "2",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            },
            {
                "id": "424",
                "mac": "98:BE:A4:EE:25:04",
                "ip": "10.121.0.101",
                "channel": "4",
                "description": "устройство для откладки #4",
                "room_id": "3",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            }
        ],
        "groups": [
            {
                "id": "108",
                "name": "группа для отладки #2",
                "last_command": null
            },
            {
                "id": "107",
                "name": "группа для отладки#1",
                "last_command": null
            }
        ]
    },
    {
        "id": "23",
        "name": "test#1",
        "state": "ACTIVE",
        "command": "up",
        "period_type": "WEEKLY",
        "stamps": null,
        "time": null,
        "devices": [
            {
                "id": "422",
                "mac": "98:BE:A4:EE:25:02",
                "ip": "10.121.0.101",
                "channel": "2",
                "description": "устройство для откладки #2",
                "room_id": "2",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            },
            {
                "id": "424",
                "mac": "98:BE:A4:EE:25:04",
                "ip": "10.121.0.101",
                "channel": "4",
                "description": "устройство для откладки #4",
                "room_id": "3",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            }
        ],
        "groups": [
            {
                "id": "108",
                "name": "группа для отладки #2",
                "last_command": null
            },
            {
                "id": "107",
                "name": "группа для отладки#1",
                "last_command": null
            }
        ]
    },
    {
        "id": "24",
        "name": "test#1",
        "state": "ACTIVE",
        "command": "up",
        "period_type": "WEEKLY",
        "stamps": null,
        "time": null,
        "devices": [
            {
                "id": "422",
                "mac": "98:BE:A4:EE:25:02",
                "ip": "10.121.0.101",
                "channel": "2",
                "description": "устройство для откладки #2",
                "room_id": "2",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            },
            {
                "id": "424",
                "mac": "98:BE:A4:EE:25:04",
                "ip": "10.121.0.101",
                "channel": "4",
                "description": "устройство для откладки #4",
                "room_id": "3",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            }
        ],
        "groups": [
            {
                "id": "108",
                "name": "группа для отладки #2",
                "last_command": null
            },
            {
                "id": "107",
                "name": "группа для отладки#1",
                "last_command": null
            }
        ]
    },
    {
        "id": "25",
        "name": "test#1",
        "state": "ACTIVE",
        "command": "up",
        "period_type": "WEEKLY",
        "stamps": null,
        "time": null,
        "devices": [
            {
                "id": "422",
                "mac": "98:BE:A4:EE:25:02",
                "ip": "10.121.0.101",
                "channel": "2",
                "description": "устройство для откладки #2",
                "room_id": "2",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            },
            {
                "id": "424",
                "mac": "98:BE:A4:EE:25:04",
                "ip": "10.121.0.101",
                "channel": "4",
                "description": "устройство для откладки #4",
                "room_id": "3",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            }
        ],
        "groups": [
            {
                "id": "108",
                "name": "группа для отладки #2",
                "last_command": null
            },
            {
                "id": "107",
                "name": "группа для отладки#1",
                "last_command": null
            }
        ]
    },
    {
        "id": "26",
        "name": "test#1",
        "state": "ACTIVE",
        "command": "up",
        "period_type": "WEEKLY",
        "stamps": null,
        "time": null,
        "devices": [
            {
                "id": "422",
                "mac": "98:BE:A4:EE:25:02",
                "ip": "10.121.0.101",
                "channel": "2",
                "description": "устройство для откладки #2",
                "room_id": "2",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            },
            {
                "id": "424",
                "mac": "98:BE:A4:EE:25:04",
                "ip": "10.121.0.101",
                "channel": "4",
                "description": "устройство для откладки #4",
                "room_id": "3",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            }
        ],
        "groups": [
            {
                "id": "108",
                "name": "группа для отладки #2",
                "last_command": null
            },
            {
                "id": "107",
                "name": "группа для отладки#1",
                "last_command": null
            }
        ]
    },
    {
        "id": "27",
        "name": "test#1",
        "state": "ACTIVE",
        "command": "up",
        "period_type": "WEEKLY",
        "stamps": null,
        "time": null,
        "devices": [
            {
                "id": "422",
                "mac": "98:BE:A4:EE:25:02",
                "ip": "10.121.0.101",
                "channel": "2",
                "description": "устройство для откладки #2",
                "room_id": "2",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            },
            {
                "id": "424",
                "mac": "98:BE:A4:EE:25:04",
                "ip": "10.121.0.101",
                "channel": "4",
                "description": "устройство для откладки #4",
                "room_id": "3",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            }
        ],
        "groups": [
            {
                "id": "108",
                "name": "группа для отладки #2",
                "last_command": null
            },
            {
                "id": "107",
                "name": "группа для отладки#1",
                "last_command": null
            }
        ]
    },
    {
        "id": "28",
        "name": "test#1",
        "state": "ACTIVE",
        "command": "up",
        "period_type": "WEEKLY",
        "stamps": null,
        "time": null,
        "devices": [
            {
                "id": "422",
                "mac": "98:BE:A4:EE:25:02",
                "ip": "10.121.0.101",
                "channel": "2",
                "description": "устройство для откладки #2",
                "room_id": "2",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            },
            {
                "id": "424",
                "mac": "98:BE:A4:EE:25:04",
                "ip": "10.121.0.101",
                "channel": "4",
                "description": "устройство для откладки #4",
                "room_id": "3",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            }
        ],
        "groups": [
            {
                "id": "108",
                "name": "группа для отладки #2",
                "last_command": null
            },
            {
                "id": "107",
                "name": "группа для отладки#1",
                "last_command": null
            }
        ]
    },
    {
        "id": "29",
        "name": "test#1",
        "state": "ACTIVE",
        "command": "up",
        "period_type": "WEEKLY",
        "stamps": null,
        "time": null,
        "devices": [
            {
                "id": "422",
                "mac": "98:BE:A4:EE:25:02",
                "ip": "10.121.0.101",
                "channel": "2",
                "description": "устройство для откладки #2",
                "room_id": "2",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            },
            {
                "id": "424",
                "mac": "98:BE:A4:EE:25:04",
                "ip": "10.121.0.101",
                "channel": "4",
                "description": "устройство для откладки #4",
                "room_id": "3",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            }
        ],
        "groups": [
            {
                "id": "108",
                "name": "группа для отладки #2",
                "last_command": null
            },
            {
                "id": "107",
                "name": "группа для отладки#1",
                "last_command": null
            }
        ]
    },
    {
        "id": "30",
        "name": "test#1",
        "state": "ACTIVE",
        "command": "up",
        "period_type": "WEEKLY",
        "stamps": "TUESDAY",
        "time": "17:10:00",
        "devices": [
            {
                "id": "422",
                "mac": "98:BE:A4:EE:25:02",
                "ip": "10.121.0.101",
                "channel": "2",
                "description": "устройство для откладки #2",
                "room_id": "2",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            },
            {
                "id": "424",
                "mac": "98:BE:A4:EE:25:04",
                "ip": "10.121.0.101",
                "channel": "4",
                "description": "устройство для откладки #4",
                "room_id": "3",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            }
        ],
        "groups": [
            {
                "id": "108",
                "name": "группа для отладки #2",
                "last_command": null
            },
            {
                "id": "107",
                "name": "группа для отладки#1",
                "last_command": null
            }
        ]
    },
    {
        "id": "31",
        "name": "test#1",
        "state": "ACTIVE",
        "command": "up",
        "period_type": "WEEKLY",
        "stamps": "MONDAY",
        "time": null,
        "devices": [
            {
                "id": "422",
                "mac": "98:BE:A4:EE:25:02",
                "ip": "10.121.0.101",
                "channel": "2",
                "description": "устройство для откладки #2",
                "room_id": "2",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            },
            {
                "id": "424",
                "mac": "98:BE:A4:EE:25:04",
                "ip": "10.121.0.101",
                "channel": "4",
                "description": "устройство для откладки #4",
                "room_id": "3",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            }
        ],
        "groups": [
            {
                "id": "108",
                "name": "группа для отладки #2",
                "last_command": null
            },
            {
                "id": "107",
                "name": "группа для отладки#1",
                "last_command": null
            }
        ]
    },
    {
        "id": "32",
        "name": "test#2",
        "state": "ACTIVE",
        "command": "up",
        "period_type": "WEEKLY",
        "stamps": "MONDAY",
        "time": "23:59:00",
        "devices": [
            {
                "id": "422",
                "mac": "98:BE:A4:EE:25:02",
                "ip": "10.121.0.101",
                "channel": "2",
                "description": "устройство для откладки #2",
                "room_id": "2",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            },
            {
                "id": "424",
                "mac": "98:BE:A4:EE:25:04",
                "ip": "10.121.0.101",
                "channel": "4",
                "description": "устройство для откладки #4",
                "room_id": "3",
                "type": "1",
                "max_amp": "250",
                "connection_type": "1",
                "last_command": null
            }
        ],
        "groups": [
            {
                "id": "108",
                "name": "группа для отладки #2",
                "last_command": null
            },
            {
                "id": "107",
                "name": "группа для отладки#1",
                "last_command": null
            }
        ]
    }
]',
        ),
    ),
    'plate\\V1\\Rpc\\FavoritesRpc\\Controller' => array(
        'description' => 'Получение всех объектов из избранного',
        'GET' => array(
            'response' => '{
    "devices": [
        {
            "id": "421",
            "mac": "98:BE:A4:EE:25:00",
            "ip": "10.121.0.101",
            "channel": "1",
            "description": "устройство для откладки #1",
            "room_id": "1",
            "type": "1",
            "max_amp": "250",
            "connection_type": "1",
            "last_command": null
        },
        {
            "id": "422",
            "mac": "98:BE:A4:EE:25:02",
            "ip": "10.121.0.101",
            "channel": "2",
            "description": "устройство для откладки #2",
            "room_id": "2",
            "type": "1",
            "max_amp": "250",
            "connection_type": "1",
            "last_command": null
        },
        {
            "id": "423",
            "mac": "98:BE:A4:EE:25:03",
            "ip": "10.121.0.101",
            "channel": "3",
            "description": "устройство для откладки #3",
            "room_id": "1",
            "type": "1",
            "max_amp": "250",
            "connection_type": "1",
            "last_command": null
        }
    ],
    "groups": [
        {
            "id": "107",
            "name": "группа для отладки#1",
            "last_command": null
        }
    ],
    "scheduled_tasks": [
        {
            "stamps": "f,f1",
            "id": "2",
            "state": "ACTIVE",
            "command": "up",
            "name": "задача#1",
            "time": null,
            "devices": [
                {
                    "id": "3",
                    "mac": "60:A4:4C:32:11:C3",
                    "ip": "192.168.10.102",
                    "channel": "1",
                    "description": "dev01 on 102",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "170",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "423",
                    "mac": "98:BE:A4:EE:25:03",
                    "ip": "10.121.0.101",
                    "channel": "3",
                    "description": "устройство для откладки #3",
                    "room_id": "1",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "425",
                    "mac": "98:BE:A4:EE:25:05",
                    "ip": "10.121.0.101",
                    "channel": "5",
                    "description": "устройство для откладки #5",
                    "room_id": "1",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "119",
                    "name": "всякие девайсы",
                    "last_command": null
                },
                {
                    "id": "2",
                    "name": "мои шторы",
                    "last_command": null
                }
            ]
        },
        {
            "stamps": "TUESDAY",
            "id": "30",
            "state": "ACTIVE",
            "command": "up",
            "name": "test#1",
            "time": "17:10:00",
            "devices": [
                {
                    "id": "422",
                    "mac": "98:BE:A4:EE:25:02",
                    "ip": "10.121.0.101",
                    "channel": "2",
                    "description": "устройство для откладки #2",
                    "room_id": "2",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                },
                {
                    "id": "424",
                    "mac": "98:BE:A4:EE:25:04",
                    "ip": "10.121.0.101",
                    "channel": "4",
                    "description": "устройство для откладки #4",
                    "room_id": "3",
                    "type": "1",
                    "max_amp": "250",
                    "connection_type": "1",
                    "last_command": null
                }
            ],
            "groups": [
                {
                    "id": "108",
                    "name": "группа для отладки #2",
                    "last_command": null
                },
                {
                    "id": "107",
                    "name": "группа для отладки#1",
                    "last_command": null
                }
            ]
        }
    ]
}',
            'description' => 'Для получения всех объектов из избранного нужно выполнить запрос GET /favorites_rpc
Результатом будет json объект с 3 полями в корне: devices, groups, scheduled_tasks со списками, соответственно, устройств, групп, назначенных заданий. Каждое назначенное задание, в свою очередь, также имеет поля  devices и groups, в которых лежат списки устройств и групп, которые включены в данное задание.',
        ),
        'POST' => array(
            'description' => 'Добавление в избранное и удаление из избранного',
            'request' => 'Добавление:
{
	"action" : "add",
	"entity_type" : "DEVICE",
	"entity_id" : 424
}

Удаление
{
	"action" : "delete",
	"entity_type" : "DEVICE",
	"entity_id" : 424
}',
        ),
    ),
);
