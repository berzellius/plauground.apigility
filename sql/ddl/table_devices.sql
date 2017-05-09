
-- --------------------------------------------------------

--
-- Структура таблицы `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `mac` varchar(40) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `channel` int(11) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `group_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `max_amp` float NOT NULL,
  `connection_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
