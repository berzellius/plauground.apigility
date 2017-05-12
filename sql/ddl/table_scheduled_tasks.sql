-- --------------------------------------------------------

--
-- Структура таблицы `scheduled_tasks`
--

CREATE TABLE `scheduled_tasks` (
  `id` int(11) NOT NULL,
  `state` varchar(20) DEFAULT NULL,
  `id_device` int(11) DEFAULT NULL,
  `id_group` int(11) DEFAULT NULL,
  `grp_dev_type` varchar(20) NOT NULL,
  `period_type` varchar(20) NOT NULL,
  `command` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы таблицы `scheduled_tasks`
--
ALTER TABLE `scheduled_tasks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для таблицы `scheduled_tasks`
--
ALTER TABLE `scheduled_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
