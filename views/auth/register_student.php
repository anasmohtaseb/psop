<div class="auth-container">
    <div class="auth-card wide">
        <h1>تسجيل طالب جديد</h1>
        
        <form method="POST" action="<?= $this->url('/register/student') ?>">
            <input type="hidden" name="<?= $csrf_token_name ?? '_csrf_token' ?>" value="<?= $csrf_token ?>">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="name">الاسم الكامل *</label>
                    <input type="text" id="name" name="name" required value="<?= $_SESSION['old']['name'] ?? '' ?>">
                    <?php if (isset($_SESSION['errors']['name'])): ?>
                        <span class="error"><?= $this->e($_SESSION['errors']['name'][0]) ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="phone">رقم الجوال *</label>
                    <input type="tel" id="phone" name="phone" required value="<?= $_SESSION['old']['phone'] ?? '' ?>" placeholder="0599123456">
                    <small style="color: #6b7280; font-size: 13px; display: block; margin-top: 4px;">
                        ستستخدمه لتسجيل الدخول
                    </small>
                    <?php if (isset($_SESSION['errors']['phone'])): ?>
                        <span class="error"><?= $this->e($_SESSION['errors']['phone'][0]) ?></span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="email">البريد الإلكتروني (اختياري)</label>
                    <input type="email" id="email" name="email" value="<?= $_SESSION['old']['email'] ?? '' ?>">
                    <?php if (isset($_SESSION['errors']['email'])): ?>
                        <span class="error"><?= $this->e($_SESSION['errors']['email'][0]) ?></span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="password">كلمة المرور *</label>
                    <input type="password" id="password" name="password" required>
                    <?php if (isset($_SESSION['errors']['password'])): ?>
                        <span class="error"><?= $this->e($_SESSION['errors']['password'][0]) ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation">تأكيد كلمة المرور *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>
            
            
            <div class="form-row">
                <div class="form-group">
                    <label for="gender">الجنس *</label>
                    <select id="gender" name="gender" required>
                        <option value="">اختر...</option>
                        <option value="male" <?= ($_SESSION['old']['gender'] ?? '') === 'male' ? 'selected' : '' ?>>ذكر</option>
                        <option value="female" <?= ($_SESSION['old']['gender'] ?? '') === 'female' ? 'selected' : '' ?>>أنثى</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="date_of_birth">تاريخ الميلاد *</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" required value="<?= $_SESSION['old']['date_of_birth'] ?? '' ?>">
                </div>
                
                <div class="form-group">
                    <label for="grade">الصف الدراسي *</label>
                    <select id="grade" name="grade" required>
                        <option value="">اختر...</option>
                        <?php for ($i = 7; $i <= 12; $i++): ?>
                            <option value="<?= $i ?>" <?= ($_SESSION['old']['grade'] ?? '') == $i ? 'selected' : '' ?>>الصف <?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="school_id">المدرسة *</label>
                <select id="school_id" name="school_id" required>
                    <option value="">اختر المدرسة...</option>
                    <?php foreach ($schools as $school): ?>
                        <option value="<?= $school['id'] ?>" <?= ($_SESSION['old']['school_id'] ?? '') == $school['id'] ? 'selected' : '' ?>>
                            <?= $this->e($school['name']) ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="other" <?= ($_SESSION['old']['school_id'] ?? '') === 'other' ? 'selected' : '' ?>>أخرى (غير مدرجة)</option>
                </select>
            </div>
            
            <div class="form-group" id="other_school_group" style="display: none;">
                <label for="other_school_name">اسم المدرسة *</label>
                <input type="text" id="other_school_name" name="other_school_name" placeholder="اكتب اسم المدرسة..." value="<?= $_SESSION['old']['other_school_name'] ?? '' ?>">
                <small style="color: #6b7280; font-size: 13px; display: block; margin-top: 6px;">
                    سيتم مراجعة المدرسة وإضافتها للقائمة بعد الموافقة
                </small>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="guardian_name">اسم ولي الأمر</label>
                    <input type="text" id="guardian_name" name="guardian_name" value="<?= $_SESSION['old']['guardian_name'] ?? '' ?>">
                </div>
                
                <div class="form-group">
                    <label for="guardian_phone">هاتف ولي الأمر</label>
                    <input type="tel" id="guardian_phone" name="guardian_phone" value="<?= $_SESSION['old']['guardian_phone'] ?? '' ?>">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">تسجيل</button>
        </form>
        
        <div class="auth-links">
            <p>لديك حساب بالفعل؟ <a href="<?= $this->url('/login') ?>">تسجيل الدخول</a></p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const schoolSelect = document.getElementById('school_id');
    const otherSchoolGroup = document.getElementById('other_school_group');
    const otherSchoolInput = document.getElementById('other_school_name');
    
    function toggleOtherSchool() {
        if (schoolSelect.value === 'other') {
            otherSchoolGroup.style.display = 'block';
            otherSchoolInput.setAttribute('required', 'required');
        } else {
            otherSchoolGroup.style.display = 'none';
            otherSchoolInput.removeAttribute('required');
            otherSchoolInput.value = '';
        }
    }
    
    // Check on page load (for validation errors with old input)
    toggleOtherSchool();
    
    // Listen for changes
    schoolSelect.addEventListener('change', toggleOtherSchool);
});
</script>

<?php
// Clear old input and errors
unset($_SESSION['old']);
unset($_SESSION['errors']);
?>
