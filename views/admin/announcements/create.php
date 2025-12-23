<?php
/**
 * Create Announcement View
 */
?>

<div class="content-header">
    <div class="header-title">
        <h1>إعلان جديد</h1>
        <p>إنشاء إعلان جديد في النظام</p>
    </div>
</div>

<div class="form-container">
    <form method="POST" action="<?= $this->url('/admin/announcements/store') ?>" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

        <div class="form-group">
            <label for="title">عنوان الإعلان <span class="required">*</span></label>
            <input type="text" id="title" name="title" class="form-control" 
                   value="<?= $this->e($_SESSION['old']['title'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="content">محتوى الإعلان <span class="required">*</span></label>
            <textarea id="content" name="content" class="form-control" rows="8" required><?= $this->e($_SESSION['old']['content'] ?? '') ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="target_audience">الجمهور المستهدف <span class="required">*</span></label>
                <select id="target_audience" name="target_audience" class="form-control" required>
                    <option value="all">الجميع</option>
                    <option value="students">الطلاب</option>
                    <option value="coordinators">منسقو المدارس</option>
                    <option value="trainers">المدربون</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">الحالة <span class="required">*</span></label>
                <select id="status" name="status" class="form-control" required>
                    <option value="draft">مسودة</option>
                    <option value="published">منشور</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="publish_date">تاريخ النشر (اختياري)</label>
            <input type="date" id="publish_date" name="publish_date" class="form-control"
                   value="<?= $this->e($_SESSION['old']['publish_date'] ?? '') ?>">
            <small class="form-help">اتركه فارغاً للنشر فوراً</small>
        </div>

        <div class="form-actions">
            <a href="<?= $this->url('/admin/announcements') ?>" class="btn btn-secondary">إلغاء</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> حفظ الإعلان
            </button>
        </div>
    </form>
</div>

<?php unset($_SESSION['old']); ?>

<style>
.form-container {
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    max-width: 900px;
}

.admin-form .form-group {
    margin-bottom: 20px;
}

.admin-form .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.admin-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #374151;
}

.admin-form .required {
    color: #e11d48;
}

.admin-form .form-control {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 15px;
    font-family: 'Cairo', sans-serif;
}

.admin-form textarea.form-control {
    resize: vertical;
    min-height: 150px;
}

.admin-form .form-help {
    display: block;
    margin-top: 5px;
    font-size: 13px;
    color: #6b7280;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}
</style>
