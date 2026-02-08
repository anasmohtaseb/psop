<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - <?= $site_settings['site_name_en'] ?? 'PSOP' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Load new admin theme -->
    <link rel="stylesheet" href="<?= $this->asset('css/admin-theme.css') ?>">
</head>
<body>
    <div class="app-container">
        <!-- Mobile Overlay -->
        <div class="overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <aside class="app-sidebar" id="appSidebar">
            <div class="sidebar-header">
                <a href="<?= $this->url('/') ?>" class="app-brand">
                    <?php if (!empty($site_settings['site_logo'])): ?>
                        <img src="<?= $this->url($site_settings['site_logo']) ?>" alt="Logo" style="height: 32px;">
                    <?php else: ?>
                        <span style="font-size: 1.5rem;">🚀</span>
                    <?php endif; ?>
                </a>
            </div>

            <div class="sidebar-content">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="<?= $this->url('/dashboard') ?>" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false && strpos($_SERVER['REQUEST_URI'], '/dashboard/') === false ? 'active' : '' ?>">
                            <span class="nav-icon">📊</span>
                            <span>الرئيسية</span>
                        </a>
                    </li>
                    
                    <?php if (isset($user) && $user['type'] === 'student'): ?>
                        <div class="nav-header">الطالب</div>
                        <li class="nav-item">
                            <a href="<?= $this->url('/subscriptions/my-subscription') ?>" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'my-subscription') !== false ? 'active' : '' ?>">
                                <span class="nav-icon">💳</span>
                                <span>اشتراكي</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->url('/dashboard/registrations') ?>" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'registrations') !== false ? 'active' : '' ?>">
                                <span class="nav-icon">📝</span>
                                <span>تسجيلاتي</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->url('/dashboard/profile') ?>" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'profile') !== false ? 'active' : '' ?>">
                                <span class="nav-icon">👤</span>
                                <span>الملف الشخصي</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if (isset($user) && $user['type'] === 'school_coordinator'): ?>
                        <div class="nav-header">منسق المدرسة</div>
                        <li class="nav-item">
                            <a href="<?= $this->url('/dashboard/students') ?>" class="nav-link">
                                <span class="nav-icon">👥</span>
                                <span>الطلاب</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->url('/dashboard/school') ?>" class="nav-link">
                                <span class="nav-icon">🏫</span>
                                <span>بيانات المدرسة</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->url('/dashboard/registrations') ?>" class="nav-link">
                                <span class="nav-icon">📝</span>
                                <span>التسجيلات</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if (isset($user) && in_array($user['type'], ['admin', 'competition_manager'])): ?>
                        <div class="nav-header">الإدارة</div>
                        
                        <li class="nav-item">
                            <a href="<?= $this->url('/admin/users') ?>" class="nav-link">
                                <span class="nav-icon">👥</span>
                                <span>المستخدمون</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->url('/admin/schools') ?>" class="nav-link">
                                <span class="nav-icon">🏫</span>
                                <span>المدارس</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->url('/admin/competitions') ?>" class="nav-link">
                                <span class="nav-icon">🏆</span>
                                <span>المسابقات</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->url('/admin/registrations') ?>" class="nav-link">
                                <span class="nav-icon">📋</span>
                                <span>التسجيلات</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->url('/admin/subscriptions') ?>" class="nav-link">
                                <span class="nav-icon">💳</span>
                                <span>الاشتراكات</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->url('/admin/announcements') ?>" class="nav-link">
                                <span class="nav-icon">📢</span>
                                <span>الإعلانات</span>
                            </a>
                        </li>

                        <!-- Content Management Dropdown -->
                        <li class="nav-item nav-dropdown">
                            <button class="nav-link nav-dropdown-toggle">
                                <div style="display: flex; gap: 0.75rem; align-items: center;">
                                    <span class="nav-icon">📝</span>
                                    <span>إدارة المحتوى</span>
                                </div>
                                <span style="font-size: 0.7rem;">▼</span>
                            </button>
                            <ul class="nav-dropdown-menu">
                                <li>
                                    <a href="<?= $this->url('/admin/hero') ?>" class="nav-link">
                                        <span class="nav-icon">🎯</span>
                                        <span>Hero Section</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $this->url('/admin/slider') ?>" class="nav-link">
                                        <span class="nav-icon">🖼️</span>
                                        <span>السلايدر</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $this->url('/admin/pages') ?>" class="nav-link">
                                        <span class="nav-icon">📄</span>
                                        <span>الصفحات</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $this->url('/admin/settings') ?>" class="nav-link">
                                        <span class="nav-icon">⚙️</span>
                                        <span>إعدادات الموقع</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $this->url('/admin/subscriptions/plans') ?>" class="nav-link">
                                        <span class="nav-icon">📊</span>
                                        <span>خطط الاشتراك</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <div class="nav-header">النظام</div>
                        <li class="nav-item">
                            <a href="<?= $this->url('/admin/activity-logs') ?>" class="nav-link">
                                <span class="nav-icon">📈</span>
                                <span>سجل النشاطات</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->url('/api/docs') ?>" target="_blank" class="nav-link">
                                <span class="nav-icon">🔌</span>
                                <span>توثيق API</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </aside>

        <!-- Header -->
        <header class="app-header">
            <div class="header-left">
                <button class="mobile-toggle" id="sidebarToggle">
                    ☰
                </button>
                <div class="header-search hide-mobile">
                    <!-- Optional: Search bar -->
                </div>
            </div>
            
            <div class="header-right">
                <a href="<?= $this->url('/') ?>" class="btn btn-sm btn-nav-action hide-mobile" title="الصفحة الرئيسية">
                    🏠 الموقع
                </a>
                
                <?php if (isset($user)): ?>
                    <div class="user-menu" tabindex="0">
                        <div class="user-info hide-mobile">
                            <div class="user-name"><?= $this->e($user['name']) ?></div>
                            <div class="user-role"><?= $user['type'] ?></div>
                        </div>
                        <div class="user-avatar">
                            <?= mb_substr($this->e($user['name']), 0, 1) ?>
                        </div>
                        
                        <!-- Dropdown -->
                        <div class="dropdown-panel">
                            <div style="padding: 1rem; border-bottom: 1px solid var(--border-color); margin-bottom: 0.5rem;" class="hide-desktop">
                                <strong><?= $this->e($user['name']) ?></strong>
                            </div>
                            <a href="<?= $this->url('/profile') ?>" class="dropdown-link">الملف الشخصي</a>
                            <div style="border-top: 1px solid var(--border-color); margin: 0.5rem 0;"></div>
                            <a href="<?= $this->url('/logout') ?>" class="dropdown-link danger">تسجيل الخروج</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </header>

        <!-- Main Content -->
        <main class="app-content">
            <?php if (isset($_SESSION['flash'])): ?>
                <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                    <div class="alert alert-<?= $type == 'error' ? 'danger' : $type ?>">
                        <?= $this->e($message) ?>
                    </div>
                    <?php unset($_SESSION['flash'][$type]); ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?= $viewContent ?>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar Toggle
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('appSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            function toggleSidebar() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }
            
            if(toggleBtn) {
                toggleBtn.addEventListener('click', toggleSidebar);
            }
            
            if(overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }
            
            // Dropdown Menus in Sidebar
            const dropdownToggles = document.querySelectorAll('.nav-dropdown-toggle');
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const parent = this.parentElement;
                    parent.classList.toggle('active');
                    
                    // Rotate arrow
                    const arrow = this.querySelector('span:last-child');
                    if (arrow) {
                        arrow.style.transform = parent.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
                    }
                });
            });
        });
    </script>
</body>
</html>
