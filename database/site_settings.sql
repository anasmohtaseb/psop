-- Site Settings Table
CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type ENUM('text', 'textarea', 'image', 'number', 'boolean') DEFAULT 'text',
    setting_group VARCHAR(50) DEFAULT 'general',
    display_name VARCHAR(255),
    display_order INT DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_group (setting_group),
    INDEX idx_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default settings
INSERT INTO site_settings (setting_key, setting_value, setting_type, setting_group, display_name, display_order) VALUES
('site_name_ar', 'بوابة الأوليمبياد العلمي الفلسطيني', 'text', 'general', 'Site Name (Arabic)', 1),
('site_name_en', 'Palestine Science Olympiad Portal', 'text', 'general', 'Site Name (English)', 2),
('site_description', 'منصة وطنية موحدة لإدارة مشاركة الطلاب الفلسطينيين في الأوليمبيادات العلمية الدولية', 'textarea', 'general', 'Site Description', 3),
('site_logo', 'assets/images/logo.png', 'image', 'general', 'Site Logo', 4),
('site_email', 'info@psop.ps', 'text', 'contact', 'Email Address', 5),
('site_phone', '+970-123-4567', 'text', 'contact', 'Phone Number', 6),
('site_address', 'رام الله، فلسطين', 'text', 'contact', 'Physical Address', 7),
('facebook_url', '', 'text', 'social', 'Facebook URL', 8),
('twitter_url', '', 'text', 'social', 'Twitter URL', 9),
('instagram_url', '', 'text', 'social', 'Instagram URL', 10),
('enable_registration', '1', 'boolean', 'features', 'Enable Registration', 11),
('maintenance_mode', '0', 'boolean', 'features', 'Maintenance Mode', 12),
('enable_subscriptions', '1', 'boolean', 'features', 'Enable Subscriptions', 13);
