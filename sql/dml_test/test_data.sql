-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 08 2017 г., 23:27
-- Версия сервера: 5.6.33-0ubuntu0.14.04.1
-- Версия PHP: 5.6.30-10+deb.sury.org~trusty+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `motion_test`
--

--
-- Дамп данных таблицы `devices`
--

INSERT INTO `devices` (`id`, `mac`, `ip`, `channel`, `description`, `group_id`, `room_id`, `type`, `max_amp`, `connection_type`) VALUES
(1, '94:B1:0A:F8:47:B8', '192.168.10.101', 1, 'some dev', 1, 1, 1, 0.25, 1),
(2, 'D0:E7:82:6E:B8:09', '192.168.10.101', 2, 'some other dev', 1, 1, 1, 0.6, 2),
(3, '60:A4:4C:32:11:C3', '192.168.10.102', 1, 'dev01 on 102', 2, 2, 1, 0.17, 1),
(4, 'B8:27:EB:F0:B5:D4', '192.168.10.103', 1, 'dev01 on 103 ', 2, 1, 1, 0.35, 1),
(6, 'B8:27:EB:F0:B5:D4', '192.168.10.103', 2, 'dev02 on 103 ', 2, 1, 1, 0.35, 1);

--
-- Дамп данных таблицы `devices_acl`
--

INSERT INTO `devices_acl` (`id`, `grp_id`, `client_id`, `device_id`) VALUES
(5, 1, 'main_user', NULL),
(6, NULL, 'main_user', 1),
(7, NULL, 'user2', 1),
(8, 1, 'user2', NULL),
(9, NULL, 'user2', 2),
(10, NULL, 'user2', 3),
(11, 2, 'user2', NULL);

--
-- Дамп данных таблицы `floors`
--

INSERT INTO `floors` (`id`, `name`) VALUES
(1, 'Первый этаж'),
(2, 'Второй Этаж'),
(3, 'Третий этаж'),
(4, 'Четвертый этаж');


--
-- Дамп данных таблицы `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `client_id`, `client_secret`, `redirect_uri`, `grant_types`, `scope`, `user_id`) VALUES
(1, 'main_user', '$2y$10$CmDEUdr8vJEdHArgCfva.OCMiJyQll4QxWQZemzSht4Kj/qcxb.re', '/oauth/receivecode', NULL, 'main', ''),
(8, 'user2', '$2y$10$5e4IZzarA62sR91VYDdda.3yUyRWQ001JpEK6Wfu5AXVjCs.b0bdO', '/oauth/receivecode', NULL, NULL, NULL);

--
-- Дамп данных таблицы `rooms`
--

INSERT INTO `rooms` (`id`, `floor_id`, `name`) VALUES
(1, 1, 'Гостиная'),
(2, 1, 'Санузел#1'),
(3, 1, 'Топка'),
(4, 1, 'Кухня'),
(5, 1, 'Столовая'),
(6, 1, 'Веранда'),
(7, 2, 'Спальня#1'),
(8, 2, 'Санузел#2'),
(9, 2, 'Спальня#2'),
(10, 2, 'Коридор'),
(11, 3, 'Спальня#3'),
(12, 3, 'Санузел#3');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
