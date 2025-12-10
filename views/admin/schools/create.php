<div class="dashboard-header" style="margin-bottom: 30px;">
    <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">إضافة مدرسة جديدة</h1>
    <p style="color: var(--text-muted);">املأ البيانات لإضافة مدرسة جديدة للنظام</p>
</div>

<div class="card" style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 30px; max-width: 900px;">
    <form method="POST" action="<?= $this->url('/admin/schools/store') ?>">
        <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
        
        <div style="display: grid; gap: 24px;">
            <!-- Name -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    اسم المدرسة <span style="color: var(--primary);">*</span>
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

            <!-- Type -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    نوع المدرسة <span style="color: var(--primary);">*</span>
                </label>
                <select name="type" 
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
                    <option value="">اختر نوع المدرسة</option>
                    <option value="government" <?= ($_SESSION['old']['type'] ?? '') === 'government' ? 'selected' : '' ?>>حكومية</option>
                    <option value="private" <?= ($_SESSION['old']['type'] ?? '') === 'private' ? 'selected' : '' ?>>خاصة</option>
                    <option value="unrwa" <?= ($_SESSION['old']['type'] ?? '') === 'unrwa' ? 'selected' : '' ?>>وكالة</option>
                </select>
                <?php if (isset($_SESSION['errors']['type'])): ?>
                    <div style="color: var(--primary); font-size: 14px; margin-top: 6px;"><?= $_SESSION['errors']['type'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Governorate -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    المحافظة <span style="color: var(--primary);">*</span>
                </label>
                <select name="governorate" 
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
                    <option value="">اختر المحافظة</option>
                    <option value="الخليل" <?= ($_SESSION['old']['governorate'] ?? '') === 'الخليل' ? 'selected' : '' ?>>الخليل</option>
                    <option value="رام الله" <?= ($_SESSION['old']['governorate'] ?? '') === 'رام الله' ? 'selected' : '' ?>>رام الله</option>
                    <option value="القدس" <?= ($_SESSION['old']['governorate'] ?? '') === 'القدس' ? 'selected' : '' ?>>القدس</option>
                    <option value="نابلس" <?= ($_SESSION['old']['governorate'] ?? '') === 'نابلس' ? 'selected' : '' ?>>نابلس</option>
                    <option value="بيت لحم" <?= ($_SESSION['old']['governorate'] ?? '') === 'بيت لحم' ? 'selected' : '' ?>>بيت لحم</option>
                    <option value="جنين" <?= ($_SESSION['old']['governorate'] ?? '') === 'جنين' ? 'selected' : '' ?>>جنين</option>
                    <option value="طولكرم" <?= ($_SESSION['old']['governorate'] ?? '') === 'طولكرم' ? 'selected' : '' ?>>طولكرم</option>
                    <option value="قلقيلية" <?= ($_SESSION['old']['governorate'] ?? '') === 'قلقيلية' ? 'selected' : '' ?>>قلقيلية</option>
                    <option value="سلفيت" <?= ($_SESSION['old']['governorate'] ?? '') === 'سلفيت' ? 'selected' : '' ?>>سلفيت</option>
                    <option value="أريحا" <?= ($_SESSION['old']['governorate'] ?? '') === 'أريحا' ? 'selected' : '' ?>>أريحا</option>
                    <option value="طوباس" <?= ($_SESSION['old']['governorate'] ?? '') === 'طوباس' ? 'selected' : '' ?>>طوباس</option>
                    <option value="غزة" <?= ($_SESSION['old']['governorate'] ?? '') === 'غزة' ? 'selected' : '' ?>>غزة</option>
                    <option value="خان يونس" <?= ($_SESSION['old']['governorate'] ?? '') === 'خان يونس' ? 'selected' : '' ?>>خان يونس</option>
                    <option value="رفح" <?= ($_SESSION['old']['governorate'] ?? '') === 'رفح' ? 'selected' : '' ?>>رفح</option>
                    <option value="الشمال" <?= ($_SESSION['old']['governorate'] ?? '') === 'الشمال' ? 'selected' : '' ?>>الشمال</option>
                    <option value="الوسطى" <?= ($_SESSION['old']['governorate'] ?? '') === 'الوسطى' ? 'selected' : '' ?>>الوسطى</option>
                </select>
                <?php if (isset($_SESSION['errors']['governorate'])): ?>
                    <div style="color: var(--primary); font-size: 14px; margin-top: 6px;"><?= $_SESSION['errors']['governorate'] ?></div>
                <?php endif; ?>
            </div>

            <!-- City -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    المدينة <span style="color: var(--primary);">*</span>
                </label>
                <input type="text" 
                       name="city" 
                       required
                       value="<?= $this->e($_SESSION['old']['city'] ?? '') ?>"
                       style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
                <?php if (isset($_SESSION['errors']['city'])): ?>
                    <div style="color: var(--primary); font-size: 14px; margin-top: 6px;"><?= $_SESSION['errors']['city'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    العنوان
                </label>
                <textarea name="address" 
                          rows="3"
                          style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s; resize: vertical;"><?= $this->e($_SESSION['old']['address'] ?? '') ?></textarea>
            </div>

            <!-- Contact Phone -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    رقم الهاتف
                </label>
                <input type="tel" 
                       name="contact_phone" 
                       value="<?= $this->e($_SESSION['old']['contact_phone'] ?? '') ?>"
                       style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
            </div>

            <!-- Contact Email -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    البريد الإلكتروني
                </label>
                <input type="email" 
                       name="contact_email" 
                       value="<?= $this->e($_SESSION['old']['contact_email'] ?? '') ?>"
                       style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
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
                </select>
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; gap: 12px; margin-top: 10px;">
                <button type="submit" style="flex: 1; background: var(--primary); color: white; padding: 14px; border: none; border-radius: 12px; font-weight: 600; font-size: 16px; cursor: pointer; transition: all 0.2s;">
                    إضافة المدرسة
                </button>
                <a href="<?= $this->url('/admin/schools') ?>" style="flex: 1; background: #e2e8f0; color: var(--text-main); padding: 14px; border-radius: 12px; font-weight: 600; font-size: 16px; text-align: center; text-decoration: none; transition: all 0.2s; display: flex; align-items: center; justify-content: center;">
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

a[href*="schools"]:hover {
    background: #cbd5e1;
}
</style>
