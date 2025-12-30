-- Migration: Add competition_images table for competition galleries
CREATE TABLE competition_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    competition_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    caption_ar VARCHAR(255),
    caption_en VARCHAR(255),
    sort_order INT DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (competition_id) REFERENCES competitions(id) ON DELETE CASCADE,
    INDEX idx_competition_id (competition_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
