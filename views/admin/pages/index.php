<div class="dashboard-header">
    <h1 class="dashboard-title">إدارة الصفحات</h1>
    <p class="dashboard-subtitle">إدارة محتوى الصفحات الثابتة في البوابة</p>
</div>

<div class="card">
    <div class="card-header">
        <h2>الصفحات المتاحة</h2>
    </div>
    <div class="card-body">
        <?php if (empty($pages)): ?>
            <div class="alert alert-info">
                <p>لا توجد صفحات متاحة حالياً</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>المفتاح</th>
                            <th>العنوان بالعربية</th>
                            <th>العنوان بالإنجليزية</th>
                            <th>الحالة</th>
                            <th>آخر تحديث</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pages as $page): ?>
                            <tr>
                                <td><code><?= $this->e($page['page_key']) ?></code></td>
                                <td><?= $this->e($page['page_title_ar']) ?></td>
                                <td><?= $this->e($page['page_title_en'] ?? '-') ?></td>
                                <td>
                                    <?php if ($page['is_active']): ?>
                                        <span class="badge badge-success">نشطة</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">معطلة</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('Y-m-d H:i', strtotime($page['updated_at'])) ?></td>
                                <td>
                                    <a href="<?= $this->url('/admin/pages/edit?key=' . $page['page_key']) ?>" class="btn btn-sm btn-primary">
                                        تعديل المحتوى
                                    </a>
                                    <a href="<?= $this->url('/' . $page['page_key']) ?>" class="btn btn-sm btn-secondary" target="_blank">
                                        معاينة
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th,
.table td {
    padding: 12px;
    text-align: right;
    border-bottom: 1px solid #e2e8f0;
}

.table th {
    background: #f8fafc;
    font-weight: 600;
    color: #334155;
}

.table tbody tr:hover {
    background: #f8fafc;
}

.badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success {
    background: #dcfce7;
    color: #166534;
}

.badge-secondary {
    background: #f1f5f9;
    color: #64748b;
}

.btn-sm {
    padding: 6px 14px;
    font-size: 13px;
}

code {
    background: #f1f5f9;
    padding: 4px 8px;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    color: #e11d48;
}
</style>
