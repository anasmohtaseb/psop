<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? ($site_settings['site_name_ar'] ?? 'Palestine Science Olympiad Portal') ?></title>
    <meta name="description" content="<?= $site_settings['site_description'] ?? 'Platform for managing Palestinian participation in international science olympiads' ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $this->asset('css/style.css') ?>?v=<?= time() ?>">
    <script src="<?= $this->asset('js/app.js') ?>?v=<?= time() ?>" defer></script>
</head>
<body>
    <header>
        <div class="container">
            <nav class="nav">
                <div class="logo-box">
                    <?php if (!empty($site_settings['site_logo'])): ?>
                        <img src="<?= $this->url($site_settings['site_logo']) ?>" 
                             alt="<?= $this->e($site_settings['site_name_ar'] ?? 'Logo') ?>" 
                             style="max-height: 50px; margin-left: 15px;">
                    <?php else: ?>
                        <div class="logo-mark">
                            <div class="logo-mark-inner"></div>
                        </div>
                    <?php endif; ?>
                    <div>
                        <div class="logo-text-main"><?= $this->e($site_settings['site_name_ar'] ?? 'Palestine Science Olympiad Portal') ?></div>
                        <div class="logo-text-sub"><?= $this->e($site_settings['site_description'] ?? 'Unified platform for international science competitions') ?></div>
                    </div>
                </div>
                <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="القائمة">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="nav-links" id="navLinks">
                    <a href="<?= $this->url('/') ?>" class="nav-link">الرئيسية</a>
                    <a href="<?= $this->url('/competitions') ?>" class="nav-link">المسابقات</a>
                    <a href="<?= $this->url('/subscriptions/plans') ?>" class="nav-link">الاشتراكات</a>
                    <a href="<?= $this->url('/about') ?>" class="nav-link">عن البوابة</a>
                    <a href="<?= $this->url('/contact') ?>" class="nav-link">اتصل بنا</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="<?= $this->url('/dashboard') ?>" class="nav-cta">لوحة التحكم</a>
                        <a href="<?= $this->url('/logout') ?>" class="nav-link" style="color: #ef4444;">تسجيل الخروج</a>
                    <?php else: ?>
                        <a href="<?= $this->url('/login') ?>" class="nav-link">تسجيل الدخول</a>
                        <a href="<?= $this->url('/register/student') ?>" class="nav-cta">ابدأ الآن</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <?php if (isset($_SESSION['flash'])): ?>
            <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                <div class="alert alert-<?= $type ?>">
                    <?= $this->e($message) ?>
                </div>
                <?php unset($_SESSION['flash'][$type]); ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?= $viewContent ?>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <!-- About Section -->
                <div class="footer-col">
                    <div class="footer-logo" style="flex-direction: column; align-items: center; gap: 16px; text-align: center;">
                        <?php if (!empty($site_settings['site_logo'])): ?>
                            <img src="<?= $this->url($site_settings['site_logo']) ?>" 
                                 alt="<?= $this->e($site_settings['site_name_ar'] ?? 'الأولمبياد العلمي') ?>" 
                                 style="max-height: 80px; width: auto; object-fit: contain;">
                        <?php else: ?>
                            <div class="footer-logo-icon" style="margin: 0 auto;">
                                <div class="footer-logo-inner"></div>
                            </div>
                        <?php endif; ?>
                        <div>
                            <h3 class="footer-brand-title"><?= $this->e($site_settings['site_name_ar'] ?? 'بوابة الأولمبياد العلمية') ?></h3>
                            <p class="footer-brand-subtitle">في فلسطين</p>
                        </div>
                    </div>
                    <p class="footer-description" style="text-align: center;">
                        <?= $this->e($site_settings['site_description'] ?? 'منصة وطنية موحدة للمسابقات العلمية الدولية، تهدف لاكتشاف ورعاية المواهب الفلسطينية.') ?>
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="footer-col">
                    <h4 class="footer-heading">روابط سريعة</h4>
                    <ul class="footer-list">
                        <li><a href="<?= $this->url('/') ?>">• الصفحة الرئيسية</a></li>
                        <li><a href="<?= $this->url('/competitions') ?>">• المسابقات</a></li>
                        <li><a href="<?= $this->url('/about') ?>">• عن البوابة</a></li>
                        <li><a href="<?= $this->url('/contact') ?>">• اتصل بنا</a></li>
                    </ul>
                </div>

                <!-- For Students -->
                <div class="footer-col">
                    <h4 class="footer-heading">للطلبة</h4>
                    <ul class="footer-list">
                        <li><a href="<?= $this->url('/register/student') ?>">• تسجيل طالب</a></li>
                        <li><a href="<?= $this->url('/login') ?>">• تسجيل الدخول</a></li>
                        <li><a href="<?= $this->url('/subscriptions/plans') ?>">• خطط الاشتراك</a></li>
                        <li><a href="<?= $this->url('/dashboard') ?>">• لوحة التحكم</a></li>
                    </ul>
                </div>

                <!-- For Schools -->
                <div class="footer-col">
                    <h4 class="footer-heading">للمدارس</h4>
                    <ul class="footer-list">
                        <li><a href="<?= $this->url('/register/school') ?>">• تسجيل مدرسة</a></li>
                        <li><a href="<?= $this->url('/register/trainer') ?>">• تسجيل مدرب</a></li>
                        <li><a href="#">• دليل المدربين</a></li>
                        <li><a href="#">• موارد تدريبية</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p>&copy; 2025 <?= $this->e($site_settings['site_name_ar'] ?? 'Palestine Science Olympiad Portal') ?> - All rights reserved</p>
                    <div class="footer-credits">
                        <?php if (!empty($site_settings['site_email'])): ?>
                            <span>📧 <?= $this->e($site_settings['site_email']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($site_settings['site_phone'])): ?>
                            <span>📱 <?= $this->e($site_settings['site_phone']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
