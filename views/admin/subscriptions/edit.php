<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل اشتراك - بوابة الأولمبياد العلمي الفلسطيني</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>
                <i class="bi bi-pencil me-2"></i>
                تعديل اشتراك
            </h1>
            <a href="<?= $this->url('/admin/subscriptions') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-right me-1"></i>
                العودة للقائمة
            </a>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">معلومات الاشتراك</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= $this->url('/admin/subscriptions/update') ?>">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <input type="hidden" name="subscription_id" value="<?= $subscription['id'] ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">المستخدم</label>
                                <input type="text" class="form-control" 
                                       value="<?= $this->e($user['name']) ?> (<?= $this->e($user['email'] ?? $user['phone']) ?>)" 
                                       readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">الخطة الحالية</label>
                                <input type="text" class="form-control" 
                                       value="<?= $this->e($plan['name_ar']) ?> - $<?= number_format($plan['price'], 2) ?>" 
                                       readonly>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">الحالة</label>
                                    <select name="status" class="form-select" required>
                                        <option value="pending" <?= $subscription['status'] === 'pending' ? 'selected' : '' ?>>قيد المراجعة</option>
                                        <option value="active" <?= $subscription['status'] === 'active' ? 'selected' : '' ?>>نشط</option>
                                        <option value="expired" <?= $subscription['status'] === 'expired' ? 'selected' : '' ?>>منتهي</option>
                                        <option value="cancelled" <?= $subscription['status'] === 'cancelled' ? 'selected' : '' ?>>ملغي</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">حالة الدفع</label>
                                    <select name="payment_status" class="form-select" required>
                                        <option value="unpaid" <?= $subscription['payment_status'] === 'unpaid' ? 'selected' : '' ?>>غير مدفوع</option>
                                        <option value="paid" <?= $subscription['payment_status'] === 'paid' ? 'selected' : '' ?>>مدفوع</option>
                                        <option value="refunded" <?= $subscription['payment_status'] === 'refunded' ? 'selected' : '' ?>>مسترد</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">تاريخ البدء</label>
                                    <input type="date" name="start_date" class="form-control" 
                                           value="<?= date('Y-m-d', strtotime($subscription['start_date'])) ?>" 
                                           required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">تاريخ الانتهاء</label>
                                    <input type="date" name="end_date" class="form-control" 
                                           value="<?= date('Y-m-d', strtotime($subscription['end_date'])) ?>" 
                                           required>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>
                                    حفظ التغييرات
                                </button>
                                <a href="<?= $this->url('/admin/subscriptions') ?>" class="btn btn-secondary">
                                    إلغاء
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">معلومات إضافية</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">تاريخ الإنشاء</small>
                            <div><?= date('Y-m-d H:i', strtotime($subscription['created_at'])) ?></div>
                        </div>
                        
                        <?php if (!empty($subscription['payment_date'])): ?>
                        <div class="mb-3">
                            <small class="text-muted">تاريخ الدفع</small>
                            <div><?= date('Y-m-d H:i', strtotime($subscription['payment_date'])) ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <small class="text-muted">نوع المستخدم</small>
                            <div>
                                <span class="badge bg-<?= $user['type'] === 'student' ? 'info' : 'secondary' ?>">
                                    <?= $user['type'] === 'student' ? 'طالب' : 'مدرسة' ?>
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <small class="text-muted">المبلغ المدفوع</small>
                            <div class="fs-5 fw-bold text-success">
                                <?php if ($plan['price'] > 0): ?>
                                $<?= number_format($plan['price'], 2) ?>
                                <?php else: ?>
                                مجاني
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card border-warning">
                    <div class="card-body">
                        <h6 class="text-warning">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            ملاحظة
                        </h6>
                        <p class="small mb-0">
                            تأكد من صحة البيانات قبل الحفظ. تغيير حالة الدفع إلى "مدفوع" سيقوم بتسجيل تاريخ الدفع تلقائياً.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
