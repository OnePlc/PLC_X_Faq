# Dynamic Fields

Now that you have basic knowledge of onePlace Modules, and how they are structured,
we'll show you the easy way to add new fields to your modules.

## Add new field to database

The easiest way to add a new field is to add it to an existing tab within an existing
form. All you have to do, is to add it to the database. onePlace will take care of the rest,
to attach it to your Entity Model, have Getters and Setters, add corresponding HTML Element to
Forms, and display on Index Tables if wanted. 

No single line of code is needed for this.

The easiest type of field is a text field as shown below

```sql
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`) VALUES (NULL, 'text', 'Label', 'label', 'module-base', 'module-single', 'col-md-3', '/module/view/##ID##', '', '0'); 
```

## Dynamic Field Types

### Text
```sql
ALTER TABLE `faq` ADD `name` TEXT NOT NULL DEFAULT '' AFTER `label`; 
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES 
(NULL, 'text', 'Name', 'name', 'faq-base', 'faq-single', 'col-md-12', '', '', '0', '1', '0', '', '', ''); 
```

### Textarea
```sql
ALTER TABLE `faq` ADD `description` TEXT NOT NULL DEFAULT '' AFTER `label`; 
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES 
(NULL, 'textarea', 'Description', 'description', 'faq-base', 'faq-single', 'col-md-12', '', '', '0', '1', '0', '', '', ''); 
```

### Date 
```sql
ALTER TABLE `faq` ADD `date_received` TEXT NOT NULL DEFAULT '0000-00-00' AFTER `label`; 
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES 
(NULL, 'text', 'Date received', 'date_received', 'faq-base', 'faq-single', 'col-md-12', '', '', '0', '1', '0', '', '', ''); 
```

### Datetime
```sql
ALTER TABLE `faq` ADD `datetime_received` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `modified_date`; 
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES 
(NULL, 'datetime', 'Datetime received', 'datetime_received', 'faq-base', 'faq-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''); 
```

### Time
```sql
ALTER TABLE `faq` ADD `time_received` DATETIME NOT NULL DEFAULT '00:00:00' AFTER `modified_date`; 
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES 
(NULL, 'time', 'Time received', 'time_received', 'faq-base', 'faq-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''); 
```

### Tel
```sql
ALTER TABLE `faq` ADD `phone` DATETIME NOT NULL DEFAULT '' AFTER `modified_date`; 
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES 
(NULL, 'tel', 'Phone', 'phone', 'faq-base', 'faq-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''); 
```

### E-Mail
```sql
ALTER TABLE `faq` ADD `email_addr` DATETIME NOT NULL DEFAULT '' AFTER `modified_date`; 
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES 
(NULL, 'email', 'E-Mail', 'email_addr', 'faq-base', 'faq-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''); 
```

### Currency
```sql
ALTER TABLE `faq` ADD `currency` TEXT NOT NULL DEFAULT '' AFTER `label`; 
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES 
(NULL, 'currency', 'Currency', 'currency', 'faq-base', 'faq-single', 'col-md-12', '', '', '0', '1', '0', '', '', ''); 
```

### Select
#### Based on onePlace Tag Module 
```sql
ALTER TABLE `faq` ADD `testtag_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `Faq_ID`; 
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'select', 'Test Tag', 'testtag_idfs', 'faq-base', 'faq-single', 'col-md-3', '', '/tag/api/list/faq-single_1', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Tag\\Controller\\TagController');
```
#### Based on onePlace Contact
```sql
ALTER TABLE `faq` ADD `manufacturer_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `Faq_ID`; 
(NULL, 'select', 'Owner', 'manufacturer_idfs', 'faqrequest-base', 'faqrequest-single', 'col-md-2', '', '/api/contact/list', '0', '1', '0', 'contact-single', 'OnePlace\\Contact\\Model\\ContactTable','add-OnePlace\\Contact\\Controller\\ContactController'),
```
#### Custom Data source

### Multiselect 
#### Based on onePlace Tag Module 
```sql
ALTER TABLE `faq` ADD `testtag_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `Faq_ID`; 
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'multiselect', 'Test Tag', 'testtag_idfs', 'faq-base', 'faq-single', 'col-md-3', '', '/tag/api/list/faq-single_1', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Tag\\Controller\\TagController');
```
### Partial

With partials, you can load sub templates with all data from the current view.
```sql
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES 
(NULL, 'partial', 'My Partial', 'mypartial', 'faq-base', 'faq-single', 'col-md-12', '', '', '0', '1', '0', '', '', ''); 
```


### Featured Image
```sql
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES 
(NULL, 'featuredimage', 'Featured Image', 'featured_image', 'faq-base', 'faq-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''); 
```

## After SQL installation of field
![Add Field Permissions](https://docs.1plc.ch/img/addfieldpermission.png)

Then go to user manager - select user, edit, and add the new fields so you can see/edit them
You can also add to index column if you like.

Have fun