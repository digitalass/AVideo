ALTER TABLE `scheduler_commands`
ADD IF NOT EXISTS `type` VARCHAR(45) DEFAULT NULL;