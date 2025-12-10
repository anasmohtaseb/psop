-- Subscription Plans Table
CREATE TABLE IF NOT EXISTS subscription_plans (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name_ar VARCHAR(100) NOT NULL,
    name_en VARCHAR(100) NOT NULL,
    description_ar TEXT,
    description_en TEXT,
    price DECIMAL(10, 2) NOT NULL,
    duration_months INT NOT NULL DEFAULT 12,
    features TEXT COMMENT 'JSON array of features',
    user_type ENUM('student', 'school') NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User Subscriptions Table
CREATE TABLE IF NOT EXISTS user_subscriptions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    plan_id INT(11) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status ENUM('pending', 'active', 'expired', 'cancelled') DEFAULT 'pending',
    payment_method VARCHAR(50),
    payment_status ENUM('unpaid', 'paid', 'refunded') DEFAULT 'unpaid',
    payment_reference VARCHAR(100),
    payment_date DATETIME,
    amount_paid DECIMAL(10, 2),
    notes TEXT,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (plan_id) REFERENCES subscription_plans(id),
    INDEX idx_user_status (user_id, status),
    INDEX idx_dates (start_date, end_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default subscription plans
INSERT INTO subscription_plans (name_ar, name_en, description_ar, description_en, price, duration_months, features, user_type, is_active, created_at, updated_at) VALUES
('اشتراك طالب سنوي', 'Student Annual Subscription', 'اشتراك سنوي للطلاب يتيح التسجيل في جميع المسابقات', 'Annual subscription for students to register in all competitions', 50.00, 12, '["التسجيل في جميع المسابقات", "الوصول لمواد التدريب", "شهادة المشاركة", "الدعم الفني"]', 'student', 1, NOW(), NOW()),
('اشتراك مدرسة سنوي', 'School Annual Subscription', 'اشتراك سنوي للمدارس لتسجيل عدد غير محدود من الطلاب', 'Annual subscription for schools to register unlimited students', 200.00, 12, '["تسجيل غير محدود للطلاب", "لوحة تحكم المدرسة", "تقارير مفصلة", "الدعم المخصص"]', 'school', 1, NOW(), NOW()),
('اشتراك طالب تجريبي', 'Student Trial Subscription', 'اشتراك تجريبي مجاني لمدة 3 أشهر', 'Free trial subscription for 3 months', 0.00, 3, '["التسجيل في مسابقة واحدة", "الوصول المحدود لمواد التدريب"]', 'student', 1, NOW(), NOW());
