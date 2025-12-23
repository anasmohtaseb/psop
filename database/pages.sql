-- جدول إدارة محتوى الصفحات الثابتة
CREATE TABLE IF NOT EXISTS `pages` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_key` VARCHAR(50) NOT NULL UNIQUE COMMENT 'المفتاح الفريد للصفحة (about, contact, etc)',
  `page_title_ar` VARCHAR(255) NOT NULL COMMENT 'عنوان الصفحة بالعربية',
  `page_title_en` VARCHAR(255) NULL COMMENT 'عنوان الصفحة بالإنجليزية',
  `meta_description` TEXT NULL COMMENT 'وصف الصفحة لمحركات البحث',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'حالة الصفحة (1=نشطة، 0=معطلة)',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_page_key` (`page_key`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='الصفحات الثابتة';

-- جدول أقسام محتوى الصفحات
CREATE TABLE IF NOT EXISTS `page_sections` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_id` INT(11) UNSIGNED NOT NULL,
  `section_key` VARCHAR(50) NOT NULL COMMENT 'مفتاح القسم (hero, vision, mission, etc)',
  `section_title_ar` VARCHAR(255) NULL COMMENT 'عنوان القسم بالعربية',
  `section_title_en` VARCHAR(255) NULL COMMENT 'عنوان القسم بالإنجليزية',
  `section_content_ar` TEXT NULL COMMENT 'محتوى القسم بالعربية',
  `section_content_en` TEXT NULL COMMENT 'محتوى القسم بالإنجليزية',
  `section_icon` VARCHAR(100) NULL COMMENT 'أيقونة القسم (emoji أو اسم أيقونة)',
  `section_order` INT(11) NOT NULL DEFAULT 0 COMMENT 'ترتيب القسم',
  `section_type` ENUM('hero', 'text', 'cards', 'stats', 'cta', 'list', 'custom') NOT NULL DEFAULT 'text' COMMENT 'نوع القسم',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_page_id` (`page_id`),
  KEY `idx_section_order` (`section_order`),
  KEY `idx_is_active` (`is_active`),
  CONSTRAINT `fk_page_sections_page` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='أقسام محتوى الصفحات';

-- جدول البيانات الإحصائية والأرقام
CREATE TABLE IF NOT EXISTS `page_stats` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_id` INT(11) UNSIGNED NOT NULL,
  `stat_label_ar` VARCHAR(255) NOT NULL COMMENT 'نص الإحصائية بالعربية',
  `stat_label_en` VARCHAR(255) NULL COMMENT 'نص الإحصائية بالإنجليزية',
  `stat_value` VARCHAR(50) NOT NULL COMMENT 'قيمة الإحصائية (مثل: 500+، 6+)',
  `stat_order` INT(11) NOT NULL DEFAULT 0 COMMENT 'ترتيب الإحصائية',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_page_id` (`page_id`),
  KEY `idx_stat_order` (`stat_order`),
  CONSTRAINT `fk_page_stats_page` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='الإحصائيات والأرقام';

-- إدراج بيانات صفحة "عن البوابة" الافتراضية
INSERT INTO `pages` (`page_key`, `page_title_ar`, `page_title_en`, `meta_description`, `is_active`) VALUES
('about', 'عن البوابة', 'About Us', 'بوابة الأولمبياد العلمي الفلسطيني - منصة وطنية لإدارة المشاركة الفلسطينية في الأولمبيادات العلمية الدولية', 1);

-- الحصول على ID الصفحة
SET @page_id = LAST_INSERT_ID();

-- إدراج أقسام صفحة "عن البوابة"
INSERT INTO `page_sections` (`page_id`, `section_key`, `section_title_ar`, `section_title_en`, `section_content_ar`, `section_content_en`, `section_icon`, `section_order`, `section_type`, `is_active`) VALUES
(@page_id, 'hero_badge', '🇵🇸 عن البوابة', '🇵🇸 About Us', NULL, NULL, NULL, 1, 'hero', 1),
(@page_id, 'hero_title', 'بوابة الأولمبياد العلمي الفلسطيني', 'Palestine Science Olympiad Portal', NULL, NULL, NULL, 2, 'hero', 1),
(@page_id, 'hero_description', 'منصة وطنية لإدارة المشاركة الفلسطينية في الأولمبيادات العلمية الدولية وتمكين الطلبة الموهوبين', 'A national platform for managing Palestinian participation in international science olympiads', NULL, NULL, NULL, 3, 'hero', 1),

(@page_id, 'vision', 'رؤيتنا', 'Our Vision', 'بناء جيل فلسطيني متميز علمياً وقادر على المنافسة عالمياً في المسابقات العلمية الدولية', 'Building a scientifically distinguished Palestinian generation capable of competing globally', '🎯', 4, 'cards', 1),
(@page_id, 'mission', 'رسالتنا', 'Our Mission', 'توفير منصة متكاملة لإدارة التسجيل والتدريب والمشاركة في الأولمبيادات العلمية بكفاءة واحترافية', 'Providing an integrated platform for registration, training, and participation', '🚀', 5, 'cards', 1),
(@page_id, 'values', 'قيمنا', 'Our Values', 'التميز العلمي، الشفافية، تكافؤ الفرص، والالتزام بتطوير القدرات الفلسطينية', 'Scientific excellence, transparency, equal opportunities, and commitment to developing Palestinian capabilities', '⭐', 6, 'cards', 1),

(@page_id, 'about_olympiads', 'عن الأولمبيادات العلمية', 'About Science Olympiads', 'الأولمبيادات العلمية هي مسابقات دولية سنوية تجمع أفضل الطلاب الموهوبين من مختلف دول العالم للتنافس في مجالات علمية متنوعة. تهدف هذه المسابقات إلى تحفيز الشباب على التميز العلمي وتطوير مهاراتهم في حل المسائل المعقدة والتفكير الإبداعي.

تشارك فلسطين في العديد من الأولمبيادات العلمية الدولية مثل:
- أولمبياد الرياضيات الدولي (IMO)
- أولمبياد المعلوماتية الدولي (IOI)
- أولمبياد الذكاء الاصطناعي الدولي (IOAI)
- المسابقة العربية للبرمجة الجامعية (ACPC)
- أولمبياد الفيزياء الدولي (IPhO)
- أولمبياد الكيمياء الدولي (IChO)', 'International Science Olympiads are annual competitions that bring together the best talented students from around the world', NULL, 7, 'text', 1),

(@page_id, 'stats_title', 'إنجازاتنا بالأرقام', 'Our Achievements', 'نفخر بما حققه طلابنا من إنجازات على المستوى الدولي', 'We are proud of our students achievements', NULL, 8, 'stats', 1),

(@page_id, 'cta_title', 'هل أنت مستعد للانضمام؟', 'Ready to Join?', 'انضم إلى آلاف الطلاب الموهوبين وابدأ رحلتك نحو التميز العلمي والمشاركة في المسابقات الدولية', 'Join thousands of talented students', NULL, 9, 'cta', 1);

-- إدراج الإحصائيات
INSERT INTO `page_stats` (`page_id`, `stat_label_ar`, `stat_label_en`, `stat_value`, `stat_order`, `is_active`) VALUES
(@page_id, 'مسابقات دولية', 'International Competitions', '6+', 1, 1),
(@page_id, 'طالب مشارك', 'Participating Students', '500+', 2, 1),
(@page_id, 'ميدالية دولية', 'International Medals', '50+', 3, 1),
(@page_id, 'مدرب متخصص', 'Specialized Trainers', '100+', 4, 1);
