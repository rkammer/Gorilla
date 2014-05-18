	-- -----------------------------------------------------
	-- Adds max file size and dropped dir config
	-- -----------------------------------------------------
	INSERT INTO `#__gorilla_config`
	(`key`, `value`)
	SELECT 'MAX_FILE_SIZE',''
	  FROM dual
	 WHERE not exists (SELECT 1 AS OK
	                     FROM `#__gorilla_config`
	                    WHERE `key` = 'MAX_FILE_SIZE' );
	                    
	INSERT INTO `#__gorilla_config`
	(`key`, `value`)
	SELECT 'DROPPED_DIR',''
	  FROM dual
	 WHERE not exists (SELECT 1 AS OK
	                     FROM `#__gorilla_config`
	                    WHERE `key` = 'DROPPED_DIR' );
	                    
	INSERT INTO `#__gorilla_config`
	(`key`, `value`)
	SELECT 'STORAGE',''
	  FROM dual
	 WHERE not exists (SELECT 1 AS OK
	                     FROM `#__gorilla_config`
	                    WHERE `key` = 'STORAGE' );
	                    
	INSERT INTO `#__gorilla_config`
	(`key`, `value`)
	SELECT 'LOCAL_DIR',''
	  FROM dual
	 WHERE not exists (SELECT 1 AS OK
	                     FROM `#__gorilla_config`
	                    WHERE `key` = 'LOCAL_DIR' );