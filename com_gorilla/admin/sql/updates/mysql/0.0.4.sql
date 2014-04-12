	-- -----------------------------------------------------
	-- Indexes to `#__gorilla_containers`
	-- -----------------------------------------------------
    CREATE INDEX `idx_access`     ON `#__gorilla_containers` (`access` ASC);
    CREATE INDEX `idx_checkout`   ON `#__gorilla_containers` (`checked_out` ASC);
    CREATE INDEX `idx_created_by` ON `#__gorilla_containers` (`created_by` ASC);
    CREATE INDEX `idx_published`  ON `#__gorilla_containers` (`published` ASC);
    CREATE INDEX `idx_title`      ON `#__gorilla_containers` (`title` ASC);

	-- -----------------------------------------------------
	-- Indexes to `#__gorilla_config`
	-- -----------------------------------------------------
    CREATE INDEX `idx_key` ON `#__gorilla_config` (`key` ASC);
