--
-- Base Table
--
CREATE TABLE `book` (
  `Book_ID` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `book`
  ADD PRIMARY KEY (`Book_ID`);

ALTER TABLE `book`
  MODIFY `Book_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Book\\Controller\\BookController', 'Add', '', '', 0),
('edit', 'OnePlace\\Book\\Controller\\BookController', 'Edit', '', '', 0),
('index', 'OnePlace\\Book\\Controller\\BookController', 'Index', 'Books', '/book', 1),
('list', 'OnePlace\\Book\\Controller\\ApiController', 'List', '', '', 1),
('view', 'OnePlace\\Book\\Controller\\BookController', 'View', '', '', 0);

--
-- Form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('book-single', 'Book', 'OnePlace\\Book\\Model\\Book', 'OnePlace\\Book\\Model\\BookTable');

--
-- Index List
--
INSERT INTO `core_index_table` (`table_name`, `form`, `label`) VALUES
('book-index', 'book-single', 'Book Index');

--
-- Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES ('book-base', 'book-single', 'Book', 'Base', 'fas fa-cogs', '', '0', '', '');

--
-- Buttons
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Save Book', 'fas fa-save', 'Save Book', '#', 'primary saveForm', '', 'book-single', 'link', '', ''),
(NULL, 'Edit Book', 'fas fa-edit', 'Edit Book', '/book/edit/##ID##', 'primary', '', 'book-view', 'link', '', ''),
(NULL, 'Add Book', 'fas fa-plus', 'Add Book', '/book/add', 'primary', '', 'book-index', 'link', '', '');

--
-- Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Name', 'label', 'book-base', 'book-single', 'col-md-3', '/book/view/##ID##', '', 0, 1, 0, '', '', '');

--
-- Default Widgets
--
INSERT INTO `core_widget` (`Widget_ID`, `widget_name`, `label`, `permission`) VALUES
(NULL, 'book_dailystats', 'Book - Daily Stats', 'index-Book\\Controller\\BookController');

COMMIT;