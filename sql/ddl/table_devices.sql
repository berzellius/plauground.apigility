
-- --------------------------------------------------------

--
-- Структура таблицы `devices`
--

CREATE TABLE devices
(
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    mac VARCHAR(40) NOT NULL,
    ip VARCHAR(15) NOT NULL,
    channel INT(11) NOT NULL,
    description VARCHAR(1000) NOT NULL,
    group_id INT(11) NOT NULL,
    room_id INT(11) NOT NULL,
    type INT(11) NOT NULL,
    max_amp FLOAT NOT NULL,
    connection_type INT(11) NOT NULL,
    last_command VARCHAR(100)
);
CREATE UNIQUE INDEX ip_channel ON devices (ip, channel);
