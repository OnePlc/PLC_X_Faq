--
-- Core Form - Book Base Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'featuredimage', 'Featured Image', 'featured_image', 'book-base', 'book-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''),
(NULL, 'text', 'Subtitle', 'sub_title', 'book-base', 'book-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''),
(NULL, 'textarea', 'Description', 'description', 'book-base', 'book-single', 'col-md-8', '', '', '0', '1', '0', '', '', ''),
(NULL, 'select', 'Author', 'author_idfs', 'book-base', 'book-single', 'col-md-3', '', '/tag/api/list/booksingle_3', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Tag\\Controller\\TagController'),
(NULL, 'select', 'Category', 'category_idfs', 'book-base', 'book-single', 'col-md-3', '', '/tag/api/list/booksingle_1', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Tag\\Controller\\TagController'),
(NULL, 'text', 'ISBN', 'isbn', 'book-base', 'book-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''),
(NULL, 'text', 'ISBN13', 'isbn13', 'book-base', 'book-single', 'col-md-3', '', '', '0', '1', '0', '', '', '');

--
-- Core Form - Book Details Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'select', 'Format', 'format_idfs', 'book-details', 'book-single', 'col-md-3', '', '/tag/api/list/booksingle_5', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Tag\\Controller\\TagController'),
(NULL, 'select', 'Language', 'language_idfs', 'book-details', 'book-single', 'col-md-3', '', '/tag/api/list/booksingle_6', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Tag\\Controller\\TagController'),
(NULL, 'select', 'Publisher', 'publisher_idfs', 'book-details', 'book-single', 'col-md-3', '', '/tag/api/list/booksingle_4', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Tag\\Controller\\TagController'),
(NULL, 'date', 'Publish Date', 'date_publish', 'book-details', 'book-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''),
(NULL, 'text', 'Pages', 'pages', 'book-details', 'book-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''),
(NULL, 'text', 'Weight', 'weight', 'book-details', 'book-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''),
(NULL, 'text', 'Dimensions', 'dimensions', 'book-details', 'book-single', 'col-md-3', '', '', '0', '1', '0', '', '', '');

--
-- Core Form - Book Library Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'select', 'Borrower', 'borrower_idfs', 'book-library', 'book-single', 'col-md-2', '', '/api/user/list', '0', '1', '0', 'user-single', 'OnePlace\\User\\Model\\UserTable','add-OnePlace\\User\\Controller\\UserController'),
(NULL, 'date', 'Start Date', 'date_start', 'book-library', 'book-single', 'col-md-2', '', '', '0', '1', '0', '', '', ''),
(NULL, 'date', 'End Date', 'date_end', 'book-library', 'book-single', 'col-md-2', '', '', '0', '1', '0', '', '', ''),
(NULL, 'select', 'State', 'state_idfs', 'book-library', 'book-single', 'col-md-3', '', '/tag/api/list/booksingle_2', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Tag\\Controller\\TagController');


--
-- book Form Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('book-details', 'book-single', 'Details', 'Infos', 'fas fa-info', '', '1', '', ''),
('book-library', 'book-single', 'Library', 'Lending', 'fas fa-calendar', '', '1', '', '');

--
-- Tags
--
INSERT INTO `core_tag` (`Tag_ID`, `tag_key`, `tag_label`) VALUES
(3, 'author', 'Author'),
(4, 'publisher', 'Publisher'),
(5, 'format', 'Format'),
(6, 'language', 'Language');



