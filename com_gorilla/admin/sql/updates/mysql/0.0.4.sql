	-- -----------------------------------------------------
	-- Indexes to `#__gorilla_notebooks`
	-- -----------------------------------------------------
    CREATE INDEX `idx_access`  ON `#__gorilla_notebooks` (`access` ASC);
    CREATE INDEX `idx_checkout` ON `#__gorilla_notebooks` (`checked_out` ASC);
    CREATE INDEX `idx_created_by` ON `#__gorilla_notebooks` (`created_by` ASC);
    CREATE INDEX `idx_published` ON `#__gorilla_notebooks` (`published` ASC);	 
    CREATE INDEX `idx_title` ON `#__gorilla_notebooks` (`title` ASC);
	  
	-- -----------------------------------------------------
	-- Indexes to `#__gorilla_config`
	-- -----------------------------------------------------	  
    CREATE INDEX `idx_key` ON `#__gorilla_config` (`key` ASC);
