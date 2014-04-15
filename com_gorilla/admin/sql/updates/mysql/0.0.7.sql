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
