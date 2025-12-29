-- Palestine Science Olympiad Portal Database Schema
-- MySQL 8.0+

-- Create database
CREATE DATABASE IF NOT EXISTS psop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE psop_db;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    type ENUM('student', 'school_coordinator', 'trainer', 'admin', 'competition_manager') NOT NULL,
    status ENUM('active', 'inactive', 'pending', 'suspended') DEFAULT 'active',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    INDEX idx_email (email),
    INDEX idx_type (type),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Roles table for RBAC
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User-Role mapping
CREATE TABLE user_roles (
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    created_at DATETIME NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schools table
CREATE TABLE schools (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type ENUM('government', 'private', 'unrwa') NOT NULL,
    governorate VARCHAR(100) NOT NULL,
    city VARCHAR(100),
    address TEXT,
    contact_email VARCHAR(255),
    contact_phone VARCHAR(20),
    status ENUM('active', 'inactive', 'pending') DEFAULT 'pending',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    INDEX idx_governorate (governorate),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- School-User mapping (coordinators and trainers)
CREATE TABLE school_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    school_id INT NOT NULL,
    user_id INT NOT NULL,
    role ENUM('coordinator', 'trainer') NOT NULL,
    created_at DATETIME NOT NULL,
    UNIQUE KEY unique_school_user_role (school_id, user_id, role),
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Student profiles
CREATE TABLE students_profile (
    user_id INT PRIMARY KEY,
    gender ENUM('male', 'female') NOT NULL,
    date_of_birth DATE NOT NULL,
    grade INT NOT NULL,
    school_id INT NOT NULL,
    guardian_name VARCHAR(255),
    guardian_phone VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE RESTRICT,
    INDEX idx_school (school_id),
    INDEX idx_grade (grade)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Competitions table
CREATE TABLE competitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_ar VARCHAR(255) NOT NULL,
    name_en VARCHAR(255) NOT NULL,
    code VARCHAR(50) NOT NULL UNIQUE,
    category ENUM('mathematics', 'informatics', 'physics', 'chemistry', 'biology', 'ai', 'cybersecurity', 'other') NOT NULL,
    description_ar TEXT,
    description_en TEXT,
    long_description_ar MEDIUMTEXT,
    long_description_en MEDIUMTEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    INDEX idx_code (code),
    INDEX idx_category (category),
    INDEX idx_is_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Competition editions (yearly instances)
CREATE TABLE competition_editions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    competition_id INT NOT NULL,
    year INT NOT NULL,
    host_country VARCHAR(100),
    registration_start_date DATE,
    registration_end_date DATE,
    training_start_date DATE,
    training_end_date DATE,
    competition_start_date DATE,
    competition_end_date DATE,
    status ENUM('draft', 'open', 'registration_closed', 'training', 'ongoing', 'completed', 'cancelled') DEFAULT 'draft',
    notes TEXT,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (competition_id) REFERENCES competitions(id) ON DELETE CASCADE,
    INDEX idx_year (year),
    INDEX idx_status (status),
    INDEX idx_competition (competition_id),
    UNIQUE KEY unique_competition_year (competition_id, year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Competition tracks (age groups, difficulty levels, etc.)
CREATE TABLE competition_tracks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    competition_edition_id INT NOT NULL,
    name_ar VARCHAR(255) NOT NULL,
    name_en VARCHAR(255) NOT NULL,
    min_age INT,
    max_age INT,
    min_grade INT,
    max_grade INT,
    max_participants_per_school INT,
    participation_type ENUM('individual', 'team') DEFAULT 'individual',
    team_size INT,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (competition_edition_id) REFERENCES competition_editions(id) ON DELETE CASCADE,
    INDEX idx_edition (competition_edition_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Teams (for team-based competitions)
CREATE TABLE teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    school_id INT NOT NULL,
    competition_edition_id INT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE RESTRICT,
    FOREIGN KEY (competition_edition_id) REFERENCES competition_editions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Team members
CREATE TABLE team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT NOT NULL,
    user_id INT NOT NULL,
    role ENUM('leader', 'member') DEFAULT 'member',
    created_at DATETIME NOT NULL,
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_team_user (team_id, user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Registrations
CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    competition_edition_id INT NOT NULL,
    student_user_id INT NULL,
    team_id INT NULL,
    school_id INT NOT NULL,
    registration_type ENUM('individual', 'team') NOT NULL,
    status ENUM('draft', 'submitted', 'under_review', 'accepted_training', 'accepted_final', 'rejected', 'cancelled') DEFAULT 'draft',
    notes TEXT,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (competition_edition_id) REFERENCES competition_editions(id) ON DELETE CASCADE,
    FOREIGN KEY (student_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE RESTRICT,
    INDEX idx_edition (competition_edition_id),
    INDEX idx_student (student_user_id),
    INDEX idx_school (school_id),
    INDEX idx_status (status),
    CHECK ((registration_type = 'individual' AND student_user_id IS NOT NULL AND team_id IS NULL) OR
           (registration_type = 'team' AND team_id IS NOT NULL))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Training resources
CREATE TABLE training_resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    competition_id INT NOT NULL,
    title_ar VARCHAR(255) NOT NULL,
    title_en VARCHAR(255),
    description_ar TEXT,
    description_en TEXT,
    resource_type ENUM('pdf', 'video', 'link', 'quiz', 'other') NOT NULL,
    resource_url VARCHAR(500),
    file_path VARCHAR(500),
    is_published TINYINT(1) DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (competition_id) REFERENCES competitions(id) ON DELETE CASCADE,
    INDEX idx_competition (competition_id),
    INDEX idx_published (is_published)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Announcements
CREATE TABLE announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    target_audience ENUM('all', 'student', 'school_coordinator', 'trainer', 'admin') DEFAULT 'all',
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    publish_date DATE,
    created_by INT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX idx_target (target_audience),
    INDEX idx_status (status),
    INDEX idx_publish_date (publish_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Notifications
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    is_read TINYINT(1) DEFAULT 0,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_is_read (is_read)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- System settings
CREATE TABLE system_settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT,
    description TEXT,
    updated_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default roles
INSERT INTO roles (role_name, description, created_at) VALUES
('admin', 'System Administrator', NOW()),
('competition_manager', 'Competition Manager', NOW()),
('school_coordinator', 'School Coordinator', NOW()),
('trainer', 'Trainer', NOW()),
('student', 'Student', NOW());

-- Insert default admin user (password: admin123)
INSERT INTO users (name, email, password_hash, phone, type, status, created_at, updated_at) VALUES
('مدير النظام', 'admin@psop.ps', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0599000000', 'admin', 'active', NOW(), NOW());

-- Assign admin role to admin user
INSERT INTO user_roles (user_id, role_id, created_at) VALUES
(1, 1, NOW());

-- Insert sample competitions
INSERT INTO competitions (name_ar, name_en, code, category, description_ar, description_en, is_active, created_at, updated_at) VALUES
('أولمبياد الرياضيات الدولي', 'International Mathematical Olympiad', 'IMO', 'mathematics', 'المسابقة الدولية للرياضيات', 'International Mathematical Olympiad', 1, NOW(), NOW()),
('أولمبياد المعلوماتية الدولي', 'International Olympiad in Informatics', 'IOI', 'informatics', 'المسابقة الدولية للمعلوماتية', 'International Olympiad in Informatics', 1, NOW(), NOW()),
('أولمبياد الذكاء الاصطناعي الدولي', 'International AI Olympiad', 'IOAI', 'ai', 'أولمبياد الذكاء الاصطناعي الدولي', 'International AI Olympiad', 1, NOW(), NOW()),
('أولمبياد الفيزياء الدولي', 'International Physics Olympiad', 'IPO', 'physics', 'المسابقة الدولية للفيزياء', 'International Physics Olympiad', 1, NOW(), NOW());
