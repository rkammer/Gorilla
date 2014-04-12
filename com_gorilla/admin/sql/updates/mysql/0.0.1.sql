	-- -----------------------------------------------------
	-- Table `#__gorilla_containers`
	-- -----------------------------------------------------
	CREATE TABLE IF NOT EXISTS `#__gorilla_containers` (
	  `id`             	 INT              NOT NULL AUTO_INCREMENT,
      `guid`             VARCHAR(36)      NOT NULL,
	  `title`          	 VARCHAR(255)     NOT NULL,
	  `alias`          	 VARCHAR(255)     NOT NULL,
	  `color_code`     	 VARCHAR(7)       NOT NULL,
	  `description`    	 MEDIUMTEXT       NULL,
	  `published`        TINYINT(3)       NOT NULL DEFAULT 0,
	  `access`         	 INT(10)          NOT NULL,
	  `ordering`       	 INT(11)          NOT NULL,
	  `checked_out`      INT(11) UNSIGNED NOT NULL DEFAULT 0,
	  `checked_out_time` DATETIME         NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `metadesc`       	 VARCHAR(1024)    NULL,
	  `metakey`        	 VARCHAR(1024)    NULL,
	  `created`        	 DATETIME         NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `created_by`     	 INT(10)          NOT NULL,
	  `modified`       	 INT(10)          NULL,
	  `modified_by`    	 INT(10)          NULL,
	  `publish_up`     	 DATETIME         NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `publish_down`   	 DATETIME         NOT NULL DEFAULT '0000-00-00 00:00:00',
	  PRIMARY KEY (`id`))
	ENGINE = InnoDB;
