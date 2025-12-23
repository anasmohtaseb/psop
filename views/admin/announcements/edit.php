<?php
/**
 * Edit Announcement View
 */
?>

<div class="content-header">
    <div class="header-title">
        <h1>تعديل الإعلان</h1>
        <p>تحديث بيانات الإعلان</p>
    </div>
</div>

<div class="form-container">
    <form method="POST" action="<?= $this->url('/admin/announcements/update') ?>" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <input type="hidden" name="id" value="<?= $announcement['id'] ?>">

        <div class="form-group">
            <label for="title">عنوان الإعلان <span class="required">*</span></label>
            <input type="text" id="title" name="title" class="form-control" 
                   value="<?= $this->e($announcement['title']) ?>" required>
        </div>

        <div class="form-group">
            <label for="content">محتوى الإعلان <span class="required">*</span></label>
            <textarea id="content" name="content" class="form-control" rows="8" required><?= $this->e($announcement['content']) ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="target_audience">الجمهور المستهدف <span class="required">*</span></label>
                <select id="target_audience" name="target_audience" class="form-control" required>
                    <option value="all" <?= $announcement['target_audience'] === 'all' ? 'selected' : '' ?>>الجميع</option>
                    <option value="students" <?= $announcement['target_audience'] === 'students' ? 'selected' : '' ?>>الطلاب</option>
                    <option value="coordinators" <?= $announcement['target_audience'] === 'coordinators' ? 'selected' : '' ?>>منسقو المدارس</option>
                    <option value="trainers" <?= $announcement['target_audience'] === 'trainers' ? 'selected' : '' ?>>المدربون</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">الحالة <span class="required">*</span></label>
                <select id="status" name="status" class="form-control" required>
                    <option value="draft" <?= $announcement['status'] === 'draft' ? 'selected' : '' ?>>مسودة</option>
                    <option value="published" <?= $announcement['status'] === 'published' ? 'selected' : '' ?>>منشور</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="publish_date">تاريخ النشر (اختياري)</label>
            <input type="date" id="publish_date" name="publish_date" class="form-control"
                   value="<?= $this->e($announcement['publish_date'] ?? '') ?>">
            <small class="form-help">اتركه فارغاً للنشر فوراً</small>
        </div>

        <div class="form-actions">
            <a href="<?= $this->url('/admin/announcements') ?>" class="btn btn-secondary">إلغاء</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> حفظ التعديلات
            </button>
        </div>
    </form>
</div>

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
