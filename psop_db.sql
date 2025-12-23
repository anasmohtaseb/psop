-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2025 at 08:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `target_audience` enum('all','student','school_coordinator','trainer','admin') DEFAULT 'all',
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `publish_date` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `competitions`
--

CREATE TABLE `competitions` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `category` enum('mathematics','informatics','physics','chemistry','biology','ai','cybersecurity','other') NOT NULL,
  `description_ar` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `competitions`
--

INSERT INTO `competitions` (`id`, `name_ar`, `name_en`, `code`, `category`, `description_ar`, `description_en`, `logo_path`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'الأوليمبياد الدولي للرياضيات', 'International Mathematical Olympiad', 'IMO', 'mathematics', 'أعرق مسابقة عالمية في الرياضيات لطلبة المدارس الثانوية. تهدف إلى تنمية مهارات التفكير المنطقي وحل المسائل العليا، واكتشاف المواهب الرياضية المتميزة مبكراً.\r\n\r\n', 'International Mathematical Olympiad', NULL, 1, '2025-12-09 22:42:32', '2025-12-10 14:04:17'),
(2, 'الأوليمبياد الدولي في المعلوماتية', 'International Olympiad in Informatics', 'IOI', 'informatics', 'مسابقة عالمية رائدة في البرمجة التنافسية والخوارزميات. تركز على تصميم حلول برمجية فعّالة للمشكلات المعقدة باستخدام لغات البرمجة الحديثة.', 'International Olympiad in Informatics', NULL, 1, '2025-12-09 22:42:32', '2025-12-10 14:04:50'),
(3, 'الأوليمبياد الدولي للذكاء الاصطناعي', 'International AI Olympiad', 'IOAI', 'ai', 'منصة عالمية ناشئة لطلبة المدارس في مجالات الذكاء الاصطناعي، تعلم الآلة، وتحليل البيانات، مع تركيز على حل المشكلات الواقعية باستخدام أدوات وخوارزميات حديثة.', 'International AI Olympiad', NULL, 1, '2025-12-09 22:42:32', '2025-12-10 14:05:30'),
(4, 'الأوليمبياد الدولي للفلسفة', 'International Physics Olympiad', 'IPO', 'physics', 'مسابقة عالمية تشجع الطلبة على التفكير النقدي والكتابة الفلسفية، من خلال معالجة أسئلة كبرى تتعلق بالمعرفة، القيم، والإنسان والمجتمع.', 'International Physics Olympiad', NULL, 1, '2025-12-09 22:42:32', '2025-12-10 14:06:02');

-- --------------------------------------------------------

--
-- Table structure for table `competition_editions`
--

CREATE TABLE `competition_editions` (
  `id` int(11) NOT NULL,
  `competition_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `host_country` varchar(100) DEFAULT NULL,
  `registration_start_date` date DEFAULT NULL,
  `registration_end_date` date DEFAULT NULL,
  `training_start_date` date DEFAULT NULL,
  `training_end_date` date DEFAULT NULL,
  `competition_start_date` date DEFAULT NULL,
  `competition_end_date` date DEFAULT NULL,
  `status` enum('draft','open','registration_closed','training','ongoing','completed','cancelled') DEFAULT 'draft',
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `competition_editions`
--

INSERT INTO `competition_editions` (`id`, `competition_id`, `year`, `host_country`, `registration_start_date`, `registration_end_date`, `training_start_date`, `training_end_date`, `competition_start_date`, `competition_end_date`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 2025, 'Palestine', '2024-12-01', '2025-03-31', '2025-04-01', '2025-06-30', '2025-07-01', '2025-07-15', 'open', NULL, '2025-12-10 18:51:47', '2025-12-10 18:51:47'),
(2, 2, 2025, 'Palestine', '2024-12-01', '2025-03-31', '2025-04-01', '2025-06-30', '2025-07-01', '2025-07-15', 'open', NULL, '2025-12-10 18:51:47', '2025-12-10 18:51:47'),
(3, 3, 2025, 'Palestine', '2024-12-01', '2025-03-31', '2025-04-01', '2025-06-30', '2025-07-01', '2025-07-15', 'open', NULL, '2025-12-10 18:51:47', '2025-12-10 18:51:47'),
(4, 4, 2025, 'Palestine', '2024-12-01', '2025-03-31', '2025-04-01', '2025-06-30', '2025-07-01', '2025-07-15', 'open', NULL, '2025-12-10 18:51:47', '2025-12-10 18:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `competition_tracks`
--

CREATE TABLE `competition_tracks` (
  `id` int(11) NOT NULL,
  `competition_edition_id` int(11) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `min_age` int(11) DEFAULT NULL,
  `max_age` int(11) DEFAULT NULL,
  `min_grade` int(11) DEFAULT NULL,
  `max_grade` int(11) DEFAULT NULL,
  `max_participants_per_school` int(11) DEFAULT NULL,
  `participation_type` enum('individual','team') DEFAULT 'individual',
  `team_size` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('info','success','warning','error') DEFAULT 'info',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) UNSIGNED NOT NULL,
  `page_key` varchar(50) NOT NULL COMMENT 'المفتاح الفريد للصفحة (about, contact, etc)',
  `page_title_ar` varchar(255) NOT NULL COMMENT 'عنوان الصفحة بالعربية',
  `page_title_en` varchar(255) DEFAULT NULL COMMENT 'عنوان الصفحة بالإنجليزية',
  `meta_description` text DEFAULT NULL COMMENT 'وصف الصفحة لمحركات البحث',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'حالة الصفحة (1=نشطة، 0=معطلة)',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='الصفحات الثابتة';

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_key`, `page_title_ar`, `page_title_en`, `meta_description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'about', 'عن البوابة', 'About Us', 'بوابة الأولمبياد العلمي الفلسطيني - منصة وطنية لإدارة المشاركة الفلسطينية في الأولمبيادات العلمية الدولية', 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02');

-- --------------------------------------------------------

--
-- Table structure for table `page_sections`
--

CREATE TABLE `page_sections` (
  `id` int(11) UNSIGNED NOT NULL,
  `page_id` int(11) UNSIGNED NOT NULL,
  `section_key` varchar(50) NOT NULL COMMENT 'مفتاح القسم (hero, vision, mission, etc)',
  `section_title_ar` varchar(255) DEFAULT NULL COMMENT 'عنوان القسم بالعربية',
  `section_title_en` varchar(255) DEFAULT NULL COMMENT 'عنوان القسم بالإنجليزية',
  `section_content_ar` text DEFAULT NULL COMMENT 'محتوى القسم بالعربية',
  `section_content_en` text DEFAULT NULL COMMENT 'محتوى القسم بالإنجليزية',
  `section_icon` varchar(100) DEFAULT NULL COMMENT 'أيقونة القسم (emoji أو اسم أيقونة)',
  `section_order` int(11) NOT NULL DEFAULT 0 COMMENT 'ترتيب القسم',
  `section_type` enum('hero','text','cards','stats','cta','list','custom') NOT NULL DEFAULT 'text' COMMENT 'نوع القسم',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='أقسام محتوى الصفحات';

--
-- Dumping data for table `page_sections`
--

INSERT INTO `page_sections` (`id`, `page_id`, `section_key`, `section_title_ar`, `section_title_en`, `section_content_ar`, `section_content_en`, `section_icon`, `section_order`, `section_type`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'hero_badge', '🇵🇸 عن البوابة', '🇵🇸 About Us', NULL, NULL, NULL, 1, 'hero', 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02'),
(2, 1, 'hero_title', 'بوابة الأولمبياد العلمي الفلسطيني', 'Palestine Science Olympiad Portal', NULL, NULL, NULL, 2, 'hero', 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02'),
(3, 1, 'hero_description', 'منصة وطنية لإدارة المشاركة الفلسطينية في الأولمبيادات العلمية الدولية وتمكين الطلبة الموهوبين', 'A national platform for managing Palestinian participation in international science olympiads', NULL, NULL, NULL, 3, 'hero', 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02'),
(4, 1, 'vision', 'رؤيتنا', 'Our Vision', 'بناء جيل فلسطيني متميز علمياً وقادر على المنافسة عالمياً في المسابقات العلمية الدولية', 'Building a scientifically distinguished Palestinian generation capable of competing globally', '🎯', 4, 'cards', 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02'),
(5, 1, 'mission', 'رسالتنا', 'Our Mission', 'توفير منصة متكاملة لإدارة التسجيل والتدريب والمشاركة في الأولمبيادات العلمية بكفاءة واحترافية', 'Providing an integrated platform for registration, training, and participation', '🚀', 5, 'cards', 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02'),
(6, 1, 'values', 'قيمنا', 'Our Values', 'التميز العلمي، الشفافية، تكافؤ الفرص، والالتزام بتطوير القدرات الفلسطينية', 'Scientific excellence, transparency, equal opportunities, and commitment to developing Palestinian capabilities', '⭐', 6, 'cards', 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02'),
(7, 1, 'about_olympiads', 'عن الأولمبيادات العلمية', 'About Science Olympiads', 'الأولمبيادات العلمية هي مسابقات دولية سنوية تجمع أفضل الطلاب الموهوبين من مختلف دول العالم للتنافس في مجالات علمية متنوعة. تهدف هذه المسابقات إلى تحفيز الشباب على التميز العلمي وتطوير مهاراتهم في حل المسائل المعقدة والتفكير الإبداعي.\r\n\r\nتشارك فلسطين في العديد من الأولمبيادات العلمية الدولية مثل:\r\n- أولمبياد الرياضيات الدولي (IMO)\r\n- أولمبياد المعلوماتية الدولي (IOI)\r\n- أولمبياد الذكاء الاصطناعي الدولي (IOAI)\r\n- المسابقة العربية للبرمجة الجامعية (ACPC)\r\n- أولمبياد الفيزياء الدولي (IPhO)\r\n- أولمبياد الكيمياء الدولي (IChO)', 'International Science Olympiads are annual competitions that bring together the best talented students from around the world', NULL, 7, 'text', 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02'),
(8, 1, 'stats_title', 'إنجازاتنا بالأرقام', 'Our Achievements', 'نفخر بما حققه طلابنا من إنجازات على المستوى الدولي', 'We are proud of our students achievements', NULL, 8, 'stats', 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02'),
(9, 1, 'cta_title', 'هل أنت مستعد للانضمام؟', 'Ready to Join?', 'انضم إلى آلاف الطلاب الموهوبين وابدأ رحلتك نحو التميز العلمي والمشاركة في المسابقات الدولية', 'Join thousands of talented students', NULL, 9, 'cta', 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02');

-- --------------------------------------------------------

--
-- Table structure for table `page_stats`
--

CREATE TABLE `page_stats` (
  `id` int(11) UNSIGNED NOT NULL,
  `page_id` int(11) UNSIGNED NOT NULL,
  `stat_label_ar` varchar(255) NOT NULL COMMENT 'نص الإحصائية بالعربية',
  `stat_label_en` varchar(255) DEFAULT NULL COMMENT 'نص الإحصائية بالإنجليزية',
  `stat_value` varchar(50) NOT NULL COMMENT 'قيمة الإحصائية (مثل: 500+، 6+)',
  `stat_order` int(11) NOT NULL DEFAULT 0 COMMENT 'ترتيب الإحصائية',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='الإحصائيات والأرقام';

--
-- Dumping data for table `page_stats`
--

INSERT INTO `page_stats` (`id`, `page_id`, `stat_label_ar`, `stat_label_en`, `stat_value`, `stat_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'مسابقات دولية', 'International Competitions', '6+', 1, 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02'),
(2, 1, 'طالب مشارك', 'Participating Students', '500+', 2, 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02'),
(3, 1, 'ميدالية دولية', 'International Medals', '50+', 3, 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02'),
(4, 1, 'مدرب متخصص', 'Specialized Trainers', '100+', 4, 1, '2025-12-11 08:20:02', '2025-12-11 08:20:02');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `competition_edition_id` int(11) NOT NULL,
  `student_user_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `school_id` int(11) NOT NULL,
  `registration_type` enum('individual','team') NOT NULL,
  `status` enum('draft','submitted','under_review','accepted_training','accepted_final','rejected','cancelled') DEFAULT 'draft',
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `competition_edition_id`, `student_user_id`, `team_id`, `school_id`, `registration_type`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, 2, 'individual', 'under_review', '12345678', '2025-12-10 18:56:59', '2025-12-10 18:58:46');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `description`, `created_at`) VALUES
(1, 'admin', 'System Administrator', '2025-12-09 22:42:32'),
(2, 'competition_manager', 'Competition Manager', '2025-12-09 22:42:32'),
(3, 'school_coordinator', 'School Coordinator', '2025-12-09 22:42:32'),
(4, 'trainer', 'Trainer', '2025-12-09 22:42:32'),
(5, 'student', 'Student', '2025-12-09 22:42:32');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('government','private','unrwa') NOT NULL,
  `governorate` varchar(100) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive','pending') DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `type`, `governorate`, `city`, `address`, `contact_email`, `contact_phone`, `status`, `created_at`, `updated_at`) VALUES
(1, 'مدرسة الراشدين الاساسية ', 'government', 'الخليل', 'الخليل', 'نمره', '', '', 'active', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'السعدية', 'government', 'غير محدد', '', NULL, NULL, NULL, 'pending', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `school_users`
--

CREATE TABLE `school_users` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('coordinator','trainer') NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_profile`
--

CREATE TABLE `students_profile` (
  `user_id` int(11) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `date_of_birth` date NOT NULL,
  `grade` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `guardian_name` varchar(255) DEFAULT NULL,
  `guardian_phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students_profile`
--

INSERT INTO `students_profile` (`user_id`, `gender`, `date_of_birth`, `grade`, `school_id`, `guardian_name`, `guardian_phone`) VALUES
(2, 'male', '2018-12-16', 7, 2, 'انس المحتسب', '0598218387');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(100) NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `description_ar` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_months` int(11) NOT NULL DEFAULT 12,
  `features` text DEFAULT NULL COMMENT 'JSON array of features',
  `user_type` enum('student','school') NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `name_ar`, `name_en`, `description_ar`, `description_en`, `price`, `duration_months`, `features`, `user_type`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'اشتراك سنوي للطلاب ', 'Student Annual Subscription', 'اشتراك سنوي للطلاب للتسجيل في جميع المسابقات', 'Annual subscription for students to register in all competitions', 50.00, 12, '[\"\\u0627\\u0634\\u062a\\u0631\\u0627\\u0643 \\u0633\\u0646\\u0648\\u064a \\u0644\\u0644\\u0637\\u0644\\u0627\\u0628 \\u0644\\u0644\\u062a\\u0633\\u062c\\u064a\\u0644 \\u0641\\u064a \\u062c\\u0645\\u064a\\u0639 \\u0627\\u0644\\u0645\\u0633\\u0627\\u0628\\u0642\\u0627\\u062a\"]', 'student', 1, '2025-12-10 19:01:25', '2025-12-10 20:02:15'),
(2, 'اشتراك سنوي للمدارس', 'School Annual Subscription', 'اشتراك المدارس يمكن اضافة لغاية 20 طالب ', 'School subscriptions can add up to 20 students', 200.00, 12, '[\"\\u0627\\u0634\\u062a\\u0631\\u0627\\u0643 \\u0627\\u0644\\u0645\\u062f\\u0627\\u0631\\u0633 \\u064a\\u0645\\u0643\\u0646 \\u0627\\u0636\\u0627\\u0641\\u0629 \\u0644\\u063a\\u0627\\u064a\\u0629 20 \\u0637\\u0627\\u0644\\u0628 \"]', 'school', 1, '2025-12-10 19:01:25', '2025-12-10 20:04:11'),
(5, 'اشتراك سنوي لطلبة الجامعات', 'Annual subscription for university students', 'اشتراك سنوي لطلبة الجامعات', 'Annual subscription for university students', 20.00, 12, '[\"\\u0627\\u0634\\u062a\\u0631\\u0627\\u0643 \\u0633\\u0646\\u0648\\u064a \\u0644\\u0637\\u0644\\u0628\\u0629 \\u0627\\u0644\\u062c\\u0627\\u0645\\u0639\\u0627\\u062a\"]', 'school', 1, '2025-12-10 19:52:30', '2025-12-10 20:05:28');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `school_id` int(11) NOT NULL,
  `competition_edition_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('leader','member') DEFAULT 'member',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `training_resources`
--

CREATE TABLE `training_resources` (
  `id` int(11) NOT NULL,
  `competition_id` int(11) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `description_ar` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `resource_type` enum('pdf','video','link','quiz','other') NOT NULL,
  `resource_url` varchar(500) DEFAULT NULL,
  `file_path` varchar(500) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `type` enum('student','school_coordinator','trainer','admin','competition_manager') NOT NULL,
  `status` enum('active','inactive','pending','suspended') DEFAULT 'active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `phone`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Anas mohtaseb', 'admin@psop.ps', '$2y$10$2mvVK4SOj/vyxWlE887mkuSY.1iRpK1dSxa.clONyhcBdVKh/llm.', '0599000000', 'admin', 'active', '2025-12-09 22:42:32', '2025-12-09 22:42:32'),
(2, 'زين الدين انس المحتسب', 'zain@mail.com', '$2y$10$o.AQYMgumVHlF0cJpPBiuOweBdZTpLECvelQV/38/uHEGQ1IqvaJS', '0598218387', 'student', 'active', '2025-12-10 18:20:28', '2025-12-10 18:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`, `created_at`) VALUES
(1, 1, '2025-12-09 22:42:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_subscriptions`
--

CREATE TABLE `user_subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('pending','active','expired','cancelled') DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('unpaid','paid','refunded') DEFAULT 'unpaid',
  `payment_reference` varchar(100) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_subscriptions`
--

INSERT INTO `user_subscriptions` (`id`, `user_id`, `plan_id`, `start_date`, `end_date`, `status`, `payment_method`, `payment_status`, `payment_reference`, `payment_date`, `amount_paid`, `notes`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2025-12-10', '2026-12-10', 'active', 'credit_card', 'paid', '', '2025-12-10 20:06:34', 50.00, NULL, '2025-12-10 20:05:49', '2025-12-10 20:06:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_target` (`target_audience`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_publish_date` (`publish_date`);

--
-- Indexes for table `competitions`
--
ALTER TABLE `competitions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_code` (`code`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_is_active` (`is_active`);

--
-- Indexes for table `competition_editions`
--
ALTER TABLE `competition_editions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_competition_year` (`competition_id`,`year`),
  ADD KEY `idx_year` (`year`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_competition` (`competition_id`);

--
-- Indexes for table `competition_tracks`
--
ALTER TABLE `competition_tracks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_edition` (`competition_edition_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_is_read` (`is_read`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_key` (`page_key`),
  ADD KEY `idx_page_key` (`page_key`),
  ADD KEY `idx_is_active` (`is_active`);

--
-- Indexes for table `page_sections`
--
ALTER TABLE `page_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_page_id` (`page_id`),
  ADD KEY `idx_section_order` (`section_order`),
  ADD KEY `idx_is_active` (`is_active`);

--
-- Indexes for table `page_stats`
--
ALTER TABLE `page_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_page_id` (`page_id`),
  ADD KEY `idx_stat_order` (`stat_order`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `idx_edition` (`competition_edition_id`),
  ADD KEY `idx_student` (`student_user_id`),
  ADD KEY `idx_school` (`school_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_governorate` (`governorate`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `school_users`
--
ALTER TABLE `school_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_school_user_role` (`school_id`,`user_id`,`role`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `students_profile`
--
ALTER TABLE `students_profile`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `idx_school` (`school_id`),
  ADD KEY `idx_grade` (`grade`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `competition_edition_id` (`competition_edition_id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_team_user` (`team_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `training_resources`
--
ALTER TABLE `training_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_competition` (`competition_id`),
  ADD KEY `idx_published` (`is_published`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `idx_user_status` (`user_id`,`status`),
  ADD KEY `idx_dates` (`start_date`,`end_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `competitions`
--
ALTER TABLE `competitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `competition_editions`
--
ALTER TABLE `competition_editions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `competition_tracks`
--
ALTER TABLE `competition_tracks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `page_sections`
--
ALTER TABLE `page_sections`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `page_stats`
--
ALTER TABLE `page_stats`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `school_users`
--
ALTER TABLE `school_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_resources`
--
ALTER TABLE `training_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `competition_editions`
--
ALTER TABLE `competition_editions`
  ADD CONSTRAINT `competition_editions_ibfk_1` FOREIGN KEY (`competition_id`) REFERENCES `competitions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `competition_tracks`
--
ALTER TABLE `competition_tracks`
  ADD CONSTRAINT `competition_tracks_ibfk_1` FOREIGN KEY (`competition_edition_id`) REFERENCES `competition_editions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `page_sections`
--
ALTER TABLE `page_sections`
  ADD CONSTRAINT `fk_page_sections_page` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `page_stats`
--
ALTER TABLE `page_stats`
  ADD CONSTRAINT `fk_page_stats_page` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`competition_edition_id`) REFERENCES `competition_editions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`student_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_ibfk_3` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_ibfk_4` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `school_users`
--
ALTER TABLE `school_users`
  ADD CONSTRAINT `school_users_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `school_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students_profile`
--
ALTER TABLE `students_profile`
  ADD CONSTRAINT `students_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_profile_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `teams_ibfk_2` FOREIGN KEY (`competition_edition_id`) REFERENCES `competition_editions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `training_resources`
--
ALTER TABLE `training_resources`
  ADD CONSTRAINT `training_resources_ibfk_1` FOREIGN KEY (`competition_id`) REFERENCES `competitions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD CONSTRAINT `user_subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_subscriptions_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `subscription_plans` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
