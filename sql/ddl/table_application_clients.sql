-- --------------------------------------------------------

--
-- Структура таблицы `application_clients`
--

CREATE TABLE `application_clients` (
  `id` int(11) NOT NULL,
  `mac` varchar(40) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы таблицы `application_clients`
--
ALTER TABLE `application_clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `application_clients_mac_uindex` (`mac`),
  ADD UNIQUE KEY `application_clients_ip_uindex` (`ip`),
  ADD UNIQUE KEY `application_clients_hostname_uindex` (`hostname`);

--
-- AUTO_INCREMENT для таблицы `application_clients`
--
ALTER TABLE `application_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
