<div class="page-header">
    <h1 class="page-title">مرحباً، <?= $this->e($user['name']) ?> 👋</h1>
    <p class="page-subtitle">لوحة تحكم المسؤول - إحصائيات وإدارة شاملة للنظام</p>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon bg-info-soft">👥</div>
            <span class="badge badge-info">نشط</span>
        </div>
        <div class="stat-value"><?= number_format($stats['total_users'] ?? 0) ?></div>
        <div class="stat-label">إجمالي المستخدمين</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon bg-success-soft">🎓</div>
            <span class="badge badge-success">طلاب</span>
        </div>
        <div class="stat-value"><?= number_format($stats['total_students'] ?? 0) ?></div>
        <div class="stat-label">الطلاب المسجلين</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon bg-warning-soft">🏫</div>
            <span class="badge badge-warning">مدارس</span>
        </div>
        <div class="stat-value"><?= number_format($stats['total_schools'] ?? 0) ?></div>
        <div class="stat-label">المدارس المشاركة</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon bg-danger-soft">📝</div>
            <span class="badge badge-danger">معلق</span>
        </div>
        <div class="stat-value"><?= number_format($stats['pending_registrations'] ?? 0) ?></div>
        <div class="stat-label">طلبات قيد الانتظار</div>
    </div>
</div>

<!-- Quick Actions -->
<div class="page-header">
    <h2 class="card-title" style="font-size: 1.25rem;">الوصول السريع</h2>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
    <a href="<?= $this->url('/admin/competitions') ?>" class="card" style="text-decoration: none; display: flex; align-items: center; gap: 1rem; margin-bottom: 0;">
        <div class="stat-icon bg-primary-soft">🏆</div>
        <div>
            <h3 class="card-title">إدارة المسابقات</h3>
            <p class="page-subtitle" style="font-size: 0.8rem; margin: 0;">عرض وإضافة المسابقات</p>
        </div>
    </a>

    <a href="<?= $this->url('/admin/schools') ?>" class="card" style="text-decoration: none; display: flex; align-items: center; gap: 1rem; margin-bottom: 0;">
        <div class="stat-icon bg-success-soft">🏫</div>
        <div>
            <h3 class="card-title">إدارة المدارس</h3>
            <p class="page-subtitle" style="font-size: 0.8rem; margin: 0;">عرض وإدارة المدارس</p>
        </div>
    </a>

    <a href="<?= $this->url('/admin/users') ?>" class="card" style="text-decoration: none; display: flex; align-items: center; gap: 1rem; margin-bottom: 0;">
        <div class="stat-icon bg-purple-soft">👥</div>
        <div>
            <h3 class="card-title">إدارة المستخدمين</h3>
            <p class="page-subtitle" style="font-size: 0.8rem; margin: 0;">التحكم بالمستخدمين والصلاحيات</p>
        </div>
    </a>
    
    <a href="<?= $this->url('/admin/activity-logs') ?>" class="card" style="text-decoration: none; display: flex; align-items: center; gap: 1rem; margin-bottom: 0;">
        <div class="stat-icon bg-warning-soft">📊</div>
        <div>
            <h3 class="card-title">سجل النشاطات</h3>
            <p class="page-subtitle" style="font-size: 0.8rem; margin: 0;">تتبع حركة النظام</p>
        </div>
    </a>
</div>

<!-- Content Management -->
<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
    <a href="<?= $this->url('/admin/slider') ?>" class="card" style="text-decoration: none; display: flex; align-items: center; gap: 1rem; margin-bottom: 0;">
        <div class="stat-icon bg-primary-soft" style="color: #ec4899; background: #fdf2f8;">🖼️</div>
        <div>
            <h3 class="card-title">السلايدر</h3>
            <p class="page-subtitle" style="font-size: 0.8rem; margin: 0;">تعديل الصور الرئيسية</p>
        </div>
    </a>

    <a href="<?= $this->url('/admin/pages') ?>" class="card" style="text-decoration: none; display: flex; align-items: center; gap: 1rem; margin-bottom: 0;">
        <div class="stat-icon bg-info-soft" style="color: #06b6d4; background: #ecfeff;">📄</div>
        <div>
            <h3 class="card-title">الصفحات</h3>
            <p class="page-subtitle" style="font-size: 0.8rem; margin: 0;">إدارة محتوى الصفحات</p>
        </div>
    </a>

    <a href="<?= $this->url('/admin/settings') ?>" class="card" style="text-decoration: none; display: flex; align-items: center; gap: 1rem; margin-bottom: 0;">
        <div class="stat-icon bg-dark-soft" style="color: #475569; background: #f1f5f9;">⚙️</div>
        <div>
            <h3 class="card-title">الإعدادات</h3>
            <p class="page-subtitle" style="font-size: 0.8rem; margin: 0;">البيانات الأساسية للموقع</p>
        </div>
    </a>
</div>

<!-- Layout Grid for Bottom Section -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
    <!-- Recent Registrations -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">آخر التسجيلات</h3>
            <a href="<?= $this->url('/admin/registrations') ?>" class="btn btn-sm btn-nav-action">عرض الكل</a>
        </div>
        
        <div class="card-body">
            <div style="text-align: center; padding: 2rem 0; color: var(--text-tertiary);">
                <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;">📋</div>
                <p>لا توجد تسجيلات حديثة لعرضها</p>
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">معلومات النظام</h3>
        </div>
        
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
                    <span class="page-subtitle">إصدار النظام</span>
                    <span style="font-weight: 700;">v1.0.0</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
                    <span class="page-subtitle">حالة النظام</span>
                    <span class="badge badge-success">نشط ومستقر</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
                    <span class="page-subtitle">آخر تحديث</span>
                    <span style="font-weight: 700;"><?= date('Y/m/d') ?></span>
                </div>
                
                 <div style="display: flex; justify-content: space-between;">
                    <span class="page-subtitle">قاعدة البيانات</span>
                    <span style="font-weight: 700;">MySQL</span>
                </div>
            </div>
            
            <div style="margin-top: 1.5rem;">
                <a href="<?= $this->url('/admin/settings') ?>" class="btn btn-primary" style="width: 100%;">
                    تحديث إعدادات النظام
                </a>
            </div>
        </div>
    </div>
</div>
