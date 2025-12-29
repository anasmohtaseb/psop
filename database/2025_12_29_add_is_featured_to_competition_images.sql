-- Add is_featured column to competition_images
ALTER TABLE competition_images
  ADD COLUMN is_featured TINYINT(1) NOT NULL DEFAULT 0,
  ADD INDEX idx_is_featured (is_featured);

-- Optional: set a few existing images as featured manually if desired
-- UPDATE competition_images SET is_featured = 1 WHERE id IN (1,2,3);
