CREATE TABLE IF NOT EXISTS `db_updates` (
  `update_code` varchar(255) NOT NULL,
  UNIQUE KEY `db_upd_code_uniq` (`update_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/**********************************************************************************************************/

/**********************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS update_database_struct$$
CREATE PROCEDURE update_database_struct()
  BEGIN
    set @update = 'update#20180415#8';

    if not exists(select * from `db_updates` where `update_code` = @update)
    then
      INSERT INTO `db_updates`(`update_code`) VALUES (@update);
      ALTER TABLE `scheduled_tasks_timetable` ADD `command` VARCHAR(255) NULL AFTER `name`;
    end if;
    END$$

    DELIMITER ;

CALL update_database_struct();