ALTER TABLE `#__gorilla_notebooks` ADD `guid` VARCHAR(36) NOT NULL;
ALTER TABLE `#__gorilla_documents` ADD `guid` VARCHAR(36) NOT NULL;
ALTER TABLE `#__gorilla_documents` DROP COLUMN `hash`;
