	-- -----------------------------------------------------
	-- Table `#__gorilla_config`
	-- -----------------------------------------------------
	CREATE TABLE IF NOT EXISTS `#__gorilla_config` (
	  `id`     INT          NOT NULL AUTO_INCREMENT,
	  `key`    VARCHAR(255) NOT NULL,
	  `value`  TEXT         NOT NULL,
	  PRIMARY KEY (`id`))
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
