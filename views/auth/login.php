<div class="auth-container">
    <div class="auth-card">
        <h1>تسجيل الدخول</h1>
        
        <form method="POST" action="<?= $this->url('/login') ?>">
            <input type="hidden" name="<?= $csrf_token_name ?? '_csrf_token' ?>" value="<?= $csrf_token ?>">
            
            <div class="form-group">
                <label for="identifier">رقم الجوال أو البريد الإلكتروني</label>
                <input type="text" id="identifier" name="identifier" required placeholder="0599123456 أو email@example.com">
            </div>
            
            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">تسجيل الدخول</button>
        </form>
        
        <div class="auth-links">
            <p>ليس لديك حساب؟</p>
            <a href="<?= $this->url('/register/student') ?>">تسجيل كطالب</a>
            <a href="<?= $this->url('/register/school') ?>">تسجيل كمنسق مدرسة</a>
        </div>
    </div>
</div>
