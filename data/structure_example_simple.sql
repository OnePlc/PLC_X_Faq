--
-- Alter blog tables
--
ALTER TABLE `blog` ADD `description` TEXT NOT NULL DEFAULT '' AFTER `sub_title`;
ALTER TABLE `blog` ADD `author_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `description`;
ALTER TABLE `blog` ADD `date_publish` TEXT NOT NULL DEFAULT '0000-00-00' AFTER `publisher_idfs`;
ALTER TABLE `blog` ADD `featured_image` VARCHAR(255) NOT NULL DEFAULT '' AFTER `dimensions`;

