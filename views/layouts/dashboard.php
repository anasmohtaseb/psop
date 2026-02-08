<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - <?= $site_settings['site_name_en'] ?? 'PSOP' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $this->asset('css/style.css') ?>">
    <style>
        /* Ensure dashboard styles are loaded */
        body.dashboard-body { 
            background: #f5f5f5 !important;
            margin: 0;
            padding-top: 0 !important;
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
                <button class="mobile-sidebar-toggle" id="mobileSidebarToggle" aria-label="فتح القائمة">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="dashboard-brand">
                    <?php if (!empty($site_settings['site_logo'])): ?>
                        <img src="<?= $this->url($site_settings['site_logo']) ?>" 
                             alt="Logo" 
                             style="max-height: 40px; margin-left: 10px;">
                    <?php else: ?>
                        <div class="dashboard-icon">
                            <div class="dashboard-icon-inner"></div>
                        </div>
                    <?php endif; ?>
                    <div class="dashboard-title-box">
                        <h1 class="dashboard-title">Dashboard</h1>
                        <p class="dashboard-subtitle"><?= $this->e($site_settings['site_name_en'] ?? 'PSOP') ?></p>
                    </div>
                </div>
            </div>
            <div class="dashboard-right">
                <a href="<?= $this->url('/') ?>" class="home-link" title="الصفحة الرئيسية">
                    <span class="home-icon">🏠</span>
                    <span class="home-text">الصفحة الرئيسية</span>
                </a>
                <?php if (isset($user)): ?>
                    <div class="user-profile-box">
                        <button class="user-profile-btn" id="userProfileBtn">
                            <span class="user-avatar-circle"><?= mb_substr($this->e($user['name']), 0, 1) ?></span>
                            <span class="user-display-name"><?= $this->e($user['name']) ?></span>
                            <span class="arrow-down">▼</span>
                        </button>
                        <div class="user-dropdown-panel" id="userDropdown" style="z-index: 9999;">
                            <a href="<?= $this->url('/profile') ?>" class="dropdown-item">الملف الشخصي</a>
                            <a href="<?= $this->url('/logout') ?>" class="dropdown-item logout">تسجيل الخروج</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="dashboard-layout">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <aside class="sidebar" id="dashboardSidebar">
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
                    <li><a href="<?= $this->url('/admin/activity-logs') ?>"><span>📈</span> سجل النشاطات</a></li>
                    
                    <!-- Content Management Dropdown -->
                    <li class="sidebar-dropdown">
                        <button class="sidebar-dropdown-toggle" onclick="toggleContentMenu(event)">
                            <span class="dropdown-content">
                                <span class="dropdown-icon">📝</span>
                                <span>إدارة المحتوى</span>
                            </span>
                            <span class="dropdown-arrow">▼</span>
                        </button>
                        <ul class="sidebar-submenu">
                            <li><a href="<?= $this->url('/admin/hero') ?>"><span>🎯</span> محتوى Hero Section</a></li>
                            <li><a href="<?= $this->url('/admin/slider') ?>"><span>🖼️</span> سلايدر الصفحة الرئيسية</a></li>
                            <li><a href="<?= $this->url('/admin/pages') ?>"><span>📄</span> إدارة الصفحات</a></li>
                            <li><a href="<?= $this->url('/admin/settings') ?>"><span>⚙️</span> إعدادات الموقع</a></li>
                        </ul>
                    </li>
                    
                    <!-- API Documentation -->
                    <li><a href="<?= $this->url('/api/docs') ?>" target="_blank"><span>🔌</span> توثيق API</a></li>
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
        // Mobile Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
            const dashboardSidebar = document.getElementById('dashboardSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            console.log('Sidebar elements:', {
                toggle: mobileSidebarToggle,
                sidebar: dashboardSidebar,
                overlay: sidebarOverlay
            });
            
            if (mobileSidebarToggle && dashboardSidebar && sidebarOverlay) {
                mobileSidebarToggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Toggle clicked');
                    dashboardSidebar.classList.toggle('active');
                    sidebarOverlay.classList.toggle('active');
                    mobileSidebarToggle.classList.toggle('active');
                });
                
                sidebarOverlay.addEventListener('click', () => {
                    console.log('Overlay clicked');
                    dashboardSidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    mobileSidebarToggle.classList.remove('active');
                });
                
                // Close sidebar when clicking a link on mobile
                const sidebarLinks = dashboardSidebar.querySelectorAll('a');
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        if (window.innerWidth <= 768) {
                            dashboardSidebar.classList.remove('active');
                            sidebarOverlay.classList.remove('active');
                            mobileSidebarToggle.classList.remove('active');
                        }
                    });
                });
            } else {
                console.error('Sidebar elements not found!');
            }
        });
        
        // User dropdown toggle
        document.addEventListener('DOMContentLoaded', function() {
            const userProfileBtn = document.getElementById('userProfileBtn');
            const userDropdown = document.getElementById('userDropdown');
            
            if (userProfileBtn && userDropdown) {
                userProfileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    e.preventDefault();
                    
                    // Toggle dropdown
                    const isActive = userDropdown.classList.toggle('active');
                    
                    // Position the dropdown using fixed positioning
                    if (isActive) {
                        const rect = userProfileBtn.getBoundingClientRect();
                        userDropdown.style.position = 'fixed';
                        userDropdown.style.top = (rect.bottom + 8) + 'px';
                        userDropdown.style.left = rect.left + 'px';
                        userDropdown.style.right = 'auto';
                    }
                });
                
                document.addEventListener('click', () => {
                    userDropdown.classList.remove('active');
                });
                
                userDropdown.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            }
        });
        
        // Settings dropdown toggle
        function toggleSettingsMenu(event) {
            event.preventDefault();
            event.stopPropagation();
            const button = event.currentTarget;
            const submenu = button.nextElementSibling;
            const arrow = button.querySelector('.dropdown-arrow');
            
            // Toggle active class
            button.classList.toggle('active');
            submenu.classList.toggle('active');
            
            // Rotate arrow
            if (submenu.classList.contains('active')) {
                arrow.style.transform = 'rotate(180deg)';
            } else {
                arrow.style.transform = 'rotate(0deg)';
            }
        }
        
        // Content dropdown toggle
        function toggleContentMenu(event) {
            event.preventDefault();
            event.stopPropagation();
            const button = event.currentTarget;
            const submenu = button.nextElementSibling;
            const arrow = button.querySelector('.dropdown-arrow');
            
            // Toggle active class
            button.classList.toggle('active');
            submenu.classList.toggle('active');
            
            // Rotate arrow
            if (submenu.classList.contains('active')) {
                arrow.style.transform = 'rotate(180deg)';
            } else {
                arrow.style.transform = 'rotate(0deg)';
            }
        }
    </script>
    
    <style>
        /* Sidebar Dropdown Styles */
        .sidebar-dropdown {
            margin-bottom: 4px;
        }
        
        .sidebar-dropdown-toggle {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 16px;
            color: #4b5563;
            background: transparent;
            border: none;
            transition: all 0.2s ease;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            text-align: right;
            font-family: 'Cairo', sans-serif;
        }
        
        .dropdown-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .dropdown-icon {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }
        
        .dropdown-arrow {
            font-size: 12px;
            transition: transform 0.3s ease;
        }
        
        .sidebar-dropdown-toggle:hover {
            background: #f3f4f6;
            color: var(--primary);
        }
        
        .sidebar-dropdown-toggle.active {
            background: #fef2f2;
            color: var(--primary);
        }
        
        .sidebar-submenu {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .sidebar-submenu.active {
            max-height: 300px;
            margin-top: 4px;
        }
        
        .sidebar-submenu li {
            margin-bottom: 2px;
        }
        
        .sidebar-submenu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px 10px 52px;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.2s ease;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .sidebar-submenu a span {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }
        
        .sidebar-submenu a:hover {
            background: #f9fafb;
            color: var(--primary);
            padding-right: 20px;
        }
    </style>
    
    <script src="<?= $this->asset('js/app.js') ?>"></script>
</body>
</html>
