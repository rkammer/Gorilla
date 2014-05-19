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