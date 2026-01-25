-- =========================================
-- Update Site Settings for Subscriptions Feature
-- Palestine Science Olympiad Portal
-- Date: 2025-01-25
-- =========================================

-- Step 1: Change column name from display_name_ar to display_name (if needed)
-- Check if column exists first, then rename
SET @dbname = DATABASE();
SET @tablename = 'site_settings';
SET @oldcolname = 'display_name_ar';
SET @newcolname = 'display_name';

SET @sql = CONCAT('ALTER TABLE ', @tablename, ' CHANGE COLUMN ', @oldcolname, ' ', @newcolname, ' VARCHAR(255)');

-- This will fail silently if column doesn't exist
SET @query = CONCAT('SELECT COUNT(*) INTO @colexists FROM information_schema.columns WHERE table_schema = "', @dbname, '" AND table_name = "', @tablename, '" AND column_name = "', @oldcolname, '"');
PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Only execute if old column exists
SET @query = IF(@colexists > 0, @sql, 'SELECT "Column already renamed" AS message');
PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Step 2: Update all existing settings to English labels
UPDATE site_settings SET display_name = 'Site Name (Arabic)' WHERE setting_key = 'site_name_ar';
UPDATE site_settings SET display_name = 'Site Name (English)' WHERE setting_key = 'site_name_en';
UPDATE site_settings SET display_name = 'Site Description' WHERE setting_key = 'site_description';
UPDATE site_settings SET display_name = 'Site Logo' WHERE setting_key = 'site_logo';
UPDATE site_settings SET display_name = 'Email Address' WHERE setting_key = 'site_email';
UPDATE site_settings SET display_name = 'Phone Number' WHERE setting_key = 'site_phone';
UPDATE site_settings SET display_name = 'Physical Address' WHERE setting_key = 'site_address';
UPDATE site_settings SET display_name = 'Facebook URL' WHERE setting_key = 'facebook_url';
UPDATE site_settings SET display_name = 'Twitter URL' WHERE setting_key = 'twitter_url';
UPDATE site_settings SET display_name = 'Instagram URL' WHERE setting_key = 'instagram_url';
UPDATE site_settings SET display_name = 'Enable Registration' WHERE setting_key = 'enable_registration';
UPDATE site_settings SET display_name = 'Maintenance Mode' WHERE setting_key = 'maintenance_mode';

-- Step 3: Add enable_subscriptions setting if not exists
INSERT INTO site_settings (setting_key, setting_value, setting_type, setting_group, display_name, display_order)
SELECT 'enable_subscriptions', '1', 'boolean', 'features', 'Enable Subscriptions', 13
WHERE NOT EXISTS (
    SELECT 1 FROM site_settings WHERE setting_key = 'enable_subscriptions'
);

-- Step 4: Update enable_subscriptions if it already exists
UPDATE site_settings 
SET display_name = 'Enable Subscriptions', 
    setting_type = 'boolean',
    setting_group = 'features',
    display_order = 13
WHERE setting_key = 'enable_subscriptions';

-- Verify the changes
SELECT setting_key, setting_value, setting_type, display_name 
FROM site_settings 
ORDER BY display_order;
