
-- --------------------------------------------------------

--
-- Структура таблицы `devices_acl`
--

CREATE TABLE `devices_acl` (
  `id` int(11) NOT NULL,
  `grp_id` int(11) DEFAULT NULL,
  `client_id` varchar(255) NOT NULL,
  `device_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
