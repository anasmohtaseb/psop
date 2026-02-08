<div class="page-header" style="margin-bottom: 30px;">
    <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">
        مرحباً، <?= $this->e($user['name']) ?> 👋
    </h1>
    <p style="color: var(--text-muted);">لوحة تحكم المسؤول - إحصائيات وإدارة شاملة للنظام</p>
</div>

<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px;">
    <div class="card" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border-radius: 16px; padding: 24px; border: none; box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
            <div style="font-size: 36px;">👥</div>
            <div style="background: rgba(255, 255, 255, 0.2); padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 600;">
                نشط
            </div>
        </div>
        <div style="font-size: 36px; font-weight: 700; margin-bottom: 4px;">
            <?= number_format($stats['total_users'] ?? 0) ?>
        </div>
        <div style="font-size: 14px; opacity: 0.9;">إجمالي المستخدمين</div>
    </div>

    <div class="card" style="background: linear-gradient(135deg, #22c55e, #16a34a); color: white; border-radius: 16px; padding: 24px; border: none; box-shadow: 0 10px 30px rgba(34, 197, 94, 0.3);">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
            <div style="font-size: 36px;">🎓</div>
            <div style="background: rgba(255, 255, 255, 0.2); padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 600;">
                طلاب
            </div>
        </div>
        <div style="font-size: 36px; font-weight: 700; margin-bottom: 4px;">
            <?= number_format($stats['total_students'] ?? 0) ?>
        </div>
        <div style="font-size: 14px; opacity: 0.9;">الطلاب المسجلين</div>
    </div>

    <div class="card" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border-radius: 16px; padding: 24px; border: none; box-shadow: 0 10px 30px rgba(245, 158, 11, 0.3);">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
            <div style="font-size: 36px;">🏫</div>
            <div style="background: rgba(255, 255, 255, 0.2); padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 600;">
                مدارس
            </div>
        </div>
        <div style="font-size: 36px; font-weight: 700; margin-bottom: 4px;">
            <?= number_format($stats['total_schools'] ?? 0) ?>
        </div>
        <div style="font-size: 14px; opacity: 0.9;">المدارس المشاركة</div>
    </div>

    <div class="card" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border-radius: 16px; padding: 24px; border: none; box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
            <div style="font-size: 36px;">📝</div>
            <div style="background: rgba(255, 255, 255, 0.2); padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 600;">
                قيد الانتظار
            </div>
        </div>
        <div style="font-size: 36px; font-weight: 700; margin-bottom: 4px;">
            <?= number_format($stats['pending_registrations'] ?? 0) ?>
        </div>
        <div style="font-size: 14px; opacity: 0.9;">طلبات معلقة</div>
    </div>
</div>

<!-- Quick Actions -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px;">
    <a href="<?= $this->url('/admin/competitions') ?>" 
       class="card" 
       style="background: white; border-radius: 16px; padding: 24px; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; display: block;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--primary), #f97316); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                🏆
            </div>
            <div>
                <h3 style="color: var(--text-main); font-size: 18px; margin-bottom: 4px;">إدارة المسابقات</h3>
                <p style="color: var(--text-muted); font-size: 13px; margin: 0;">عرض وإضافة المسابقات</p>
            </div>
        </div>
    </a>

    <a href="<?= $this->url('/admin/schools') ?>" 
       class="card" 
       style="background: white; border-radius: 16px; padding: 24px; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; display: block;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                🏫
            </div>
            <div>
                <h3 style="color: var(--text-main); font-size: 18px; margin-bottom: 4px;">إدارة المدارس</h3>
                <p style="color: var(--text-muted); font-size: 13px; margin: 0;">عرض وإدارة المدارس</p>
            </div>
        </div>
    </a>

    <a href="<?= $this->url('/admin/users') ?>" 
       class="card" 
       style="background: white; border-radius: 16px; padding: 24px; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; display: block;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                👥
            </div>
            <div>
                <h3 style="color: var(--text-main); font-size: 18px; margin-bottom: 4px;">إدارة المستخدمين</h3>
                <p style="color: var(--text-muted); font-size: 13px; margin: 0;">عرض وإدارة المستخدمين</p>
            </div>
        </div>
    </a>
</div>

<!-- Hero Section & Content Management -->
<h2 style="color: var(--text-main); font-size: 22px; margin: 40px 0 20px;">إدارة المحتوى</h2>
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px;">
    <a href="<?= $this->url('/admin/hero') ?>" 
       class="card" 
       style="background: white; border-radius: 16px; padding: 24px; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; display: block;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                🎯
            </div>
            <div>
                <h3 style="color: var(--text-main); font-size: 18px; margin-bottom: 4px;">محتوى Hero Section</h3>
                <p style="color: var(--text-muted); font-size: 13px; margin: 0;">النص بجانب السلايدر</p>
            </div>
        </div>
    </a>

    <a href="<?= $this->url('/admin/slider') ?>" 
       class="card" 
       style="background: white; border-radius: 16px; padding: 24px; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; display: block;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #ec4899, #db2777); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                🖼️
            </div>
            <div>
                <h3 style="color: var(--text-main); font-size: 18px; margin-bottom: 4px;">سلايدر الصفحة الرئيسية</h3>
                <p style="color: var(--text-muted); font-size: 13px; margin: 0;">إدارة صور Hero Section</p>
            </div>
        </div>
    </a>

    <a href="<?= $this->url('/admin/pages') ?>" 
       class="card" 
       style="background: white; border-radius: 16px; padding: 24px; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; display: block;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #06b6d4, #0891b2); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                📄
            </div>
            <div>
                <h3 style="color: var(--text-main); font-size: 18px; margin-bottom: 4px;">إدارة الصفحات</h3>
                <p style="color: var(--text-muted); font-size: 13px; margin: 0;">تعديل محتوى الصفحات</p>
            </div>
        </div>
    </a>

    <a href="<?= $this->url('/admin/settings') ?>" 
       class="card" 
       style="background: white; border-radius: 16px; padding: 24px; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; display: block;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #64748b, #475569); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                ⚙️
            </div>
            <div>
                <h3 style="color: var(--text-main); font-size: 18px; margin-bottom: 4px;">إعدادات الموقع</h3>
                <p style="color: var(--text-muted); font-size: 13px; margin: 0;">شعار، عنوان، معلومات الاتصال</p>
            </div>
        </div>
    </a>

    <a href="<?= $this->url('/admin/activity-logs') ?>" 
       class="card" 
       style="background: white; border-radius: 16px; padding: 24px; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; display: block;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                📊
            </div>
            <div>
                <h3 style="color: var(--text-main); font-size: 18px; margin-bottom: 4px;">سجل النشاطات</h3>
                <p style="color: var(--text-muted); font-size: 13px; margin: 0;">تتبع إجراءات المستخدمين</p>
            </div>
        </div>
    </a>
</div>

<!-- Recent Activity & System Info -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
    <!-- Recent Registrations -->
    <div class="card" style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="color: var(--text-main); font-size: 20px; margin: 0;">آخر التسجيلات</h2>
            <a href="<?= $this->url('/admin/registrations') ?>" 
               style="color: var(--primary); font-size: 13px; font-weight: 600; text-decoration: none;">
                عرض الكل ←
            </a>
        </div>
        
        <div style="text-align: center; padding: 40px 0; color: var(--text-muted);">
            <div style="font-size: 48px; margin-bottom: 12px;">📋</div>
            <p>لا توجد تسجيلات حديثة</p>
        </div>
    </div>

    <!-- System Info -->
    <div class="card" style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 24px;">
        <h2 style="color: var(--text-main); font-size: 20px; margin-bottom: 20px;">معلومات النظام</h2>
        
        <div style="display: grid; gap: 16px;">
            <div>
                <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 4px;">إصدار النظام</div>
                <div style="font-weight: 600; color: var(--text-main);">v1.0.0</div>
            </div>
            
            <div>
                <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 4px;">حالة النظام</div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%; display: inline-block;"></span>
                    <span style="font-weight: 600; color: #22c55e;">نشط</span>
                </div>
            </div>
            
            <div>
                <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 4px;">آخر تحديث</div>
                <div style="font-weight: 600; color: var(--text-main);"><?= date('Y/m/d') ?></div>
            </div>

            <div style="padding-top: 16px; border-top: 1px solid rgba(148, 163, 184, 0.1);">
                <a href="<?= $this->url('/admin/settings') ?>" 
                   class="btn btn-outline" 
                   style="width: 100%; text-align: center; text-decoration: none; display: block;">
                    ⚙️ إعدادات النظام
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.1) !important;
}
</style>
