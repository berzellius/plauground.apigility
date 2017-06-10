<?php

/**
 * Created by PhpStorm.
 * User: berz
 * Date: 04.06.2017
 * Time: 20:02
 */
class TestDatasetsPart1
{
    public static function forFavoritesSet(){
        return [
            \V1Test\Rest\testData\DevicesTestEntity::class =>
                [
                    [
                        "mac" => "98:BE:A4:EE:25:00",
                        "ip" => "10.121.0.101",
                        "channel" => "1",
                        "description" => "устройство для откладки #1",
                        "room_id" => "1",
                        "type" => "1",
                        "max_amp" => "250",
                        "connection_type" => "1"
                    ],
                    [
                        "mac" => "98:BE:A4:EE:25:02",
                        "ip" => "10.121.0.101",
                        "channel" => "2",
                        "description" => "устройство для откладки #2",
                        "room_id" => "1",
                        "type" => "1",
                        "max_amp" => "250",
                        "connection_type" => "1"
                    ],
                    [
                        "mac" => "98:BE:A4:EE:25:03",
                        "ip" => "10.121.0.101",
                        "channel" => "3",
                        "description" => "устройство для откладки #3",
                        "room_id" => "1",
                        "type" => "1",
                        "max_amp" => "250",
                        "connection_type" => "1"
                    ],
                    [
                        "mac" => "98:BE:A4:EE:25:04",
                        "ip" => "10.121.0.101",
                        "channel" => "4",
                        "description" => "устройство для откладки #4",
                        "room_id" => "1",
                        "type" => "1",
                        "max_amp" => "250",
                        "connection_type" => "1"
                    ],
                    [
                        "mac" => "98:BE:A4:EE:25:05",
                        "ip" => "10.121.0.101",
                        "channel" => "5",
                        "description" => "устройство для откладки #5",
                        "room_id" => "1",
                        "type" => "1",
                        "max_amp" => "250",
                        "connection_type" => "1"
                    ],
                ],
            \V1Test\Rest\testData\GroupsTestEntity::class =>
                [
                    ["name" => "группа для отладки#1"],
                    ["name" => "группа для отладки #2"],
                    ["name" => "группа для отладки #3"],
                ]
            ];
    }

    public static function basicSet(){
        return [
            \V1Test\Rest\testData\DevicesTestEntity::class =>
            [
                [
                    "mac" => "94:B1:0A:F8:47:00",
                    "ip" => "10.10.0.101",
                    "channel" => "1",
                    "description" => "тестовое устройство #1",
                    "room_id" => "1",
                    "type" => "1",
                    "max_amp" => "250",
                    "connection_type" => "1"
                ],
                [
                    "mac" => "94:B1:0A:F8:47:01",
                    "ip" => "10.10.0.101",
                    "channel" => "2",
                    "description" => "тестовое устройство #2",
                    "room_id" => "1",
                    "type" => "1",
                    "max_amp" => "250",
                    "connection_type" => "1"
                ],
                [
                    "mac" => "94:B1:0A:F8:47:02",
                    "ip" => "10.10.0.101",
                    "channel" => "3",
                    "description" => "тестовое устройство #3",
                    "room_id" => "1",
                    "type" => "1",
                    "max_amp" => "250",
                    "connection_type" => "1"
                ],
                [
                    "mac" => "94:B1:0A:F8:47:04",
                    "ip" => "10.10.0.101",
                    "channel" => "4",
                    "description" => "тестовое устройство #4",
                    "room_id" => "1",
                    "type" => "1",
                    "max_amp" => "250",
                    "connection_type" => "1"
                ],
                [
                    "mac" => "94:B1:0A:F8:47:05",
                    "ip" => "10.10.0.101",
                    "channel" => "5",
                    "description" => "тестовое устройство #5",
                    "room_id" => "1",
                    "type" => "1",
                    "max_amp" => "250",
                    "connection_type" => "1"
                ],
                [
                    "mac" => "94:B1:0A:F8:47:06",
                    "ip" => "10.10.0.101",
                    "channel" => "6",
                    "description" => "тестовое устройство #6",
                    "room_id" => "1",
                    "type" => "1",
                    "max_amp" => "250",
                    "connection_type" => "1"
                ],
                [
                    "mac" => "94:B1:0A:F8:47:07",
                    "ip" => "10.10.0.101",
                    "channel" => "7",
                    "description" => "тестовое устройство #7",
                    "room_id" => "1",
                    "type" => "1",
                    "max_amp" => "250",
                    "connection_type" => "1"
                ],
                [
                    "mac" => "94:B1:0A:F8:47:08",
                    "ip" => "10.10.0.101",
                    "channel" => "8",
                    "description" => "тестовое устройство #8",
                    "room_id" => "1",
                    "type" => "1",
                    "max_amp" => "250",
                    "connection_type" => "1"
                ],
                [
                    "mac" => "94:B1:0A:F8:47:09",
                    "ip" => "10.10.0.101",
                    "channel" => "9",
                    "description" => "тестовое устройство #9",
                    "room_id" => "1",
                    "type" => "1",
                    "max_amp" => "250",
                    "connection_type" => "1"
                ],
                [
                    "mac" => "94:B1:0A:F8:47:10",
                    "ip" => "10.10.0.101",
                    "channel" => "10",
                    "description" => "тестовое устройство #10",
                    "room_id" => "1",
                    "type" => "1",
                    "max_amp" => "250",
                    "connection_type" => "1"
                ],
                [
                    "mac" => "94:B1:0A:F8:47:11",
                    "ip" => "10.10.0.101",
                    "channel" => "11",
                    "description" => "тестовое устройство #11",
                    "room_id" => "1",
                    "type" => "1",
                    "max_amp" => "250",
                    "connection_type" => "1"
                ],
                [
                    "mac" => "94:B1:0A:F8:47:12",
                    "ip" => "10.10.0.101",
                    "channel" => "12",
                    "description" => "тестовое устройство #12",
                    "room_id" => "1",
                    "type" => "1",
                    "max_amp" => "250",
                    "connection_type" => "1"
                ],
            ],
            \V1Test\Rest\testData\GroupsTestEntity::class => [
                ["name" => "тестовая группа #1"],
                ["name" => "тестовая группа #2"],
                ["name" => "тестовая группа #3"],
            ],
        ];
    }
}