-- Make email nullable and add unique constraint to phone
-- Migration: 2026_02_08_make_email_nullable_add_phone_unique

USE psop_db;

-- Make email nullable (remove NOT NULL constraint)
ALTER TABLE users 
MODIFY email VARCHAR(255) NULL;

-- Make phone unique and indexed
ALTER TABLE users 
MODIFY phone VARCHAR(20) NOT NULL UNIQUE,
ADD INDEX idx_phone (phone);

-- Update existing records: ensure phone numbers don't have duplicates
-- If there are duplicates, this will fail and you'll need to clean them manually
