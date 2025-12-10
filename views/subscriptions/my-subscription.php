<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اشتراكي - بوابة الأولمبياد العلمي الفلسطيني</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .subscription-card {
            background: linear-gradient(135deg, #198754 0%, #20c997 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
        }
        
        .status-active {
            background-color: #198754;
        }
        
        .status-pending {
            background-color: #ffc107;
            color: #000;
        }
        
        .status-expired {
            background-color: #dc3545;
        }
        
        .days-remaining {
            font-size: 3rem;
            font-weight: bold;
        }
        
        .timeline-item {
            position: relative;
            padding-right: 2rem;
            padding-bottom: 2rem;
            border-right: 2px solid #e0e0e0;
        }
        
        .timeline-item:last-child {
            border-right: none;
        }
        
        .timeline-icon {
            position: absolute;
            right: -14px;
            top: 0;
            width: 24px;
            height: 24px;
            background-color: #198754;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">
            <i class="bi bi-person-badge me-2"></i>
            اشتراكي
        </h1>
        
        <?php if ($activeSubscription): ?>
        <!-- Active Subscription Card -->
        <div class="subscription-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-2"><?= $this->e($activeSubscription['plan_name']) ?></h3>
                    
                    <div class="mb-3">
                        <span class="status-badge status-<?= $activeSubscription['status'] ?>">
                            <?php 
                            $statusLabels = [
                                'active' => 'نشط',
                                'pending' => 'قيد المراجعة',
                                'expired' => 'منتهي'
                            ];
                            echo $statusLabels[$activeSubscription['status']] ?? $activeSubscription['status'];
                            ?>
                        </span>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <small class="d-block opacity-75">تاريخ البدء</small>
                            <strong><?= date('Y-m-d', strtotime($activeSubscription['start_date'])) ?></strong>
                        </div>
                        <div class="col-sm-6">
                            <small class="d-block opacity-75">تاريخ الانتهاء</small>
                            <strong><?= date('Y-m-d', strtotime($activeSubscription['end_date'])) ?></strong>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 text-center">
                    <?php 
                    $endDate = new DateTime($activeSubscription['end_date']);
                    $today = new DateTime();
                    $daysRemaining = $today->diff($endDate)->days;
                    ?>
                    <div class="days-remaining"><?= $daysRemaining ?></div>
                    <div>يوم متبقي</div>
                </div>
            </div>
            
            <?php if ($activeSubscription['status'] === 'pending'): ?>
            <div class="alert alert-warning mt-3 mb-0">
                <i class="bi bi-clock-history me-2"></i>
                اشتراكك قيد المراجعة. سيتم تفعيله خلال 24 ساعة من التحقق من الدفع.
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Subscription Features -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="bi bi-check-circle text-success me-2"></i>
                    مميزات اشتراكك
                </h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        الوصول الكامل لجميع الموارد التدريبية
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        المشاركة في جميع المسابقات الدولية
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        دعم فني على مدار الساعة
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        شهادات مشاركة معتمدة
                    </li>
                    <li class="mb-0">
                        <i class="bi bi-check text-success me-2"></i>
                        الوصول للتدريبات والاختبارات المتقدمة
                    </li>
                </ul>
            </div>
        </div>
        
        <?php else: ?>
        <!-- No Active Subscription -->
        <div class="alert alert-warning">
            <h5 class="alert-heading">
                <i class="bi bi-exclamation-triangle me-2"></i>
                لا يوجد اشتراك نشط
            </h5>
            <p class="mb-3">
                للتسجيل في المسابقات والحصول على الموارد التدريبية، يجب أن يكون لديك اشتراك نشط.
            </p>
            <a href="<?= $this->url('/subscriptions/plans') ?>" class="btn btn-success">
                <i class="bi bi-arrow-left-circle me-1"></i>
                عرض خطط الاشتراك
            </a>
        </div>
        <?php endif; ?>
        
        <!-- Subscription History -->
        <?php if (!empty($subscriptionHistory)): ?>
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    سجل الاشتراكات
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <?php foreach ($subscriptionHistory as $index => $subscription): ?>
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="bi bi-check"></i>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6 class="mb-1"><?= $this->e($subscription['plan_name']) ?></h6>
                                        <small class="text-muted">
                                            من <?= date('Y-m-d', strtotime($subscription['start_date'])) ?>
                                            إلى <?= date('Y-m-d', strtotime($subscription['end_date'])) ?>
                                        </small>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="badge bg-<?= $subscription['status'] === 'active' ? 'success' : ($subscription['status'] === 'pending' ? 'warning' : 'secondary') ?>">
                                            <?php 
                                            $statusLabels = [
                                                'active' => 'نشط',
                                                'pending' => 'قيد المراجعة',
                                                'expired' => 'منتهي',
                                                'cancelled' => 'ملغي'
                                            ];
                                            echo $statusLabels[$subscription['status']] ?? $subscription['status'];
                                            ?>
                                        </span>
                                        <?php if ($subscription['price']): ?>
                                        <div class="mt-2">
                                            <strong>$<?= number_format($subscription['price'], 2) ?></strong>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <?php if ($subscription['payment_status'] === 'paid'): ?>
                                <div class="mt-2">
                                    <small class="text-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        تم الدفع - <?= $subscription['payment_method'] ?? 'N/A' ?>
                                    </small>
                                </div>
                                <?php elseif ($subscription['payment_status'] === 'unpaid'): ?>
                                <div class="mt-2">
                                    <small class="text-danger">
                                        <i class="bi bi-x-circle me-1"></i>
                                        لم يتم الدفع
                                    </small>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Support Section -->
        <div class="card mt-4 border-0 bg-light">
            <div class="card-body text-center p-4">
                <h5 class="mb-3">هل تحتاج مساعدة؟</h5>
                <p class="text-muted mb-3">
                    إذا كان لديك أي استفسار حول اشتراكك، لا تتردد في التواصل معنا
                </p>
                <a href="<?= $this->url('/contact') ?>" class="btn btn-outline-primary">
                    <i class="bi bi-envelope me-1"></i>
                    تواصل معنا
                </a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
