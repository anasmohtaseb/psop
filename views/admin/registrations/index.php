<div class="dashboard-header" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">
                إدارة التسجيلات
            </h1>
            <p style="color: var(--text-muted);">
                <?php if (!empty($edition)): ?>
                    المسابقة: <strong><?= $this->e($edition['competition_name_ar'] ?? '') ?></strong> - سنة <?= $this->e($edition['year']) ?>
                <?php else: ?>
                    عرض وإدارة تسجيلات الطلاب
                <?php endif; ?>
            </p>
        </div>
        <a href="<?= $this->url('/admin/competitions') ?>" class="btn btn-outline">
            ← العودة للمسابقات
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<?php if (!empty($registrations)): ?>
    <?php
    $stats = [
        'total' => count($registrations),
        'submitted' => 0,
        'under_review' => 0,
        'accepted' => 0,
        'rejected' => 0
    ];
    foreach ($registrations as $reg) {
        if ($reg['status'] === 'submitted') $stats['submitted']++;
        elseif ($reg['status'] === 'under_review') $stats['under_review']++;
        elseif (in_array($reg['status'], ['accepted_training', 'accepted_final'])) $stats['accepted']++;
        elseif ($reg['status'] === 'rejected') $stats['rejected']++;
    }
    ?>
    
    <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; margin-bottom: 30px;">
        <div class="card" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border-radius: 16px; padding: 20px; border: none;">
            <div style="font-size: 32px; font-weight: 700; margin-bottom: 4px;"><?= $stats['total'] ?></div>
            <div style="font-size: 14px; opacity: 0.9;">إجمالي التسجيلات</div>
        </div>
        
        <div class="card" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border-radius: 16px; padding: 20px; border: none;">
            <div style="font-size: 32px; font-weight: 700; margin-bottom: 4px;"><?= $stats['submitted'] ?></div>
            <div style="font-size: 14px; opacity: 0.9;">قيد المراجعة</div>
        </div>
        
        <div class="card" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; border-radius: 16px; padding: 20px; border: none;">
            <div style="font-size: 32px; font-weight: 700; margin-bottom: 4px;"><?= $stats['under_review'] ?></div>
            <div style="font-size: 14px; opacity: 0.9;">تحت المراجعة</div>
        </div>
        
        <div class="card" style="background: linear-gradient(135deg, #22c55e, #16a34a); color: white; border-radius: 16px; padding: 20px; border: none;">
            <div style="font-size: 32px; font-weight: 700; margin-bottom: 4px;"><?= $stats['accepted'] ?></div>
            <div style="font-size: 14px; opacity: 0.9;">مقبول</div>
        </div>
        
        <div class="card" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border-radius: 16px; padding: 20px; border: none;">
            <div style="font-size: 32px; font-weight: 700; margin-bottom: 4px;"><?= $stats['rejected'] ?></div>
            <div style="font-size: 14px; opacity: 0.9;">مرفوض</div>
        </div>
    </div>
<?php endif; ?>

<!-- Registrations Table -->
<?php if (!empty($registrations)): ?>
    <div class="card" style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--card-bg); border-bottom: 2px solid rgba(225, 29, 72, 0.1);">
                        <th style="padding: 16px; text-align: right; font-weight: 700; color: var(--text-main);">#</th>
                        <th style="padding: 16px; text-align: right; font-weight: 700; color: var(--text-main);">اسم الطالب</th>
                        <th style="padding: 16px; text-align: right; font-weight: 700; color: var(--text-main);">المدرسة</th>
                        <th style="padding: 16px; text-align: right; font-weight: 700; color: var(--text-main);">البريد الإلكتروني</th>
                        <th style="padding: 16px; text-align: right; font-weight: 700; color: var(--text-main);">تاريخ التسجيل</th>
                        <th style="padding: 16px; text-align: center; font-weight: 700; color: var(--text-main);">الحالة</th>
                        <th style="padding: 16px; text-align: center; font-weight: 700; color: var(--text-main);">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrations as $reg): ?>
                        <tr style="border-bottom: 1px solid rgba(148, 163, 184, 0.1); transition: background 0.2s;" 
                            onmouseover="this.style.background='var(--card-bg)'" 
                            onmouseout="this.style.background='transparent'">
                            <td style="padding: 16px; color: var(--text-muted);"><?= $reg['id'] ?></td>
                            <td style="padding: 16px; color: var(--text-main); font-weight: 600;">
                                <?= $this->e($reg['student_name'] ?? 'غير محدد') ?>
                            </td>
                            <td style="padding: 16px; color: var(--text-muted);">
                                <?= $this->e($reg['school_name'] ?? 'غير محدد') ?>
                            </td>
                            <td style="padding: 16px; color: var(--text-muted); direction: ltr; text-align: right;">
                                <?= $this->e($reg['student_email'] ?? 'غير محدد') ?>
                            </td>
                            <td style="padding: 16px; color: var(--text-muted);">
                                <?= date('Y/m/d', strtotime($reg['created_at'])) ?>
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <?php
                                $statusStyles = [
                                    'draft' => ['bg' => '#6b7280', 'label' => 'مسودة'],
                                    'submitted' => ['bg' => '#f59e0b', 'label' => 'مُرسل'],
                                    'under_review' => ['bg' => '#8b5cf6', 'label' => 'قيد المراجعة'],
                                    'accepted_training' => ['bg' => '#22c55e', 'label' => 'مقبول للتدريب'],
                                    'accepted_final' => ['bg' => '#16a34a', 'label' => 'مقبول نهائي'],
                                    'rejected' => ['bg' => '#ef4444', 'label' => 'مرفوض'],
                                    'cancelled' => ['bg' => '#6b7280', 'label' => 'ملغي']
                                ];
                                $status = $statusStyles[$reg['status']] ?? ['bg' => '#6b7280', 'label' => $reg['status']];
                                ?>
                                <span style="display: inline-block; padding: 6px 14px; background: <?= $status['bg'] ?>; color: white; border-radius: 999px; font-size: 13px; font-weight: 600;">
                                    <?= $status['label'] ?>
                                </span>
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <button onclick="showStatusModal(<?= $reg['id'] ?>, '<?= $reg['status'] ?>')" 
                                        style="padding: 6px 12px; background: rgba(225, 29, 72, 0.1); color: var(--primary); border: none; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 600;">
                                    🔄 تغيير الحالة
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="card" style="background: var(--card-bg); border: 2px dashed rgba(225, 29, 72, 0.2); border-radius: 16px; padding: 60px; text-align: center;">
        <div style="font-size: 48px; margin-bottom: 16px;">📝</div>
        <h3 style="color: var(--text-main); margin-bottom: 8px;">لا توجد تسجيلات</h3>
        <p style="color: var(--text-muted);">لم يتم استلام أي تسجيلات لهذه المسابقة بعد</p>
    </div>
<?php endif; ?>

<!-- Status Update Modal -->
<div id="statusModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 20px; padding: 30px; max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto;">
        <h2 style="color: var(--text-main); margin-bottom: 20px; font-size: 22px;">تحديث حالة التسجيل</h2>
        
        <form id="statusForm">
            <input type="hidden" name="_csrf_token" value="<?= $this->generateCsrfToken() ?>">
            <input type="hidden" id="registrationId" name="registration_id">
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    الحالة الجديدة
                </label>
                <select id="newStatus" 
                        name="status" 
                        required
                        style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px;">
                    <option value="submitted">مُرسل</option>
                    <option value="under_review">قيد المراجعة</option>
                    <option value="accepted_training">مقبول للتدريب</option>
                    <option value="accepted_final">مقبول نهائي</option>
                    <option value="rejected">مرفوض</option>
                    <option value="cancelled">ملغي</option>
                </select>
            </div>
            
            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    ملاحظات (اختياري)
                </label>
                <textarea name="notes" 
                          rows="3"
                          style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; resize: vertical;"
                          placeholder="أضف أي ملاحظات..."></textarea>
            </div>
            
            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    💾 حفظ
                </button>
                <button type="button" onclick="closeStatusModal()" class="btn btn-outline" style="flex: 1;">
                    ❌ إلغاء
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showStatusModal(id, currentStatus) {
    document.getElementById('statusModal').style.display = 'flex';
    document.getElementById('registrationId').value = id;
    document.getElementById('newStatus').value = currentStatus;
}

function closeStatusModal() {
    document.getElementById('statusModal').style.display = 'none';
}

document.getElementById('statusForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const id = formData.get('registration_id');
    
    try {
        const response = await fetch('<?= $this->url('/admin/registrations/') ?>' + id + '/status', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('تم تحديث الحالة بنجاح');
            window.location.reload();
        } else {
            alert('حدث خطأ: ' + result.message);
        }
    } catch (error) {
        alert('حدث خطأ في الاتصال');
    }
});

// Close modal on outside click
document.getElementById('statusModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeStatusModal();
    }
});
</script>
