-- Hero Slider Table
CREATE TABLE IF NOT EXISTS hero_slides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title_ar VARCHAR(255) NOT NULL,
    description_ar TEXT,
    image_path VARCHAR(500) NOT NULL,
    slide_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_order (slide_order),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default slides
INSERT INTO hero_slides (title_ar, description_ar, image_path, slide_order, is_active) VALUES
('طلاب فلسطينيون يتألقون في الأوليمبياد الدولي', 'تمثيل مشرف لفلسطين في المسابقات العالمية', 'uploads/competitions/slide1.jpg', 1, 1),
('ورش تدريبية متخصصة في البرمجة والرياضيات', 'برامج تأهيلية شاملة للطلاب الموهوبين', 'uploads/competitions/slide2.jpg', 2, 1),
('إنجازات فلسطينية في المحافل الدولية', 'ميداليات وجوائز تشرف فلسطين', 'uploads/competitions/slide3.jpg', 3, 1),
('مخيمات صيفية للعلوم والتكنولوجيا', 'تجارب عملية وتحديات مثيرة', 'uploads/competitions/slide4.jpg', 4, 1);
