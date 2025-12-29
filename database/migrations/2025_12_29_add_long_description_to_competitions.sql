-- Add long_description fields to competitions table for WYSIWYG content
ALTER TABLE competitions 
  ADD COLUMN long_description_ar MEDIUMTEXT AFTER description_ar,
  ADD COLUMN long_description_en MEDIUMTEXT AFTER description_en;