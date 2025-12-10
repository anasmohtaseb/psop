<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل مدرسة - بوابة الأولمبياد العلمي الفلسطيني</title>
    <link rel="stylesheet" href="<?= $this->asset('css/style.css') ?>">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card wide">
            <h1>تسجيل مدرسة جديدة</h1>
            
            <form method="POST" action="<?= $this->url('/register/school') ?>">
                <input type="hidden" name="_csrf_token" value="<?= $this->getCsrfToken() ?>">
                
                <h3 style="color: #e11d48; margin: 1.5rem 0 1rem;">معلومات المنسق</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">الاسم الكامل *</label>
                        <input type="text" id="name" name="name" required 
                               value="<?= $this->e($old['name'] ?? '') ?>">
                        <?php if (isset($errors['name'])): ?>
                            <span class="error"><?= $this->e($errors['name'][0]) ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني *</label>
                        <input type="email" id="email" name="email" required 
                               value="<?= $this->e($old['email'] ?? '') ?>">
                        <?php if (isset($errors['email'])): ?>
                            <span class="error"><?= $this->e($errors['email'][0]) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">رقم الهاتف *</label>
                        <input type="tel" id="phone" name="phone" required 
                               value="<?= $this->e($old['phone'] ?? '') ?>">
                        <?php if (isset($errors['phone'])): ?>
                            <span class="error"><?= $this->e($errors['phone'][0]) ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">كلمة المرور *</label>
                        <input type="password" id="password" name="password" required minlength="8">
                        <?php if (isset($errors['password'])): ?>
                            <span class="error"><?= $this->e($errors['password'][0]) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <h3 style="color: #e11d48; margin: 1.5rem 0 1rem;">معلومات المدرسة</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="school_name">اسم المدرسة *</label>
                        <input type="text" id="school_name" name="school_name" required 
                               value="<?= $this->e($old['school_name'] ?? '') ?>">
                        <?php if (isset($errors['school_name'])): ?>
                            <span class="error"><?= $this->e($errors['school_name'][0]) ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="school_type">نوع المدرسة *</label>
                        <select id="school_type" name="school_type" required>
                            <option value="">اختر النوع</option>
                            <option value="government" <?= ($old['school_type'] ?? '') === 'government' ? 'selected' : '' ?>>حكومية</option>
                            <option value="private" <?= ($old['school_type'] ?? '') === 'private' ? 'selected' : '' ?>>خاصة</option>
                            <option value="unrwa" <?= ($old['school_type'] ?? '') === 'unrwa' ? 'selected' : '' ?>>وكالة</option>
                        </select>
                        <?php if (isset($errors['school_type'])): ?>
                            <span class="error"><?= $this->e($errors['school_type'][0]) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="governorate">المحافظة *</label>
                        <select id="governorate" name="governorate" required>
                            <option value="">اختر المحافظة</option>
                            <option value="رام الله والبيرة" <?= ($old['governorate'] ?? '') === 'رام الله والبيرة' ? 'selected' : '' ?>>رام الله والبيرة</option>
                            <option value="القدس" <?= ($old['governorate'] ?? '') === 'القدس' ? 'selected' : '' ?>>القدس</option>
                            <option value="الخليل" <?= ($old['governorate'] ?? '') === 'الخليل' ? 'selected' : '' ?>>الخليل</option>
                            <option value="بيت لحم" <?= ($old['governorate'] ?? '') === 'بيت لحم' ? 'selected' : '' ?>>بيت لحم</option>
                            <option value="نابلس" <?= ($old['governorate'] ?? '') === 'نابلس' ? 'selected' : '' ?>>نابلس</option>
                            <option value="جنين" <?= ($old['governorate'] ?? '') === 'جنين' ? 'selected' : '' ?>>جنين</option>
                            <option value="طولكرم" <?= ($old['governorate'] ?? '') === 'طولكرم' ? 'selected' : '' ?>>طولكرم</option>
                            <option value="قلقيلية" <?= ($old['governorate'] ?? '') === 'قلقيلية' ? 'selected' : '' ?>>قلقيلية</option>
                            <option value="سلفيت" <?= ($old['governorate'] ?? '') === 'سلفيت' ? 'selected' : '' ?>>سلفيت</option>
                            <option value="طوباس" <?= ($old['governorate'] ?? '') === 'طوباس' ? 'selected' : '' ?>>طوباس</option>
                            <option value="أريحا" <?= ($old['governorate'] ?? '') === 'أريحا' ? 'selected' : '' ?>>أريحا</option>
                            <option value="غزة" <?= ($old['governorate'] ?? '') === 'غزة' ? 'selected' : '' ?>>غزة</option>
                            <option value="الشمال" <?= ($old['governorate'] ?? '') === 'الشمال' ? 'selected' : '' ?>>الشمال</option>
                            <option value="خان يونس" <?= ($old['governorate'] ?? '') === 'خان يونس' ? 'selected' : '' ?>>خان يونس</option>
                            <option value="رفح" <?= ($old['governorate'] ?? '') === 'رفح' ? 'selected' : '' ?>>رفح</option>
                            <option value="الوسطى" <?= ($old['governorate'] ?? '') === 'الوسطى' ? 'selected' : '' ?>>الوسطى</option>
                        </select>
                        <?php if (isset($errors['governorate'])): ?>
                            <span class="error"><?= $this->e($errors['governorate'][0]) ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">المدينة/البلدة *</label>
                        <input type="text" id="city" name="city" required 
                               value="<?= $this->e($old['city'] ?? '') ?>">
                        <?php if (isset($errors['city'])): ?>
                            <span class="error"><?= $this->e($errors['city'][0]) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address">العنوان التفصيلي</label>
                    <textarea id="address" name="address" rows="3"><?= $this->e($old['address'] ?? '') ?></textarea>
                    <?php if (isset($errors['address'])): ?>
                        <span class="error"><?= $this->e($errors['address'][0]) ?></span>
                    <?php endif; ?>
                </div>
                
                <button type="submit" class="btn-submit">تسجيل المدرسة</button>
                
                <p style="text-align: center; margin-top: 1.5rem; color: #666;">
                    لديك حساب بالفعل؟
                    <a href="<?= $this->url('/login') ?>" style="color: #e11d48; font-weight: 600;">تسجيل الدخول</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
