<?php
/**
 * Admin Announcements List View
 */
?>

<div class="content-header">
    <div class="header-title">
        <h1>إدارة الإعلانات</h1>
        <p>إنشاء وإدارة إعلانات النظام</p>
    </div>
    <div class="header-actions">
        <a href="<?= $this->url('/admin/announcements/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> إعلان جديد
        </a>
    </div>
</div>

<?php if (!empty($announcements)): ?>
<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>العنوان</th>
                <th>الجمهور المستهدف</th>
                <th>الحالة</th>
                <th>تاريخ النشر</th>
                <th>تاريخ الإنشاء</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($announcements as $announcement): ?>
            <tr>
                <td><?= $announcement['id'] ?></td>
                <td><?= $this->e($announcement['title']) ?></td>
                <td>
                    <?php
                    $audiences = [
                        'all' => 'الجميع',
                        'students' => 'الطلاب',
                        'coordinators' => 'منسقو المدارس',
                        'trainers' => 'المدربون'
                    ];
                    echo $audiences[$announcement['target_audience']] ?? $announcement['target_audience'];
                    ?>
                </td>
                <td>
                    <span class="badge <?= $announcement['status'] === 'published' ? 'badge-success' : 'badge-warning' ?>">
                        <?= $announcement['status'] === 'published' ? 'منشور' : 'مسودة' ?>
                    </span>
                </td>
                <td><?= $announcement['publish_date'] ?? 'فوري' ?></td>
                <td><?= date('Y-m-d', strtotime($announcement['created_at'])) ?></td>
                <td class="actions">
                    <a href="<?= $this->url('/admin/announcements/edit?id=' . $announcement['id']) ?>" 
                       class="btn btn-sm btn-secondary" title="تعديل">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="<?= $this->url('/admin/announcements/delete') ?>" 
                          style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الإعلان؟')">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <input type="hidden" name="id" value="<?= $announcement['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
<div class="empty-state">
    <i class="fas fa-bullhorn fa-3x"></i>
    <h3>لا توجد إعلانات</h3>
    <p>ابدأ بإنشاء إعلان جديد</p>
    <a href="<?= $this->url('/admin/announcements/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> إعلان جديد
    </a>
</div>
<?php endif; ?>

<style>
.badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success {
    background-color: #d1fae5;
    color: #065f46;
}

.badge-warning {
    background-color: #fef3c7;
    color: #92400e;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6b7280;
}

.empty-state i {
    color: #d1d5db;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: #374151;
    margin-bottom: 10px;
}
</style>
