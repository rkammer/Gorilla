	-- -----------------------------------------------------
	-- Table `#__gorilla_documents`
	-- -----------------------------------------------------
	CREATE TABLE IF NOT EXISTS `#__gorilla_documents` (
	  `id` 					INT NOT NULL AUTO_INCREMENT,
	  `title` 				VARCHAR(255) 		NOT NULL,
	  `alias` 				VARCHAR(255) 		NOT NULL,
	  `description` 		MEDIUMTEXT 			NULL,
	  `container_id` 		INT 				NOT NULL,
	  `hash` 				VARCHAR(45) 		NOT NULL,
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
