-- Activity Log System
-- This table tracks all important actions performed by users in the system

CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NULL,
  `user_type` ENUM('student', 'school_coordinator', 'trainer', 'admin', 'competition_manager', 'guest') DEFAULT 'guest',
  `action` VARCHAR(100) NOT NULL COMMENT 'Action performed (e.g., login, create_competition, update_user)',
  `entity_type` VARCHAR(50) NULL COMMENT 'Type of entity affected (e.g., user, competition, registration)',
  `entity_id` INT UNSIGNED NULL COMMENT 'ID of the affected entity',
  `description` TEXT NULL COMMENT 'Human-readable description in Arabic',
  `ip_address` VARCHAR(45) NULL COMMENT 'User IP address',
  `user_agent` VARCHAR(255) NULL COMMENT 'Browser user agent',
  `metadata` JSON NULL COMMENT 'Additional data about the action',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_action` (`action`),
  INDEX `idx_entity` (`entity_type`, `entity_id`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data
INSERT INTO `activity_logs` (`user_id`, `user_type`, `action`, `entity_type`, `entity_id`, `description`, `ip_address`) VALUES
(1, 'admin', 'login', NULL, NULL, 'تسجيل دخول المدير', '127.0.0.1'),
(1, 'admin', 'create_competition', 'competition', 1, 'إنشاء مسابقة جديدة: الأولمبياد الدولي للرياضيات', '127.0.0.1'),
(2, 'student', 'register', NULL, NULL, 'تسجيل طالب جديد', '127.0.0.1'),
(2, 'student', 'create_registration', 'registration', 1, 'التسجيل في مسابقة IMO 2025', '127.0.0.1');
