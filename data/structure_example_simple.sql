--
-- Alter faq tables
--
ALTER TABLE `faq` ADD `description` TEXT NOT NULL DEFAULT '' AFTER `sub_title`;
ALTER TABLE `faq` ADD `author_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `description`;
ALTER TABLE `faq` ADD `date_publish` TEXT NOT NULL DEFAULT '0000-00-00' AFTER `publisher_idfs`;
ALTER TABLE `faq` ADD `featured_image` VARCHAR(255) NOT NULL DEFAULT '' AFTER `dimensions`;

