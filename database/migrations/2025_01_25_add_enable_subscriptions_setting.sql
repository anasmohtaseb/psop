-- Add enable_subscriptions setting to site_settings table
-- Run: mysql -u root -p psop_db < database/migrations/2025_01_25_add_enable_subscriptions_setting.sql

-- First update the column name if it exists
ALTER TABLE site_settings CHANGE COLUMN display_name_ar display_name VARCHAR(255);

-- Insert or update the enable_subscriptions setting
INSERT INTO site_settings (setting_key, setting_value, setting_type, setting_group, display_name, display_order)
SELECT 'enable_subscriptions', '1', 'boolean', 'features', 'Enable Subscriptions', 13
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'enable_subscriptions')
ON DUPLICATE KEY UPDATE display_name = 'Enable Subscriptions';
