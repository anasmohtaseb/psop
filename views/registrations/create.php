<div class="dashboard-header" style="margin-bottom: 30px;">
    <div>
        <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">
            التسجيل في <?= $this->e($edition['competition_name'] ?? 'المسابقة') ?>
        </h1>
        <p style="color: var(--text-muted); font-size: 16px;">
            نسخة <?= $edition['year'] ?? '' ?> - املأ النموذج أدناه لإتمام التسجيل
        </p>
    </div>
</div>

<!-- Competition Info Card -->
<div style="background: linear-gradient(135deg, #e11d48 0%, #be123c 100%); border-radius: 16px; padding: 24px; margin-bottom: 30px; color: white; box-shadow: 0 4px 16px rgba(225, 29, 72, 0.3);">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        <div>
            <div style="font-size: 13px; opacity: 0.9; margin-bottom: 6px;">المسابقة</div>
            <div style="font-size: 18px; font-weight: 700;"><?= $this->e($edition['competition_name'] ?? 'المسابقة') ?></div>
        </div>
        <div>
            <div style="font-size: 13px; opacity: 0.9; margin-bottom: 6px;">السنة</div>
            <div style="font-size: 18px; font-weight: 700;"><?= $edition['year'] ?? '' ?></div>
        </div>
        <div>
            <div style="font-size: 13px; opacity: 0.9; margin-bottom: 6px;">آخر موعد للتسجيل</div>
            <div style="font-size: 18px; font-weight: 700;"><?= date('Y-m-d', strtotime($edition['registration_end_date'])) ?></div>
        </div>
        <div>
            <div style="font-size: 13px; opacity: 0.9; margin-bottom: 6px;">الدولة المستضيفة</div>
            <div style="font-size: 18px; font-weight: 700;"><?= $this->e($edition['host_country'] ?? 'فلسطين') ?></div>
        </div>
    </div>
</div>

<!-- Student Profile Info -->
<div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <h3 style="color: var(--text-main); font-size: 18px; font-weight: 700; margin-bottom: 16px;">معلوماتك الشخصية</h3>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; padding: 20px; background: #f9fafb; border-radius: 12px;">
        <div>
            <div style="color: var(--text-muted); font-size: 13px; margin-bottom: 4px;">الاسم الكامل</div>
            <div style="color: var(--text-main); font-weight: 600;"><?= $this->e($profile['name'] ?? '') ?></div>
        </div>
        <div>
            <div style="color: var(--text-muted); font-size: 13px; margin-bottom: 4px;">البريد الإلكتروني</div>
            <div style="color: var(--text-main); font-weight: 600;"><?= $this->e($profile['email'] ?? '') ?></div>
        </div>
        <div>
            <div style="color: var(--text-muted); font-size: 13px; margin-bottom: 4px;">المدرسة</div>
            <div style="color: var(--text-main); font-weight: 600;"><?= $this->e($profile['school_name'] ?? 'غير محدد') ?></div>
        </div>
        <div>
            <div style="color: var(--text-muted); font-size: 13px; margin-bottom: 4px;">الصف الدراسي</div>
            <div style="color: var(--text-main); font-weight: 600;">الصف <?= $profile['grade'] ?? '' ?></div>
        </div>
    </div>
    
    <div style="background: #fef3c7; border-right: 3px solid #f59e0b; padding: 12px 16px; border-radius: 8px; margin-top: 16px;">
        <p style="color: #78350f; font-size: 14px; margin: 0;">
            ℹ️ تأكد من صحة بياناتك قبل إرسال الطلب. يمكنك تحديث معلوماتك من <a href="<?= $this->url('/dashboard/profile') ?>" style="color: #f59e0b; font-weight: 600; text-decoration: underline;">الملف الشخصي</a>
        </p>
    </div>
</div>

<!-- Registration Form -->
<div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <h3 style="color: var(--text-main); font-size: 20px; font-weight: 700; margin-bottom: 24px;">نموذج التسجيل</h3>
    
    <form method="POST" action="<?= $this->url('/registrations/store') ?>">
        <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
        <input type="hidden" name="competition_edition_id" value="<?= $edition['id'] ?>">
        
        <?php if (!empty($edition['tracks'])): ?>
        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: var(--text-main); font-size: 15px;">
                المسار <span style="color: #ef4444;">*</span>
            </label>
            <select name="track_id" required style="width: 100%; padding: 14px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.3s;" onfocus="this.style.borderColor='var(--primary)';" onblur="this.style.borderColor='rgba(148, 163, 184, 0.3)';">
                <option value="">اختر المسار المناسب...</option>
                <?php foreach ($edition['tracks'] as $track): ?>
                    <option value="<?= $track['id'] ?>">
                        <?= $this->e($track['name_ar']) ?>
                        (<?= $track['participation_type'] === 'individual' ? 'فردي' : 'جماعي' ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($_SESSION['errors']['track_id'])): ?>
                <span style="color: #ef4444; font-size: 13px; display: block; margin-top: 6px;">
                    <?= $this->e($_SESSION['errors']['track_id'][0]) ?>
                </span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: var(--text-main); font-size: 15px;">
                ملاحظات أو معلومات إضافية
            </label>
            <textarea name="notes" rows="4" style="width: 100%; padding: 14px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; resize: vertical; transition: all 0.3s;" placeholder="أضف أي ملاحظات أو معلومات ترغب في إيصالها..." onfocus="this.style.borderColor='var(--primary)';" onblur="this.style.borderColor='rgba(148, 163, 184, 0.3)';"><?= $_SESSION['old']['notes'] ?? '' ?></textarea>
            <p style="color: var(--text-muted); font-size: 13px; margin-top: 6px;">
                يمكنك ذكر أي إنجازات سابقة أو خبرات علمية ذات صلة
            </p>
        </div>
        
        <!-- Terms and Conditions -->
        <div style="background: #f0fdf4; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
            <label style="display: flex; align-items: start; gap: 12px; cursor: pointer;">
                <input type="checkbox" name="accept_terms" value="1" required style="margin-top: 4px; width: 18px; height: 18px; cursor: pointer;">
                <span style="color: #065f46; font-size: 14px; line-height: 1.6;">
                    أوافق على <strong>الشروط والأحكام</strong> وأقر بأن جميع المعلومات المقدمة صحيحة ودقيقة. أتعهد بالالتزام بقواعد وأنظمة المسابقة.
                </span>
            </label>
        </div>
        
        <!-- Submit Buttons -->
        <div style="display: flex; gap: 12px; padding-top: 20px; border-top: 2px solid #f3f4f6;">
            <button type="submit" style="flex: 1; background: linear-gradient(135deg, var(--primary) 0%, #be123c 100%); color: white; border: none; padding: 16px 32px; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 12px rgba(225,29,72,0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(225,29,72,0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(225,29,72,0.3)';">
                ✓ إرسال طلب التسجيل
            </button>
            <a href="<?= $this->url('/dashboard') ?>" style="background: #f3f4f6; color: var(--text-main); border: none; padding: 16px 32px; border-radius: 12px; font-size: 16px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.background='#e5e7eb';" onmouseout="this.style.background='#f3f4f6';">
                إلغاء
            </a>
        </div>
    </form>
</div>

<!-- Important Notes -->
<div style="background: white; border-radius: 16px; padding: 24px; margin-top: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <h3 style="color: var(--text-main); font-size: 18px; font-weight: 700; margin-bottom: 16px;">📌 ملاحظات هامة</h3>
    
    <div style="display: grid; gap: 12px;">
        <div style="display: flex; gap: 12px; padding: 12px; background: #f9fafb; border-radius: 8px;">
            <span style="color: var(--primary); font-size: 20px;">1️⃣</span>
            <p style="color: var(--text-main); font-size: 14px; margin: 0; line-height: 1.6;">
                سيتم مراجعة طلبك من قبل الإدارة وسيصلك إشعار بالقبول أو الرفض عبر البريد الإلكتروني
            </p>
        </div>
        <div style="display: flex; gap: 12px; padding: 12px; background: #f9fafb; border-radius: 8px;">
            <span style="color: var(--primary); font-size: 20px;">2️⃣</span>
            <p style="color: var(--text-main); font-size: 14px; margin: 0; line-height: 1.6;">
                في حالة القبول، ستبدأ مرحلة التدريب في التاريخ المحدد وهي إلزامية للمشاركة في المسابقة
            </p>
        </div>
        <div style="display: flex; gap: 12px; padding: 12px; background: #f9fafb; border-radius: 8px;">
            <span style="color: var(--primary); font-size: 20px;">3️⃣</span>
            <p style="color: var(--text-main); font-size: 14px; margin: 0; line-height: 1.6;">
                يمكنك متابعة حالة تسجيلك من خلال <a href="<?= $this->url('/dashboard/registrations') ?>" style="color: var(--primary); font-weight: 600;">صفحة تسجيلاتي</a>
            </p>
        </div>
    </div>
</div>

<?php
// Clear old input and errors
unset($_SESSION['old']);
unset($_SESSION['errors']);
?>
