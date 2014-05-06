--
-- SQL Scripts to be run when components is installed
--

	-- -----------------------------------------------------
	-- Table `#__gorilla_containers`
	-- -----------------------------------------------------
	CREATE TABLE IF NOT EXISTS `#__gorilla_containers` (
	  `id`             		INT              	NOT NULL AUTO_INCREMENT,
	  `title`          		VARCHAR(255)     	NOT NULL,
	  `alias`          		VARCHAR(255)     	NOT NULL,
	  `color_code`     		VARCHAR(7)       	NOT NULL,
	  `description`    		MEDIUMTEXT       	NULL,
	  `published`          	TINYINT(3)       	NOT NULL DEFAULT 0,
	  `access`         		INT(10)          	NOT NULL,
	  `ordering`       		INT(11)          	NOT NULL,
	  `checked_out`      	INT(11) UNSIGNED 	NOT NULL DEFAULT 0,
	  `checked_out_time` 	DATETIME         	NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `metadesc`       		VARCHAR(1024)    	NULL,
	  `metakey`        		VARCHAR(1024)    	NULL,
	  `created`        		DATETIME         	NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `created_by`     		INT(10)          	NOT NULL,
	  `modified`       		DATETIME        	NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `modified_by`    		INT(10)          	NULL,
	  `publish_up`     		DATETIME         	NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `publish_down`   		DATETIME         	NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `asset_id`        	INT(10)          	NOT NULL DEFAULT '0',
	  `guid`                VARCHAR(36)      	NOT NULL,
   	  PRIMARY KEY (`id`),
   	  INDEX `idx_access` (`access` ASC),
	  INDEX `idx_checkout` (`checked_out` ASC),
	  INDEX `idx_created_by` (`created_by` ASC),
	  INDEX `idx_published` (`published` ASC),
	  INDEX `idx_title` (`title` ASC))
	ENGINE = InnoDB;

	-- -----------------------------------------------------
	-- Table `#__gorilla_config`
	-- -----------------------------------------------------
	CREATE TABLE IF NOT EXISTS `#__gorilla_config` (
	  `id`     				INT          		NOT NULL AUTO_INCREMENT,
	  `key`    				VARCHAR(255) 		NOT NULL,
	  `value`  				TEXT         		NOT NULL,
	  PRIMARY KEY (`id`),
	  INDEX `idx_key` (`key` ASC))
	ENGINE = InnoDB;

	-- -----------------------------------------------------
	-- Adds colorcode config - json style
	-- -----------------------------------------------------
	INSERT INTO `#__gorilla_config`
	(`key`, `value`)
	SELECT 'COLOR_CODE_COLORS','[{"name":"Red","color":"#FF8A8A"},{"name":"Orange","color":"#FFC83B"},{"name":"Yellow","color":"#FFF028"},{"name":"Green","color":"#BEF126"},{"name":"Blue","color":"#96D3FF"},{"name":"Purple","color":"#EBB4FF"},{"name":"Gray","color":"#C8C8C8"}]'
	  FROM dual
	 WHERE not exists (SELECT 1 AS OK
	                     FROM `#__gorilla_config`
	                    WHERE `key` = 'COLOR_CODE_COLORS' );

	INSERT INTO `#__gorilla_config`
	(`key`, `value`)
	SELECT 'COLOR_CODE_NEXTCOLOR','0'
	  FROM dual
	 WHERE not exists (SELECT 1 AS OK
	                     FROM `#__gorilla_config`
	                    WHERE `key` = 'COLOR_CODE_NEXTCOLOR' );

	-- -----------------------------------------------------
	-- Table `#__gorilla_documents`
	-- -----------------------------------------------------
	CREATE TABLE IF NOT EXISTS `#__gorilla_documents` (
	  `id` 					INT NOT NULL AUTO_INCREMENT,
	  `title` 				VARCHAR(255) 		NOT NULL,
	  `alias` 				VARCHAR(255) 		NOT NULL,
	  `description` 		MEDIUMTEXT 			NULL,
	  `container_id` 		INT 				NOT NULL,
	  `filename` 			VARCHAR(45) 		NOT NULL,
	  `published` 			TINYINT(3) 			NOT NULL DEFAULT 0,
	  `access` 				INT(10) 			NOT NULL,
	  `ordering` 			INT(11) 		 	NOT NULL,
	  `checked_out` 		INT(11) UNSIGNED 	NOT NULL DEFAULT 0,
	  `checked_out_time` 	DATETIME 			NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `metadesc` 			VARCHAR(1024) 		NULL,
	  `metakey` 			VARCHAR(1024) 		NULL,
	  `created` 			DATETIME 			NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `created_by` 			INT(10) 			NOT NULL,
	  `modified` 			DATETIME 			NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `modified_by` 		INT(10) 			NULL,
	  `publish_up` 			DATETIME 			NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `publish_down` 		DATETIME 			NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `asset_id` 			INT(10) 			NOT NULL DEFAULT '0',
	  `download_count`		INT(5) UNSIGNED		NOT NULL DEFAULT 0,
	  `guid`                VARCHAR(36)      	NOT NULL,
	  `file_name`           VARCHAR(60)         NOT NULL,
	  PRIMARY KEY (`id`),
	  INDEX `idx_access` (`access` ASC),
	  INDEX `idx_checkout` (`checked_out` ASC),
	  INDEX `idx_created_by` (`created_by` ASC),
	  INDEX `idx_published` (`published` ASC),
	  INDEX `idx_title` (`title` ASC),
	  INDEX `fk_documents_containers_idx` (`container_id` ASC),
	  CONSTRAINT `fk_documents_containers`
	    FOREIGN KEY (`container_id`)
	    REFERENCES `#__gorilla_containers` (`id`)
	    ON DELETE NO ACTION
	    ON UPDATE NO ACTION)
	ENGINE = InnoDB;

	-- -----------------------------------------------------
	-- Adds Amazon S3 config
	-- -----------------------------------------------------
	INSERT INTO `#__gorilla_config`
	(`key`, `value`)
	SELECT 'AMAZON_KEY_ID',''
	  FROM dual
	 WHERE not exists (SELECT 1 AS OK
	                     FROM `#__gorilla_config`
	                    WHERE `key` = 'AMAZON_KEY_ID' );

	INSERT INTO `#__gorilla_config`
	(`key`, `value`)
	SELECT 'AMAZON_SECRET_KEY',''
	  FROM dual
	 WHERE not exists (SELECT 1 AS OK
	                     FROM `#__gorilla_config`
	                    WHERE `key` = 'AMAZON_SECRET_KEY' );

	INSERT INTO `#__gorilla_config`
	(`key`, `value`)
	SELECT 'AMAZON_BUCKET',''
	  FROM dual
	 WHERE not exists (SELECT 1 AS OK
	                     FROM `#__gorilla_config`
	                    WHERE `key` = 'AMAZON_BUCKET' );

    -- -----------------------------------------------------
	-- Table `#__gorilla_notes`
	-- -----------------------------------------------------
	CREATE TABLE IF NOT EXISTS `#__gorilla_notes` (
	  `id` 					INT NOT NULL AUTO_INCREMENT,
	  `title` 				VARCHAR(255) 		NOT NULL,
	  `alias` 				VARCHAR(255) 		NOT NULL,
	  `description` 		MEDIUMTEXT 			NULL,
	  `container_id` 		INT 				NOT NULL,
	  `published` 			TINYINT(3) 			NOT NULL DEFAULT 0,
	  `access` 				INT(10) 			NOT NULL,
	  `ordering` 			INT(11) 		 	NOT NULL,
	  `checked_out` 		INT(11) UNSIGNED 	NOT NULL DEFAULT 0,
	  `checked_out_time` 	DATETIME 			NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `metadesc` 			VARCHAR(1024) 		NULL,
	  `metakey` 			VARCHAR(1024) 		NULL,
	  `created` 			DATETIME 			NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `created_by` 			INT(10) 			NOT NULL,
	  `modified` 			DATETIME 			NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `modified_by` 		INT(10) 			NULL,
	  `publish_up` 			DATETIME 			NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `publish_down` 		DATETIME 			NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `asset_id` 			INT(10) 			NOT NULL DEFAULT '0',
	  `guid`                VARCHAR(36)      	NOT NULL,
	  PRIMARY KEY (`id`),
	  INDEX `idx_access` (`access` ASC),
	  INDEX `idx_checkout` (`checked_out` ASC),
	  INDEX `idx_created_by` (`created_by` ASC),
	  INDEX `idx_published` (`published` ASC),
	  INDEX `idx_title` (`title` ASC),
	  INDEX `fk_notes_containers_idx` (`container_id` ASC),
	  CONSTRAINT `fk_notes_containers`
	    FOREIGN KEY (`container_id`)
	    REFERENCES `#__gorilla_containers` (`id`)
	    ON DELETE NO ACTION
	    ON UPDATE NO ACTION)
	ENGINE = InnoDB;