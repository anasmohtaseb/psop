<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل خطة اشتراك - بوابة الأولمبياد العلمي الفلسطيني</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-pencil-square me-2"></i>
                            تعديل خطة الاشتراك
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= $this->url('/admin/subscriptions/plans/update') ?>">
                            <input type="hidden" name="_csrf_token" value="<?= $this->getCsrfToken() ?>">
                            <input type="hidden" name="plan_id" value="<?= $plan['id'] ?>">
                            
                            <div class="row g-3">
                                <!-- Arabic Name -->
                                <div class="col-md-6">
                                    <label class="form-label">الاسم بالعربية <span class="text-danger">*</span></label>
                                    <input type="text" name="name_ar" class="form-control" required
                                           value="<?= $this->e($plan['name_ar']) ?>">
                                </div>
                                
                                <!-- English Name -->
                                <div class="col-md-6">
                                    <label class="form-label">الاسم بالإنجليزية <span class="text-danger">*</span></label>
                                    <input type="text" name="name_en" class="form-control" required
                                           value="<?= $this->e($plan['name_en']) ?>">
                                </div>
                                
                                <!-- Arabic Description -->
                                <div class="col-md-6">
                                    <label class="form-label">الوصف بالعربية</label>
                                    <textarea name="description_ar" class="form-control" rows="3"><?= $this->e($plan['description_ar'] ?? '') ?></textarea>
                                </div>
                                
                                <!-- English Description -->
                                <div class="col-md-6">
                                    <label class="form-label">الوصف بالإنجليزية</label>
                                    <textarea name="description_en" class="form-control" rows="3"><?= $this->e($plan['description_en'] ?? '') ?></textarea>
                                </div>
                                
                                <!-- Price -->
                                <div class="col-md-4">
                                    <label class="form-label">السعر (بالدولار) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="price" class="form-control" 
                                               min="0" step="0.01" required
                                               value="<?= $plan['price'] ?>">
                                    </div>
                                    <small class="text-muted">أدخل 0 للخطة المجانية</small>
                                </div>
                                
                                <!-- Duration -->
                                <div class="col-md-4">
                                    <label class="form-label">المدة (بالأشهر) <span class="text-danger">*</span></label>
                                    <input type="number" name="duration_months" class="form-control" 
                                           min="1" required
                                           value="<?= $plan['duration_months'] ?>">
                                </div>
                                
                                <!-- User Type -->
                                <div class="col-md-4">
                                    <label class="form-label">نوع المستخدم <span class="text-danger">*</span></label>
                                    <select name="user_type" class="form-select" required>
                                        <option value="student" <?= $plan['user_type'] === 'student' ? 'selected' : '' ?>>طالب</option>
                                        <option value="school" <?= $plan['user_type'] === 'school' ? 'selected' : '' ?>>مدرسة</option>
                                    </select>
                                </div>
                                
                                <!-- Features -->
                                <div class="col-12">
                                    <label class="form-label">المميزات</label>
                                    <textarea name="features" class="form-control" rows="5" 
                                              placeholder="أدخل كل ميزة في سطر منفصل"><?= $this->e($plan['features_text'] ?? '') ?></textarea>
                                    <small class="text-muted">مثال: التسجيل في جميع المسابقات</small>
                                </div>
                                
                                <!-- Active Status -->
                                <div class="col-12">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" 
                                               <?= $plan['is_active'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_active">
                                            نشط (متاح للمستخدمين)
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Buttons -->
                                <div class="col-12">
                                    <hr>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle me-1"></i>
                                            حفظ التغييرات
                                        </button>
                                        <a href="<?= $this->url('/admin/subscriptions/plans') ?>" class="btn btn-outline-secondary">
                                            <i class="bi bi-x-circle me-1"></i>
                                            إلغاء
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
