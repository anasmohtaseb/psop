<div class="dashboard-header" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">إضافة تسجيل جديد</h1>
            <p style="color: var(--text-muted);">تسجيل طالب في مسابقة</p>
        </div>
        <a href="<?= $this->url('/admin/registrations') ?>" style="background: #6b7280; color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600;">
            ← العودة
        </a>
    </div>
</div>

<div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); max-width: 800px;">
    <form method="POST" action="<?= $this->url('/admin/registrations/store') ?>">
        <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
        
        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">المسابقة *</label>
            <select name="competition_edition_id" required style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px;">
                <option value="">اختر المسابقة...</option>
                <?php foreach ($editions as $edition): ?>
                    <option value="<?= $edition['id'] ?>" <?= ($_SESSION['old']['competition_edition_id'] ?? '') == $edition['id'] ? 'selected' : '' ?>>
                        <?= $this->e($edition['competition_name'] ?? 'مسابقة') ?> - <?= $edition['year'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($_SESSION['errors']['competition_edition_id'])): ?>
                <span style="color: #ef4444; font-size: 13px; display: block; margin-top: 6px;">
                    <?= $this->e($_SESSION['errors']['competition_edition_id'][0]) ?>
                </span>
            <?php endif; ?>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">الطالب *</label>
            <select name="student_user_id" id="studentSelect" required style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px;">
                <option value="">اختر الطالب...</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['id'] ?>" 
                            data-school="<?= $student['school_id'] ?? '' ?>"
                            <?= ($_SESSION['old']['student_user_id'] ?? '') == $student['id'] ? 'selected' : '' ?>>
                        <?= $this->e($student['name']) ?> - <?= $this->e($student['email']) ?>
                        <?php if (!empty($student['school_name'])): ?>
                            (<?= $this->e($student['school_name']) ?>)
                        <?php endif; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($_SESSION['errors']['student_user_id'])): ?>
                <span style="color: #ef4444; font-size: 13px; display: block; margin-top: 6px;">
                    <?= $this->e($_SESSION['errors']['student_user_id'][0]) ?>
                </span>
            <?php endif; ?>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">المدرسة *</label>
            <select name="school_id" id="schoolSelect" required style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px;">
                <option value="">اختر المدرسة...</option>
                <?php foreach ($schools as $school): ?>
                    <option value="<?= $school['id'] ?>" <?= ($_SESSION['old']['school_id'] ?? '') == $school['id'] ? 'selected' : '' ?>>
                        <?= $this->e($school['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($_SESSION['errors']['school_id'])): ?>
                <span style="color: #ef4444; font-size: 13px; display: block; margin-top: 6px;">
                    <?= $this->e($_SESSION['errors']['school_id'][0]) ?>
                </span>
            <?php endif; ?>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">نوع التسجيل *</label>
            <select name="registration_type" required style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px;">
                <option value="individual" <?= ($_SESSION['old']['registration_type'] ?? 'individual') === 'individual' ? 'selected' : '' ?>>فردي</option>
                <option value="team" <?= ($_SESSION['old']['registration_type'] ?? '') === 'team' ? 'selected' : '' ?>>جماعي</option>
            </select>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">الحالة *</label>
            <select name="status" required style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px;">
                <option value="submitted" <?= ($_SESSION['old']['status'] ?? 'submitted') === 'submitted' ? 'selected' : '' ?>>مقدمة</option>
                <option value="under_review" <?= ($_SESSION['old']['status'] ?? '') === 'under_review' ? 'selected' : '' ?>>قيد المراجعة</option>
                <option value="accepted_training" <?= ($_SESSION['old']['status'] ?? '') === 'accepted_training' ? 'selected' : '' ?>>مقبولة (تدريب)</option>
                <option value="accepted_final" <?= ($_SESSION['old']['status'] ?? '') === 'accepted_final' ? 'selected' : '' ?>>مقبولة (نهائي)</option>
                <option value="rejected" <?= ($_SESSION['old']['status'] ?? '') === 'rejected' ? 'selected' : '' ?>>مرفوضة</option>
            </select>
        </div>

        <div style="margin-bottom: 32px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">ملاحظات</label>
            <textarea name="notes" rows="4" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; resize: vertical;" placeholder="أضف ملاحظات إضافية..."><?= $_SESSION['old']['notes'] ?? '' ?></textarea>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" style="background: var(--primary); color: white; border: none; padding: 14px 32px; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; flex: 1;">
                إضافة التسجيل
            </button>
            <a href="<?= $this->url('/admin/registrations') ?>" style="background: #e5e7eb; color: var(--text-main); border: none; padding: 14px 32px; border-radius: 12px; font-size: 16px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                إلغاء
            </a>
        </div>
    </form>
</div>

<script>
// Auto-fill school when student is selected
document.getElementById('studentSelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const schoolId = selectedOption.getAttribute('data-school');
    
    if (schoolId) {
        document.getElementById('schoolSelect').value = schoolId;
    }
});
</script>

<?php
// Clear old input and errors
unset($_SESSION['old']);
unset($_SESSION['errors']);
?>
