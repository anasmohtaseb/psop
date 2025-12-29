<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الاشتراكات - بوابة الأولمبياد العلمي الفلسطيني</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>
                <i class="bi bi-credit-card me-2"></i>
                إدارة الاشتراكات
            </h1>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">إجمالي الاشتراكات</h6>
                                <h3 class="mb-0"><?= number_format((int)($statistics['total'] ?? 0)) ?></h3>
                            </div>
                            <div class="text-primary">
                                <i class="bi bi-receipt fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">النشطة</h6>
                                <h3 class="mb-0 text-success"><?= number_format((int)($statistics['active'] ?? 0)) ?></h3>
                            </div>
                            <div class="text-success">
                                <i class="bi bi-check-circle fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">قيد المراجعة</h6>
                                <h3 class="mb-0 text-warning"><?= number_format((int)($statistics['pending'] ?? 0)) ?></h3>
                            </div>
                            <div class="text-warning">
                                <i class="bi bi-clock-history fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">إجمالي الإيرادات</h6>
                                <h3 class="mb-0 text-success">$<?= number_format((float)($statistics['total_revenue'] ?? 0), 2) ?></h3>
                            </div>
                            <div class="text-success">
                                <i class="bi bi-currency-dollar fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="">جميع الحالات</option>
                            <option value="active" <?= ($filters['status'] ?? '') === 'active' ? 'selected' : '' ?>>نشط</option>
                            <option value="pending" <?= ($filters['status'] ?? '') === 'pending' ? 'selected' : '' ?>>قيد المراجعة</option>
                            <option value="expired" <?= ($filters['status'] ?? '') === 'expired' ? 'selected' : '' ?>>منتهي</option>
                            <option value="cancelled" <?= ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>ملغي</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">حالة الدفع</label>
                        <select name="payment_status" class="form-select">
                            <option value="">الكل</option>
                            <option value="paid" <?= ($filters['payment_status'] ?? '') === 'paid' ? 'selected' : '' ?>>مدفوع</option>
                            <option value="unpaid" <?= ($filters['payment_status'] ?? '') === 'unpaid' ? 'selected' : '' ?>>غير مدفوع</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">بحث</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="اسم المستخدم أو البريد الإلكتروني"
                               value="<?= $this->e($filters['search'] ?? '') ?>">
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-1"></i>
                            بحث
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Subscriptions Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>المستخدم</th>
                                <th>الخطة</th>
                                <th>المبلغ</th>
                                <th>تاريخ البدء</th>
                                <th>تاريخ الانتهاء</th>
                                <th>الحالة</th>
                                <th>الدفع</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($subscriptions)): ?>
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    لا توجد اشتراكات
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($subscriptions as $index => $subscription): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <div>
                                        <strong><?= $this->e($subscription['user_name']) ?></strong>
                                    </div>
                                    <small class="text-muted"><?= $this->e($subscription['user_email']) ?></small>
                                    <br>
                                    <span class="badge bg-<?= $subscription['user_type'] === 'student' ? 'info' : 'secondary' ?>">
                                        <?= $subscription['user_type'] === 'student' ? 'طالب' : 'مدرسة' ?>
                                    </span>
                                </td>
                                <td><?= $this->e($subscription['plan_name']) ?></td>
                                <td>
                                    <?php if ($subscription['price'] > 0): ?>
                                    <strong>$<?= number_format($subscription['price'], 2) ?></strong>
                                    <?php else: ?>
                                    <span class="badge bg-success">مجاني</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('Y-m-d', strtotime($subscription['start_date'])) ?></td>
                                <td>
                                    <?= date('Y-m-d', strtotime($subscription['end_date'])) ?>
                                    <?php 
                                    $endDate = new DateTime($subscription['end_date']);
                                    $today = new DateTime();
                                    $daysRemaining = $today->diff($endDate)->days;
                                    if ($subscription['status'] === 'active'):
                                    ?>
                                    <br><small class="text-muted">(<?= $daysRemaining ?> يوم)</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $statusBadges = [
                                        'active' => 'success',
                                        'pending' => 'warning',
                                        'expired' => 'secondary',
                                        'cancelled' => 'danger'
                                    ];
                                    $statusLabels = [
                                        'active' => 'نشط',
                                        'pending' => 'قيد المراجعة',
                                        'expired' => 'منتهي',
                                        'cancelled' => 'ملغي'
                                    ];
                                    ?>
                                    <span class="badge bg-<?= $statusBadges[$subscription['status']] ?? 'secondary' ?>">
                                        <?= $statusLabels[$subscription['status']] ?? $subscription['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($subscription['payment_status'] === 'paid'): ?>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        مدفوع
                                    </span>
                                    <?php else: ?>
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i>
                                        غير مدفوع
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= $this->url('/admin/subscriptions/edit/' . $subscription['id']) ?>" 
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-pencil me-1"></i>
                                            تعديل
                                        </a>
                                        
                                        <?php if ($subscription['status'] === 'pending'): ?>
                                        <form method="POST" action="<?= $this->url('/admin/subscriptions/activate') ?>" 
                                              style="display: inline;" 
                                              onsubmit="return confirm('هل أنت متأكد من تفعيل هذا الاشتراك؟')">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                            <input type="hidden" name="subscription_id" value="<?= $subscription['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                تفعيل
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                        
                                        <?php if ($subscription['status'] === 'active'): ?>
                                        <form method="POST" action="<?= $this->url('/admin/subscriptions/cancel') ?>" 
                                              style="display: inline;" 
                                              onsubmit="return confirm('هل أنت متأكد من إلغاء هذا الاشتراك؟')">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                            <input type="hidden" name="subscription_id" value="<?= $subscription['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-x-circle me-1"></i>
                                                إلغاء
                                            </button>
                                        </form>
                                        <?php endif; ?>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
