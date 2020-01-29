--
-- Alter book tables
--

ALTER TABLE `book` ADD `sub_title` TEXT NOT NULL DEFAULT '' AFTER `label`;
ALTER TABLE `book` ADD `description` TEXT NOT NULL DEFAULT '' AFTER `sub_title`;
ALTER TABLE `book` ADD `author_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `description`;
ALTER TABLE `book` ADD `isbn` TEXT NOT NULL DEFAULT '' AFTER `author_idfs`;
ALTER TABLE `book` ADD `isbn13` TEXT NOT NULL DEFAULT '' AFTER `isbn`;
ALTER TABLE `book` ADD `publisher_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `isbn13`;
ALTER TABLE `book` ADD `date_publish` TEXT NOT NULL DEFAULT '0000-00-00' AFTER `publisher_idfs`;
ALTER TABLE `book` ADD `category_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `date_publish`;
ALTER TABLE `book` ADD `format_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `category_idfs`;
ALTER TABLE `book` ADD `language_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `format_idfs`;
ALTER TABLE `book` ADD `pages` TEXT NOT NULL DEFAULT '' AFTER `language_idfs`;
ALTER TABLE `book` ADD `weight` TEXT NOT NULL DEFAULT '' AFTER `pages`;
ALTER TABLE `book` ADD `dimensions` TEXT NOT NULL DEFAULT '' AFTER `weight`;
ALTER TABLE `book` ADD `featured_image` VARCHAR(255) NOT NULL DEFAULT '' AFTER `dimensions`;

ALTER TABLE `book` ADD `borrower_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `featured_image`;
ALTER TABLE `book` ADD `date_start` TEXT NOT NULL DEFAULT '0000-00-00' AFTER `borrower_idfs`;
ALTER TABLE `book` ADD `date_end` TEXT NOT NULL DEFAULT '0000-00-00' AFTER `date_start`;
ALTER TABLE `book` ADD `state_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `date_end`;

