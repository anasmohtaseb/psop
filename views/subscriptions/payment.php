<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إتمام الدفع - بوابة الأولمبياد العلمي الفلسطيني</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .payment-container {
            max-width: 600px;
            margin: 2rem auto;
        }
        
        .plan-summary {
            background: linear-gradient(135deg, #198754 0%, #20c997 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }
        
        .payment-method-card {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-method-card:hover {
            border-color: #198754;
            background-color: #f8f9fa;
        }
        
        .payment-method-card.selected {
            border-color: #198754;
            background-color: #e7f5ec;
        }
        
        .payment-method-card input[type="radio"] {
            display: none;
        }
        
        .payment-instructions {
            background-color: #fff3cd;
            border-right: 4px solid #ffc107;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container payment-container py-5">
        <!-- Plan Summary -->
        <div class="plan-summary">
            <div class="text-center">
                <h2 class="mb-3">
                    <i class="bi bi-credit-card me-2"></i>
                    إتمام عملية الاشتراك
                </h2>
                <h3 class="mb-3"><?= $this->e($plan['name_ar']) ?></h3>
                <div class="h1 mb-2">
                    <?php if ($plan['price'] > 0): ?>
                    $<?= number_format($plan['price'], 2) ?>
                    <?php else: ?>
                    <span class="badge bg-light text-success">مجاني</span>
                    <?php endif; ?>
                </div>
                <p class="mb-0">لمدة <?= $plan['duration_months'] ?> شهر</p>
            </div>
        </div>
        
        <!-- Payment Form -->
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <?php if ($plan['price'] == 0): ?>
                <!-- Free Plan - Direct Activation -->
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    هذه خطة مجانية، سيتم تفعيل اشتراكك فوراً
                </div>
                
                <form method="POST" action="<?= $this->url('/subscriptions/confirm-payment') ?>">
                    <input type="hidden" name="_csrf_token" value="<?= $this->getCsrfToken() ?>">
                    <input type="hidden" name="subscription_id" value="<?= $subscription['id'] ?>">
                    <input type="hidden" name="payment_method" value="free">
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle me-2"></i>
                            تفعيل الاشتراك المجاني
                        </button>
                    </div>
                </form>
                
                <?php else: ?>
                <!-- Paid Plan - Payment Methods -->
                <h5 class="mb-3">اختر طريقة الدفع</h5>
                
                <form method="POST" action="<?= $this->url('/subscriptions/confirm-payment') ?>" id="paymentForm">
                    <input type="hidden" name="_csrf_token" value="<?= $this->getCsrfToken() ?>">
                    <input type="hidden" name="subscription_id" value="<?= $subscription['id'] ?>">
                    
                    <!-- Payment Method: Bank Transfer -->
                    <label class="payment-method-card" onclick="selectPaymentMethod('bank_transfer')">
                        <input type="radio" name="payment_method" value="bank_transfer" required>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-bank fs-2 text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">تحويل بنكي</h6>
                                <small class="text-muted">التحويل المباشر إلى حساب البنك</small>
                            </div>
                        </div>
                    </label>
                    
                    <!-- Payment Method: PayPal -->
                    <label class="payment-method-card" onclick="selectPaymentMethod('paypal')">
                        <input type="radio" name="payment_method" value="paypal">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-paypal fs-2 text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">PayPal</h6>
                                <small class="text-muted">الدفع عبر PayPal</small>
                            </div>
                        </div>
                    </label>
                    
                    <!-- Payment Method: Credit Card -->
                    <label class="payment-method-card" onclick="selectPaymentMethod('credit_card')">
                        <input type="radio" name="payment_method" value="credit_card">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-credit-card fs-2 text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">بطاقة ائتمان</h6>
                                <small class="text-muted">Visa, MasterCard, American Express</small>
                            </div>
                        </div>
                    </label>
                    
                    <!-- Payment Instructions -->
                    <div class="payment-instructions" id="paymentInstructions" style="display: none;">
                        <h6 class="mb-2">
                            <i class="bi bi-info-circle me-1"></i>
                            تعليمات الدفع
                        </h6>
                        <div id="bankTransferInstructions" style="display: none;">
                            <p class="mb-2"><strong>معلومات التحويل البنكي:</strong></p>
                            <ul class="mb-2">
                                <li>اسم البنك: بنك فلسطين</li>
                                <li>رقم الحساب: XXXX-XXXX-XXXX</li>
                                <li>اسم الحساب: بوابة الأولمبياد العلمي الفلسطيني</li>
                                <li>المبلغ: $<?= number_format($plan['price'], 2) ?></li>
                            </ul>
                            <p class="mb-0 small">بعد إتمام التحويل، يرجى إدخال رقم العملية أدناه</p>
                        </div>
                    </div>
                    
                    <!-- Payment Reference -->
                    <div class="mb-3" id="paymentReferenceField" style="display: none;">
                        <label class="form-label">رقم العملية / الإيصال</label>
                        <input type="text" class="form-control" name="payment_reference" 
                               placeholder="أدخل رقم العملية أو الإيصال">
                        <small class="form-text text-muted">
                            سيتم مراجعة الدفع وتفعيل الاشتراك خلال 24 ساعة
                        </small>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle me-2"></i>
                            تأكيد الدفع
                        </button>
                        <a href="<?= $this->url('/subscriptions/plans') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-right me-1"></i>
                            رجوع
                        </a>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Security Notice -->
        <div class="alert alert-light text-center mt-4">
            <i class="bi bi-shield-check text-success me-2"></i>
            جميع المعاملات آمنة ومشفرة
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectPaymentMethod(method) {
            // Remove selected class from all cards
            document.querySelectorAll('.payment-method-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Add selected class to clicked card
            event.currentTarget.classList.add('selected');
            
            // Show/hide instructions based on method
            const instructionsDiv = document.getElementById('paymentInstructions');
            const bankInstructions = document.getElementById('bankTransferInstructions');
            const referenceField = document.getElementById('paymentReferenceField');
            
            if (method === 'bank_transfer') {
                instructionsDiv.style.display = 'block';
                bankInstructions.style.display = 'block';
                referenceField.style.display = 'block';
            } else {
                instructionsDiv.style.display = 'none';
                bankInstructions.style.display = 'none';
                referenceField.style.display = 'block';
            }
        }
    </script>
</body>
</html>
