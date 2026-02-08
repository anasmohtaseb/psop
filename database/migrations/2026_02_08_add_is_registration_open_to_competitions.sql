-- Add is_registration_open column to competitions table
-- Migration: 2026_02_08_add_is_registration_open_to_competitions

USE psop_db;

ALTER TABLE competitions
ADD COLUMN is_registration_open TINYINT(1) DEFAULT 1 AFTER is_active;

-- Update existing records to have registration open by default
UPDATE competitions SET is_registration_open = 1;
