<?php
/**
 * Admin Slider Management - Index
 */
?>

<div class="admin-container">
    <div class="admin-header">
        <div>
            <h1 class="admin-title">🖼️ إدارة سلايدر الصفحة الرئيسية</h1>
            <p class="admin-subtitle">إدارة وتعديل الصور الدوارة في قسم البانر الرئيسي</p>
        </div>
        <a href="<?= $this->url('/admin/slider/create') ?>" class="btn-primary">
            <span>➕</span> إضافة صورة جديدة
        </a>
    </div>

    <?php if (empty($slides)): ?>
        <div class="empty-state">
            <div class="empty-icon">🖼️</div>
            <h3>لا توجد صور في السلايدر</h3>
            <p>ابدأ بإضافة صور للسلايدر الرئيسي</p>
            <a href="<?= $this->url('/admin/slider/create') ?>" class="btn-primary">إضافة أول صورة</a>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px">معاينة</th>
                        <th>العنوان</th>
                        <th>الوصف</th>
                        <th style="width: 80px">الترتيب</th>
                        <th style="width: 100px">الحالة</th>
                        <th style="width: 180px">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($slides as $slide): ?>
                        <tr>
                            <td>
                                <img src="<?= $this->asset($slide['image_path']) ?>" 
                                     alt="<?= $this->e($slide['title_ar']) ?>" 
                                     style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px; border: 2px solid #e5e7eb;"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'60\' height=\'40\'%3E%3Crect fill=\'%23e5e7eb\' width=\'60\' height=\'40\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' font-size=\'10\' fill=\'%23666\' text-anchor=\'middle\' dy=\'.3em\'%3E🖼️%3C/text%3E%3C/svg%3E'">
                            </td>
                            <td>
                                <strong><?= $this->e($slide['title_ar']) ?></strong>
                            </td>
                            <td>
                                <span class="text-muted"><?= $this->e($slide['description_ar']) ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary"><?= $slide['slide_order'] ?></span>
                            </td>
                            <td>
                                <?php if ($slide['is_active']): ?>
                                    <span class="badge badge-success">نشط</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">معطل</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <form method="POST" action="<?= $this->url('/admin/slider/toggle') ?>" style="display: inline;">
                                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                        <input type="hidden" name="id" value="<?= $slide['id'] ?>">
                                        <button type="submit" class="btn-icon" title="<?= $slide['is_active'] ? 'تعطيل' : 'تفعيل' ?>">
                                            <?= $slide['is_active'] ? '👁️' : '🚫' ?>
                                        </button>
                                    </form>
                                    
                                    <a href="<?= $this->url('/admin/slider/edit?id=' . $slide['id']) ?>" 
                                       class="btn-icon" title="تعديل">
                                        ✏️
                                    </a>
                                    
                                    <form method="POST" action="<?= $this->url('/admin/slider/delete') ?>" 
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذه الصورة؟')" style="display: inline;">
                                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                        <input type="hidden" name="id" value="<?= $slide['id'] ?>">
                                        <button type="submit" class="btn-icon btn-danger" title="حذف">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="info-box" style="margin-top: 20px;">
            <strong>💡 ملاحظة:</strong> يتم عرض الصور النشطة فقط في السلايدر الرئيسي. الترتيب يحدد تسلسل ظهور الصور.
        </div>
    <?php endif; ?>
</div>

<style>
.action-buttons {
    display: flex;
    gap: 6px;
    justify-content: center;
}

.btn-icon {
    padding: 6px 10px;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.2s;
}

.btn-icon:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
}

.btn-icon.btn-danger:hover {
    background: #fee;
    border-color: #ef4444;
}

.badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success {
    background: #d1fae5;
    color: #065f46;
}

.badge-secondary {
    background: #f3f4f6;
    color: #6b7280;
}

.info-box {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 12px;
    padding: 16px;
    font-size: 14px;
    color: #1e40af;
}
</style>
