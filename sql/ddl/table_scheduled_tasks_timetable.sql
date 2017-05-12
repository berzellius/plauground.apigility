-- --------------------------------------------------------

--
-- Структура таблицы `scheduled_tasks_timetable`
--

CREATE TABLE `scheduled_tasks_timetable` (
  `id` int(11) NOT NULL,
  `begin_dtm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `repeat_period` int(11) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `next_dtm` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `special_stamp` varchar(100) DEFAULT NULL,
  `scheduling_task_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Индексы таблицы `scheduled_tasks_timetable`
--
ALTER TABLE `scheduled_tasks_timetable`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schtasks_timetable_task_id_spec_stamp_uindex` (`scheduling_task_id`,`special_stamp`);
  
--
-- AUTO_INCREMENT для таблицы `scheduled_tasks_timetable`
--
ALTER TABLE `scheduled_tasks_timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
