<div class="dashboard-header" style="margin-bottom: 30px;">
    <div style="font-size: 14px; color: var(--text-muted); margin-bottom: 8px;">
        <a href="<?= $this->url('/admin/competitions') ?>" style="text-decoration: none; color: inherit;">المسابقات</a>
        <span class="mx-2">/</span>
        <a href="<?= $this->url('/admin/competitions/' . $competition['id'] . '/editions') ?>" style="text-decoration: none; color: inherit;"><?= $this->e($competition['name_ar']) ?></a>
        <span class="mx-2">/</span>
        <span style="color: var(--primary);">إضافة نسخة جديدة</span>
    </div>
    <h1 style="color: var(--text-main); font-size: 28px;">إضافة نسخة جديدة</h1>
</div>

<div class="card" style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto;">
    <form action="<?= $this->url('/admin/competitions/' . $competition['id'] . '/editions/store') ?>" method="POST">
        <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
        
        <div class="row" style="display: flex; gap: 24px; flex-wrap: wrap; margin-bottom: 20px;">
            <div class="col" style="flex: 1; min-width: 250px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">السنة *</label>
                <input type="number" name="year" class="form-control" required min="2000" max="2099" value="<?= date('Y') ?>"
                       style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;">
            </div>
            
            <div class="col" style="flex: 1; min-width: 250px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">البلد المضيف</label>
                <input type="text" name="host_country" class="form-control" placeholder="مثل: فلسطين"
                       style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;">
            </div>
        </div>

        <div class="row" style="display: flex; gap: 24px; flex-wrap: wrap; margin-bottom: 20px;">
            <div class="col" style="flex: 1; min-width: 250px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">حالة النسخة</label>
                <select name="status" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;">
                    <option value="draft">مسودة (Draft)</option>
                    <option value="open">مفتوح للتسجيل (Open)</option>
                    <option value="registration_closed">التسجيل مغلق (Registration Closed)</option>
                    <option value="training">مرحلة التدريب (Training)</option>
                    <option value="ongoing">المسابقة جارية (Ongoing)</option>
                    <option value="completed">مكتملة (Completed)</option>
                    <option value="cancelled">ملغاة (Cancelled)</option>
                </select>
            </div>
        </div>

        <h3 style="font-size: 18px; margin: 24px 0 16px; color: var(--primary); padding-bottom: 8px; border-bottom: 2px solid var(--primary-soft);">
            فترة التسجيل
        </h3>
        
        <div class="row" style="display: flex; gap: 24px; flex-wrap: wrap; margin-bottom: 20px;">
            <div class="col" style="flex: 1; min-width: 250px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">بداية التسجيل</label>
                <input type="date" name="registration_start_date" class="form-control"
                       style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;">
                <small style="color: var(--text-muted); display: block; margin-top: 4px;">متى يظهر زر التسجيل للطلاب</small>
            </div>
            
            <div class="col" style="flex: 1; min-width: 250px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">نهاية التسجيل</label>
                <input type="date" name="registration_end_date" class="form-control"
                       style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;">
                <small style="color: var(--text-muted); display: block; margin-top: 4px;">آخر يوم لقبول طلبات التسجيل</small>
            </div>
        </div>

        <h3 style="font-size: 18px; margin: 24px 0 16px; color: var(--primary); padding-bottom: 8px; border-bottom: 2px solid var(--primary-soft);">
            فترة المسابقة
        </h3>

        <div class="row" style="display: flex; gap: 24px; flex-wrap: wrap; margin-bottom: 20px;">
            <div class="col" style="flex: 1; min-width: 250px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">بداية المسابقة</label>
                <input type="date" name="competition_start_date" class="form-control"
                       style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;">
            </div>
            
            <div class="col" style="flex: 1; min-width: 250px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">نهاية المسابقة</label>
                <input type="date" name="competition_end_date" class="form-control"
                       style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;">
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">ملاحظات</label>
            <textarea name="notes" class="form-control" rows="4" 
                      style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit;"></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px;">
            <a href="<?= $this->url('/admin/competitions/' . $competition['id'] . '/editions') ?>" 
               class="btn" style="background: var(--bg-main); color: var(--text-main); padding: 12px 24px; border-radius: 8px; text-decoration: none;">
                إلغاء
            </a>
            <button type="submit" class="btn btn-primary" style="padding: 12px 32px; font-weight: 700;">
                حفظ النسخة
            </button>
        </div>
    </form>
</div>
