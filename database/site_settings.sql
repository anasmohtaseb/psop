-- Site Settings Table
CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type ENUM('text', 'textarea', 'image', 'number', 'boolean') DEFAULT 'text',
    setting_group VARCHAR(50) DEFAULT 'general',
    display_name_ar VARCHAR(255),
    display_order INT DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_group (setting_group),
    INDEX idx_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default settings
INSERT INTO site_settings (setting_key, setting_value, setting_type, setting_group, display_name_ar, display_order) VALUES
('site_name_ar', 'بوابة الأوليمبياد العلمي الفلسطيني', 'text', 'general', 'اسم الموقع (عربي)', 1),
('site_name_en', 'Palestine Science Olympiad Portal', 'text', 'general', 'اسم الموقع (إنجليزي)', 2),
('site_description', 'منصة وطنية موحدة لإدارة مشاركة الطلاب الفلسطينيين في الأوليمبيادات العلمية الدولية', 'textarea', 'general', 'وصف الموقع', 3),
('site_logo', 'assets/images/logo.png', 'image', 'general', 'شعار الموقع', 4),
('site_email', 'info@psop.ps', 'text', 'contact', 'البريد الإلكتروني', 5),
('site_phone', '+970-123-4567', 'text', 'contact', 'رقم الهاتف', 6),
('site_address', 'رام الله، فلسطين', 'text', 'contact', 'العنوان', 7),
('facebook_url', '', 'text', 'social', 'رابط فيسبوك', 8),
('twitter_url', '', 'text', 'social', 'رابط تويتر', 9),
('instagram_url', '', 'text', 'social', 'رابط إنستغرام', 10),
('enable_registration', '1', 'boolean', 'features', 'تفعيل التسجيل', 11),
('maintenance_mode', '0', 'boolean', 'features', 'وضع الصيانة', 12);
