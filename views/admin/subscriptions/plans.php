<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة خطط الاشتراك - بوابة الأولمبياد العلمي الفلسطيني</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>
                <i class="bi bi-card-list me-2"></i>
                إدارة خطط الاشتراك
            </h1>
            <a href="<?= $this->url('/admin/subscriptions/plans/create') ?>" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i>
                إضافة خطة جديدة
            </a>
        </div>
        
        <div class="row">
            <div class="col-12">
                <a href="<?= $this->url('/admin/subscriptions') ?>" class="btn btn-outline-secondary mb-3">
                    <i class="bi bi-arrow-right me-1"></i>
                    العودة إلى الاشتراكات
                </a>
            </div>
        </div>
        
        <!-- Plans Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>السعر</th>
                                <th>المدة</th>
                                <th>نوع المستخدم</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($plans)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    لا توجد خطط
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($plans as $index => $plan): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <strong><?= $this->e($plan['name_ar']) ?></strong>
                                    <br>
                                    <small class="text-muted"><?= $this->e($plan['name_en']) ?></small>
                                </td>
                                <td>
                                    <?php if ($plan['price'] > 0): ?>
                                    <strong class="text-success">$<?= number_format($plan['price'], 2) ?></strong>
                                    <?php else: ?>
                                    <span class="badge bg-success">مجاني</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $plan['duration_months'] ?> شهر</td>
                                <td>
                                    <span class="badge bg-<?= $plan['user_type'] === 'student' ? 'info' : 'secondary' ?>">
                                        <?= $plan['user_type'] === 'student' ? 'طالب' : 'مدرسة' ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($plan['is_active']): ?>
                                    <span class="badge bg-success">نشط</span>
                                    <?php else: ?>
                                    <span class="badge bg-secondary">معطل</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= $this->url("/admin/subscriptions/plans/{$plan['id']}/edit") ?>" 
                                           class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" 
                                                onclick="confirmDelete(<?= $plan['id'] ?>, '<?= $this->e($plan['name_ar']) ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Form (hidden) -->
    <form id="deleteForm" method="POST" action="<?= $this->url('/admin/subscriptions/plans/delete') ?>" style="display: none;">
        <input type="hidden" name="_csrf_token" value="<?= $this->getCsrfToken() ?>">
        <input type="hidden" name="plan_id" id="deletePlanId">
    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(planId, planName) {
            if (confirm('هل أنت متأكد من حذف الخطة "' + planName + '"؟\n\nسيتم حذف الخطة نهائياً ولن يمكن استرجاعها.')) {
                document.getElementById('deletePlanId').value = planId;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</body>
</html>
