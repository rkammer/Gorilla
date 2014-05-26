ALTER TABLE `#__gorilla_documents` ADD `metadata` TEXT;

UPDATE `#__gorilla_documents`
   SET `metadata` = '{"robots":"","rights":""}'
 WHERE `metadata` IS NULL;

ALTER TABLE `#__gorilla_documents` MODIFY `metadata` TEXT NOT NULL;

ALTER TABLE `#__gorilla_notes` ADD `metadata` TEXT;

UPDATE `#__gorilla_notes`
   SET `metadata` = '{"robots":"","rights":""}'
 WHERE `metadata` IS NULL;

ALTER TABLE `#__gorilla_notes` MODIFY `metadata` TEXT NOT NULL;