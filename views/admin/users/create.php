<div class="dashboard-header" style="margin-bottom: 30px;">
    <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">إضافة مستخدم جديد</h1>
    <p style="color: var(--text-muted);">املأ البيانات لإضافة مستخدم جديد للنظام</p>
</div>

<div class="card" style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 30px; max-width: 900px;">
    <form method="POST" action="<?= $this->url('/admin/users/store') ?>">
        <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
        
        <div style="display: grid; gap: 24px;">
            <!-- Name -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    الاسم الكامل <span style="color: var(--primary);">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       required
                       value="<?= $this->e($_SESSION['old']['name'] ?? '') ?>"
                       style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
                <?php if (isset($_SESSION['errors']['name'])): ?>
                    <div style="color: var(--primary); font-size: 14px; margin-top: 6px;"><?= $_SESSION['errors']['name'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    البريد الإلكتروني <span style="color: var(--primary);">*</span>
                </label>
                <input type="email" 
                       name="email" 
                       required
                       value="<?= $this->e($_SESSION['old']['email'] ?? '') ?>"
                       style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
                <?php if (isset($_SESSION['errors']['email'])): ?>
                    <div style="color: var(--primary); font-size: 14px; margin-top: 6px;"><?= $_SESSION['errors']['email'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    كلمة المرور <span style="color: var(--primary);">*</span>
                </label>
                <input type="password" 
                       name="password" 
                       required
                       minlength="6"
                       style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
                <div style="color: var(--text-muted); font-size: 13px; margin-top: 6px;">يجب أن تكون 6 أحرف على الأقل</div>
                <?php if (isset($_SESSION['errors']['password'])): ?>
                    <div style="color: var(--primary); font-size: 14px; margin-top: 6px;"><?= $_SESSION['errors']['password'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    رقم الهاتف
                </label>
                <input type="tel" 
                       name="phone" 
                       value="<?= $this->e($_SESSION['old']['phone'] ?? '') ?>"
                       style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
            </div>

            <!-- User Type -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    نوع المستخدم <span style="color: var(--primary);">*</span>
                </label>
                <select name="type" 
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
                    <option value="">اختر نوع المستخدم</option>
                    <option value="student" <?= ($_SESSION['old']['type'] ?? '') === 'student' ? 'selected' : '' ?>>طالب</option>
                    <option value="school_coordinator" <?= ($_SESSION['old']['type'] ?? '') === 'school_coordinator' ? 'selected' : '' ?>>منسق مدرسة</option>
                    <option value="trainer" <?= ($_SESSION['old']['type'] ?? '') === 'trainer' ? 'selected' : '' ?>>مدرب</option>
                    <option value="admin" <?= ($_SESSION['old']['type'] ?? '') === 'admin' ? 'selected' : '' ?>>مدير</option>
                    <option value="competition_manager" <?= ($_SESSION['old']['type'] ?? '') === 'competition_manager' ? 'selected' : '' ?>>مدير مسابقات</option>
                </select>
                <?php if (isset($_SESSION['errors']['type'])): ?>
                    <div style="color: var(--primary); font-size: 14px; margin-top: 6px;"><?= $_SESSION['errors']['type'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    الحالة
                </label>
                <select name="status" 
                        style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
                    <option value="active" <?= ($_SESSION['old']['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>نشط</option>
                    <option value="inactive" <?= ($_SESSION['old']['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>غير نشط</option>
                    <option value="pending" <?= ($_SESSION['old']['status'] ?? '') === 'pending' ? 'selected' : '' ?>>قيد الانتظار</option>
                    <option value="suspended" <?= ($_SESSION['old']['status'] ?? '') === 'suspended' ? 'selected' : '' ?>>موقوف</option>
                </select>
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; gap: 12px; margin-top: 10px;">
                <button type="submit" style="flex: 1; background: var(--primary); color: white; padding: 14px; border: none; border-radius: 12px; font-weight: 600; font-size: 16px; cursor: pointer; transition: all 0.2s;">
                    إضافة المستخدم
                </button>
                <a href="<?= $this->url('/admin/users') ?>" style="flex: 1; background: #e2e8f0; color: var(--text-main); padding: 14px; border-radius: 12px; font-weight: 600; font-size: 16px; text-align: center; text-decoration: none; transition: all 0.2s; display: flex; align-items: center; justify-content: center;">
                    إلغاء
                </a>
            </div>
        </div>
    </form>
</div>

<?php
// Clear old input and errors
unset($_SESSION['old']);
unset($_SESSION['errors']);
?>

<style>
input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.1);
}

button[type="submit"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(225, 29, 72, 0.3);
}

a[href*="users"]:hover {
    background: #cbd5e1;
}
</style>
