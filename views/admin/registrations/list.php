<div class="dashboard-header" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">إدارة التسجيلات</h1>
            <p style="color: var(--text-muted);">عرض وإدارة جميع تسجيلات الطلاب في المسابقات</p>
        </div>
        <a href="<?= $this->url('/admin/registrations/create') ?>" style="background: var(--primary); color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <span style="font-size: 20px;">➕</span>
            إضافة تسجيل جديد
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 8px;">إجمالي التسجيلات</div>
        <div style="font-size: 32px; font-weight: 700; color: var(--text-main);"><?= $stats['total'] ?></div>
    </div>
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 8px;">مقدمة</div>
        <div style="font-size: 32px; font-weight: 700; color: #3b82f6;"><?= $stats['submitted'] ?></div>
    </div>
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 8px;">قيد المراجعة</div>
        <div style="font-size: 32px; font-weight: 700; color: #f59e0b;"><?= $stats['under_review'] ?></div>
    </div>
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 8px;">مقبولة (تدريب)</div>
        <div style="font-size: 32px; font-weight: 700; color: #10b981;"><?= $stats['accepted_training'] ?></div>
    </div>
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 8px;">مقبولة (نهائي)</div>
        <div style="font-size: 32px; font-weight: 700; color: #059669;"><?= $stats['accepted_final'] ?></div>
    </div>
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 8px;">مرفوضة</div>
        <div style="font-size: 32px; font-weight: 700; color: #ef4444;"><?= $stats['rejected'] ?></div>
    </div>
</div>

<!-- Filters -->
<div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px; align-items: end;">
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 14px;">البحث</label>
            <input type="text" name="search" value="<?= $this->e($filters['search']) ?>" placeholder="اسم الطالب أو البريد أو المدرسة..." style="width: 100%; padding: 10px 14px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 10px; font-size: 14px;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 14px;">المسابقة</label>
            <select name="competition" style="width: 100%; padding: 10px 14px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 10px; font-size: 14px;">
                <option value="">الكل</option>
                <?php foreach ($competitions as $comp): ?>
                    <option value="<?= $comp['id'] ?>" <?= $filters['competition'] == $comp['id'] ? 'selected' : '' ?>>
                        <?= $this->e($comp['competition_name'] ?? 'مسابقة') ?> - <?= $comp['year'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 14px;">الحالة</label>
            <select name="status" style="width: 100%; padding: 10px 14px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 10px; font-size: 14px;">
                <option value="">الكل</option>
                <option value="submitted" <?= $filters['status'] === 'submitted' ? 'selected' : '' ?>>مقدمة</option>
                <option value="under_review" <?= $filters['status'] === 'under_review' ? 'selected' : '' ?>>قيد المراجعة</option>
                <option value="accepted_training" <?= $filters['status'] === 'accepted_training' ? 'selected' : '' ?>>مقبولة (تدريب)</option>
                <option value="accepted_final" <?= $filters['status'] === 'accepted_final' ? 'selected' : '' ?>>مقبولة (نهائي)</option>
                <option value="rejected" <?= $filters['status'] === 'rejected' ? 'selected' : '' ?>>مرفوضة</option>
                <option value="cancelled" <?= $filters['status'] === 'cancelled' ? 'selected' : '' ?>>ملغاة</option>
            </select>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: var(--primary); color: white; padding: 10px 24px; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer;">
                🔍 بحث
            </button>
            <a href="<?= $this->url('/admin/registrations') ?>" style="background: #6b7280; color: white; padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center;">
                إعادة تعيين
            </a>
        </div>
    </form>
</div>

<!-- Registrations Table -->
<div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <h2 style="color: var(--text-main); font-size: 20px; margin-bottom: 20px; font-weight: 700;">التسجيلات</h2>
    
    <?php if (empty($registrations)): ?>
        <div style="text-align: center; padding: 40px; color: var(--text-muted);">
            <div style="font-size: 48px; margin-bottom: 16px;">📋</div>
            <p style="font-size: 16px;">لا توجد تسجيلات</p>
        </div>
    <?php else: ?>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                        <th style="padding: 12px; text-align: right; font-weight: 600; color: var(--text-main);">الطالب</th>
                        <th style="padding: 12px; text-align: right; font-weight: 600; color: var(--text-main);">المدرسة</th>
                        <th style="padding: 12px; text-align: right; font-weight: 600; color: var(--text-main);">المسابقة</th>
                        <th style="padding: 12px; text-align: right; font-weight: 600; color: var(--text-main);">السنة</th>
                        <th style="padding: 12px; text-align: right; font-weight: 600; color: var(--text-main);">الحالة</th>
                        <th style="padding: 12px; text-align: right; font-weight: 600; color: var(--text-main);">تاريخ التسجيل</th>
                        <th style="padding: 12px; text-align: center; font-weight: 600; color: var(--text-main);">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrations as $reg): ?>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px;">
                                <div style="font-weight: 600; color: var(--text-main);"><?= $this->e($reg['student_name']) ?></div>
                                <div style="font-size: 13px; color: var(--text-muted);"><?= $this->e($reg['student_email']) ?></div>
                            </td>
                            <td style="padding: 12px; color: var(--text-main);"><?= $this->e($reg['school_name']) ?></td>
                            <td style="padding: 12px; color: var(--text-main);"><?= $this->e($reg['competition_name']) ?></td>
                            <td style="padding: 12px; color: var(--text-main);"><?= $reg['edition_year'] ?></td>
                            <td style="padding: 12px;">
                                <?php
                                $statusColors = [
                                    'draft' => '#6b7280',
                                    'submitted' => '#3b82f6',
                                    'under_review' => '#f59e0b',
                                    'accepted_training' => '#10b981',
                                    'accepted_final' => '#059669',
                                    'rejected' => '#ef4444',
                                    'cancelled' => '#9ca3af'
                                ];
                                $statusLabels = [
                                    'draft' => 'مسودة',
                                    'submitted' => 'مقدمة',
                                    'under_review' => 'قيد المراجعة',
                                    'accepted_training' => 'مقبولة (تدريب)',
                                    'accepted_final' => 'مقبولة (نهائي)',
                                    'rejected' => 'مرفوضة',
                                    'cancelled' => 'ملغاة'
                                ];
                                $color = $statusColors[$reg['status']] ?? '#6b7280';
                                $label = $statusLabels[$reg['status']] ?? $reg['status'];
                                ?>
                                <span style="background: <?= $color ?>; color: white; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 600; display: inline-block;">
                                    <?= $label ?>
                                </span>
                            </td>
                            <td style="padding: 12px; color: var(--text-muted); font-size: 14px;">
                                <?= date('Y-m-d', strtotime($reg['created_at'])) ?>
                            </td>
                            <td style="padding: 12px; text-align: center;">
                                <button onclick="updateStatus(<?= $reg['id'] ?>, '<?= $this->e($reg['status']) ?>')" style="background: var(--primary); color: white; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 600;">
                                    تحديث الحالة
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Status Update Modal -->
<div id="statusModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 16px; padding: 32px; max-width: 500px; width: 90%;">
        <h3 style="color: var(--text-main); font-size: 20px; margin-bottom: 20px;">تحديث حالة التسجيل</h3>
        
        <form id="statusForm" onsubmit="return submitStatusUpdate(event);">
            <input type="hidden" id="registrationId" name="registration_id">
            <input type="hidden" name="_csrf_token" value="<?= $this->generateCsrfToken() ?>">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">الحالة الجديدة</label>
                <select id="newStatus" name="status" required style="width: 100%; padding: 10px 14px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 10px; font-size: 14px;">
                    <option value="submitted">مقدمة</option>
                    <option value="under_review">قيد المراجعة</option>
                    <option value="accepted_training">مقبولة (تدريب)</option>
                    <option value="accepted_final">مقبولة (نهائي)</option>
                    <option value="rejected">مرفوضة</option>
                    <option value="cancelled">ملغاة</option>
                </select>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">ملاحظات</label>
                <textarea name="notes" rows="3" style="width: 100%; padding: 10px 14px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 10px; font-size: 14px; resize: vertical;" placeholder="أضف ملاحظات (اختياري)..."></textarea>
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="closeModal()" style="background: #6b7280; color: white; border: none; padding: 10px 24px; border-radius: 10px; cursor: pointer; font-weight: 600;">
                    إلغاء
                </button>
                <button type="submit" style="background: var(--primary); color: white; border: none; padding: 10px 24px; border-radius: 10px; cursor: pointer; font-weight: 600;">
                    حفظ
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateStatus(id, currentStatus) {
    document.getElementById('registrationId').value = id;
    document.getElementById('newStatus').value = currentStatus;
    document.getElementById('statusModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('statusModal').style.display = 'none';
}

function submitStatusUpdate(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const id = formData.get('registration_id');
    
    fetch('<?= $this->url('/admin/registrations/') ?>' + id + '/status', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('تم تحديث الحالة بنجاح');
            window.location.reload();
        } else {
            alert('حدث خطأ: ' + data.message);
        }
    })
    .catch(error => {
        alert('حدث خطأ في الاتصال');
        console.error('Error:', error);
    });
    
    return false;
}

// Close modal on outside click
document.getElementById('statusModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
