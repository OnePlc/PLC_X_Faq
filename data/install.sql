--
-- Base Table
--
CREATE TABLE `blog` (
  `Blog_ID` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `blog`
  ADD PRIMARY KEY (`Blog_ID`);

ALTER TABLE `blog`
  MODIFY `Blog_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Blog\\Controller\\BlogController', 'Add', '', '', 0),
('edit', 'OnePlace\\Blog\\Controller\\BlogController', 'Edit', '', '', 0),
('index', 'OnePlace\\Blog\\Controller\\BlogController', 'Index', 'Blogs', '/blog', 1),
('list', 'OnePlace\\Blog\\Controller\\ApiController', 'List', '', '', 1),
('view', 'OnePlace\\Blog\\Controller\\BlogController', 'View', '', '', 0);

--
-- Form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('blog-single', 'Blog', 'OnePlace\\Blog\\Model\\Blog', 'OnePlace\\Blog\\Model\\BlogTable');

--
-- Index List
--
INSERT INTO `core_index_table` (`table_name`, `form`, `label`) VALUES
('blog-index', 'blog-single', 'Blog Index');

--
-- Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES ('blog-base', 'blog-single', 'Blog', 'Base', 'fas fa-cogs', '', '0', '', '');

--
-- Buttons
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Save Blog', 'fas fa-save', 'Save Blog', '#', 'primary saveForm', '', 'blog-single', 'link', '', ''),
(NULL, 'Edit Blog', 'fas fa-edit', 'Edit Blog', '/blog/edit/##ID##', 'primary', '', 'blog-view', 'link', '', ''),
(NULL, 'Add Blog', 'fas fa-plus', 'Add Blog', '/blog/add', 'primary', '', 'blog-index', 'link', '', '');

--
-- Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Name', 'label', 'blog-base', 'blog-single', 'col-md-3', '/blog/view/##ID##', '', 0, 1, 0, '', '', '');

COMMIT;