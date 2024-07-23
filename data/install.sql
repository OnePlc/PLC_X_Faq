--
-- Base Table
--
CREATE TABLE `faq` (
  `Faq_ID` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `faq`
  ADD PRIMARY KEY (`Faq_ID`);

ALTER TABLE `faq`
  MODIFY `Faq_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Faq\\Controller\\FaqController', 'Add', '', '', 0),
('edit', 'OnePlace\\Faq\\Controller\\FaqController', 'Edit', '', '', 0),
('index', 'OnePlace\\Faq\\Controller\\FaqController', 'Index', 'Faqs', '/faq-admin', 1),
('list', 'OnePlace\\Faq\\Controller\\ApiController', 'List', '', '', 1),
('view', 'OnePlace\\Faq\\Controller\\FaqController', 'View', '', '', 0);

--
-- Form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('faq-single', 'Faq', 'OnePlace\\Faq\\Model\\Faq', 'OnePlace\\Faq\\Model\\FaqTable');

--
-- Index List
--
INSERT INTO `core_index_table` (`table_name`, `form`, `label`) VALUES
('faq-index', 'faq-single', 'Faq Index');

--
-- Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES ('faq-base', 'faq-single', 'Faq', 'Base', 'fas fa-cogs', '', '0', '', '');

--
-- Buttons
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Save Faq', 'fas fa-save', 'Save Faq', '#', 'primary saveForm', '', 'faq-single', 'link', '', ''),
(NULL, 'Edit Faq', 'fas fa-edit', 'Edit Faq', '/faq-admin/edit/##ID##', 'primary', '', 'faq-view', 'link', '', ''),
(NULL, 'Add Faq', 'fas fa-plus', 'Add Faq', '/faq-admin/add', 'primary', '', 'faq-index', 'link', '', '');

--
-- Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Frage', 'label', 'faq-base', 'faq-single', 'col-md-3', '/faq-admin/view/##ID##', 0, 1, 0, '', '', '');

COMMIT;