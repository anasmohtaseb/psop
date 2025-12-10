<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'لوحة التحكم' ?> - بوابة الأولمبياد العلمي</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $this->asset('css/style.css') ?>">
    <style>
        /* Ensure dashboard styles are loaded */
        body.dashboard-body { 
            background: #f5f5f5 !important;
            margin: 0;
            font-family: 'Cairo', sans-serif;
        }
        
        /* CSS Variables for inline styles */
        :root {
            --primary: #e11d48;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
        }
        
        /* Ensure content area has proper background */
        .dashboard-content {
            background: #f5f5f5 !important;
            min-height: calc(100vh - 70px);
        }
        
        /* Debug: Make sure layout is visible */
        .dashboard-header {
            background: white !important;
            border-bottom: 1px solid #e0e0e0 !important;
        }
    </style>
</head>
<body class="dashboard-body">
    <!-- DEBUG: Layout is loading -->
    <header class="dashboard-header">
        <div class="dashboard-top-bar">
            <div class="dashboard-left">
                <div class="dashboard-brand">
                    <div class="dashboard-icon">
                        <div class="dashboard-icon-inner"></div>
                    </div>
                    <div class="dashboard-title-box">
                        <h1 class="dashboard-title">لوحة التحكم</h1>
                        <p class="dashboard-subtitle">بوابة الأوليمبياد العلمية</p>
                    </div>
                </div>
            </div>
            <div class="dashboard-right">
                <a href="<?= $this->url('/') ?>" class="home-link">🏠 الصفحة الرئيسية</a>
                <?php if (isset($user)): ?>
                    <div class="user-profile-box">
                        <button class="user-profile-btn" id="userProfileBtn">
                            <span class="user-avatar-circle"><?= mb_substr($this->e($user['name']), 0, 1) ?></span>
                            <span class="user-display-name"><?= $this->e($user['name']) ?></span>
                            <span class="arrow-down">▼</span>
                        </button>
                        <div class="user-dropdown-panel" id="userDropdown">
                            <a href="<?= $this->url('/profile') ?>" class="dropdown-item">الملف الشخصي</a>
                            <a href="<?= $this->url('/logout') ?>" class="dropdown-item logout">تسجيل الخروج</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="dashboard-layout">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="<?= $this->url('/dashboard') ?>"><span>📊</span> الرئيسية</a></li>
                
                <?php if (isset($user) && $user['type'] === 'student'): ?>
                    <li><a href="<?= $this->url('/subscriptions/my-subscription') ?>"><span>💳</span> اشتراكي</a></li>
                    <li><a href="<?= $this->url('/dashboard/registrations') ?>"><span>📝</span> تسجيلاتي</a></li>
                    <li><a href="<?= $this->url('/dashboard/profile') ?>"><span>👤</span> الملف الشخصي</a></li>
                <?php endif; ?>
                
                <?php if (isset($user) && $user['type'] === 'school_coordinator'): ?>
                    <li><a href="<?= $this->url('/dashboard/students') ?>"><span>👥</span> الطلاب</a></li>
                    <li><a href="<?= $this->url('/dashboard/school') ?>"><span>🏫</span> بيانات المدرسة</a></li>
                    <li><a href="<?= $this->url('/dashboard/registrations') ?>"><span>📝</span> التسجيلات</a></li>
                <?php endif; ?>
                
                <?php if (isset($user) && in_array($user['type'], ['admin', 'competition_manager'])): ?>
                    <li><a href="<?= $this->url('/admin/users') ?>"><span>👥</span> المستخدمون</a></li>
                    <li><a href="<?= $this->url('/admin/schools') ?>"><span>🏫</span> المدارس</a></li>
                    <li><a href="<?= $this->url('/admin/competitions') ?>"><span>🏆</span> المسابقات</a></li>
                    <li><a href="<?= $this->url('/admin/registrations') ?>"><span>📋</span> التسجيلات</a></li>
                    <li><a href="<?= $this->url('/admin/subscriptions') ?>"><span>💳</span> الاشتراكات</a></li>
                    <li><a href="<?= $this->url('/admin/subscriptions/plans') ?>"><span>📊</span> خطط الاشتراك</a></li>
                    <li><a href="<?= $this->url('/admin/announcements') ?>"><span>📢</span> الإعلانات</a></li>
                <?php endif; ?>
            </ul>
        </aside>

        <main class="dashboard-content">
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
    </div>

    <script>
        // User dropdown toggle
        const userProfileBtn = document.getElementById('userProfileBtn');
        const userDropdown = document.getElementById('userDropdown');
        
        if (userProfileBtn && userDropdown) {
            userProfileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('active');
            });
            
            document.addEventListener('click', () => {
                userDropdown.classList.remove('active');
            });
            
            userDropdown.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        }
    </script>
    <script src="<?= $this->asset('js/app.js') ?>"></script>
</body>
</html>
