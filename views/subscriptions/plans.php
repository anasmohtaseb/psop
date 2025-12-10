<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطط الاشتراك - بوابة الأولمبياد العلمي الفلسطيني</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .pricing-card {
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .pricing-card.featured {
            border-color: #198754;
            box-shadow: 0 5px 20px rgba(25,135,84,0.2);
        }
        
        .pricing-header {
            background: linear-gradient(135deg, #198754 0%, #20c997 100%);
            color: white;
            padding: 2rem;
            border-radius: 13px 13px 0 0;
        }
        
        .pricing-card.featured .pricing-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
        }
        
        .price {
            font-size: 3rem;
            font-weight: bold;
        }
        
        .price-currency {
            font-size: 1.5rem;
            vertical-align: super;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
        }
        
        .feature-list li {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .feature-list li:last-child {
            border-bottom: none;
        }
        
        .feature-list i {
            color: #198754;
            margin-left: 0.5rem;
        }
        
        .active-subscription-badge {
            background: linear-gradient(135deg, #198754 0%, #20c997 100%);
            color: white;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        
        .badge-premium {
            background: linear-gradient(135deg, #ffc107 0%, #ff6b6b 100%);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <!-- Active Subscription Alert -->
        <?php if ($activeSubscription): ?>
        <div class="alert active-subscription-badge" role="alert">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-0">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        لديك اشتراك نشط: <?= $this->e($activeSubscription['plan_name']) ?>
                    </h5>
                    <small>صالح حتى: <?= date('Y-m-d', strtotime($activeSubscription['end_date'])) ?></small>
                </div>
                <div class="col-md-4 text-end">
                    <a href="<?= $this->url('/subscriptions/my-subscription') ?>" class="btn btn-light">
                        <i class="bi bi-info-circle me-1"></i>
                        عرض تفاصيل الاشتراك
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 mb-3">اختر خطة الاشتراك المناسبة</h1>
            <p class="lead text-muted">
                اشترك الآن للمشاركة في المسابقات العالمية والحصول على الموارد التدريبية
            </p>
        </div>
        
        <!-- Pricing Cards -->
        <div class="row g-4">
            <?php foreach ($plans as $plan): ?>
            <div class="col-md-6 col-lg-4">
                <div class="pricing-card <?= $plan['price'] > 0 && $plan['duration_months'] >= 12 ? 'featured' : '' ?>">
                    <div class="pricing-header text-center">
                        <?php if ($plan['price'] > 0 && $plan['duration_months'] >= 12): ?>
                        <span class="badge badge-premium mb-2">الأكثر شعبية</span>
                        <?php endif; ?>
                        
                        <h3 class="mb-2"><?= $this->e($plan['name_ar']) ?></h3>
                        <p class="mb-0 opacity-75"><?= $this->e($plan['description_ar'] ?? '') ?></p>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Price -->
                        <div class="text-center mb-4">
                            <?php if ($plan['price'] > 0): ?>
                            <div class="price">
                                <span class="price-currency">$</span><?= number_format($plan['price'], 0) ?>
                            </div>
                            <small class="text-muted">لمدة <?= $plan['duration_months'] ?> شهر</small>
                            <?php else: ?>
                            <div class="price text-success">مجاني</div>
                            <small class="text-muted">لمدة <?= $plan['duration_months'] ?> أشهر</small>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Features -->
                        <ul class="feature-list">
                            <?php 
                            $features = $plan['features_array'];
                            if (empty($features)): 
                                // Default features based on plan type
                                if ($plan['price'] == 0):
                                    $features = [
                                        'الوصول للموارد التدريبية الأساسية',
                                        'المشاركة في مسابقة واحدة',
                                        'دعم فني محدود'
                                    ];
                                else:
                                    $features = [
                                        'الوصول الكامل لجميع الموارد التدريبية',
                                        'المشاركة في جميع المسابقات',
                                        'دعم فني على مدار الساعة',
                                        'شهادات مشاركة معتمدة',
                                        'الوصول للتدريبات المتقدمة'
                                    ];
                                endif;
                            endif;
                            
                            foreach ($features as $feature): 
                            ?>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <?= $this->e($feature) ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        
                        <!-- Subscribe Button -->
                        <div class="d-grid mt-4">
                            <?php if ($activeSubscription): ?>
                            <button class="btn btn-secondary" disabled>
                                <i class="bi bi-check-circle me-1"></i>
                                لديك اشتراك نشط
                            </button>
                            <?php else: ?>
                            <form method="POST" action="<?= $this->url('/subscriptions/subscribe') ?>">
                                <input type="hidden" name="_csrf_token" value="<?= $this->getCsrfToken() ?>">
                                <input type="hidden" name="plan_id" value="<?= $plan['id'] ?>">
                                <button type="submit" class="btn btn-<?= $plan['price'] > 0 ? 'success' : 'primary' ?> btn-lg w-100">
                                    <i class="bi bi-arrow-left-circle me-1"></i>
                                    <?= $plan['price'] > 0 ? 'اشترك الآن' : 'ابدأ التجربة المجانية' ?>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Info Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="mb-3">
                            <i class="bi bi-info-circle text-primary me-2"></i>
                            معلومات مهمة
                        </h4>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check text-success me-2"></i>
                                يجب أن يكون لديك اشتراك نشط للتسجيل في المسابقات
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check text-success me-2"></i>
                                يمكنك إلغاء الاشتراك في أي وقت
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check text-success me-2"></i>
                                جميع الأسعار بالدولار الأمريكي
                            </li>
                            <li class="mb-0">
                                <i class="bi bi-check text-success me-2"></i>
                                للمدارس: الاشتراك يشمل جميع الطلاب في المدرسة
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
