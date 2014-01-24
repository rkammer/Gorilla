--
-- SQL Scripts to be run when components is installed
--

	-- -----------------------------------------------------
	-- Table `#__gorilla_notebooks`
	-- -----------------------------------------------------
	CREATE TABLE IF NOT EXISTS `#__gorilla_notebooks` (
	  `id`             	INT              NOT NULL AUTO_INCREMENT,
	  `title`          	VARCHAR(255)     NOT NULL,
	  `alias`          	VARCHAR(255)     NOT NULL,
	  `color_code`     	INT(6)           NOT NULL,
	  `description`    	MEDIUMTEXT       NULL,
	  `published`          	TINYINT(3)       NOT NULL DEFAULT 0,
	  `access`         	INT(10)          NOT NULL,
	  `ordering`       	INT(11)          NOT NULL,
	  `checked_out`      	INT(11) UNSIGNED NOT NULL DEFAULT 0,
	  `checked_out_time` 	DATETIME         NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `metadesc`       	VARCHAR(1024)    NULL,
	  `metakey`        	VARCHAR(1024)    NULL,
	  `created`        	DATETIME         NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `created_by`     	INT(10)          NOT NULL,
	  `modified`       	INT(10)          NULL,
	  `modified_by`    	INT(10)          NULL,
	  `publish_up`     	DATETIME         NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `publish_down`   	DATETIME         NOT NULL DEFAULT '0000-00-00 00:00:00',
   	  PRIMARY KEY (`id`))
	ENGINE = InnoDB;
