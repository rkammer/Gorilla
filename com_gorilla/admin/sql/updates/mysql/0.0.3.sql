	-- -----------------------------------------------------
	-- Table `#__gorilla_notebooks`
	-- -----------------------------------------------------
    ALTER TABLE`#__gorilla_notebooks` ADD COLUMN `asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `id`;
