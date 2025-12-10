<div class="dashboard-header" style="margin-bottom: 30px;">
    <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">إضافة مسابقة جديدة</h1>
    <p style="color: var(--text-muted);">املأ البيانات لإضافة مسابقة علمية جديدة</p>
</div>

<div class="card" style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 30px; max-width: 900px;">
    <form method="POST" action="<?= $this->url('/admin/competitions/store') ?>" enctype="multipart/form-data">
        <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
        
        <div style="display: grid; gap: 24px;">
            <!-- Arabic Name -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    الاسم بالعربية <span style="color: var(--primary);">*</span>
                </label>
                <input type="text" 
                       name="name_ar" 
                       required
                       value="<?= $this->e($_SESSION['old']['name_ar'] ?? '') ?>"
                       style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: border 0.2s;"
                       placeholder="مثال: الأولمبياد الدولي للرياضيات">
                <?php if (isset($_SESSION['errors']['name_ar'])): ?>
                    <span class="error" style="color: var(--primary); font-size: 13px; margin-top: 4px; display: block;">
                        <?= $this->e($_SESSION['errors']['name_ar']) ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- English Name -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    الاسم بالإنجليزية <span style="color: var(--primary);">*</span>
                </label>
                <input type="text" 
                       name="name_en" 
                       required
                       value="<?= $this->e($_SESSION['old']['name_en'] ?? '') ?>"
                       style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px;"
                       placeholder="Example: International Mathematical Olympiad">
            </div>

            <!-- Code and Category Row -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <!-- Code -->
                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                        الرمز <span style="color: var(--primary);">*</span>
                    </label>
                    <input type="text" 
                           name="code" 
                           required
                           value="<?= $this->e($_SESSION['old']['code'] ?? '') ?>"
                           style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; text-transform: uppercase;"
                           placeholder="مثال: IMO">
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                        الفئة <span style="color: var(--primary);">*</span>
                    </label>
                    <select name="category" 
                            required
                            style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px;">
                        <option value="">اختر الفئة</option>
                        <option value="mathematics" <?= ($_SESSION['old']['category'] ?? '') === 'mathematics' ? 'selected' : '' ?>>رياضيات</option>
                        <option value="informatics" <?= ($_SESSION['old']['category'] ?? '') === 'informatics' ? 'selected' : '' ?>>معلوماتية</option>
                        <option value="physics" <?= ($_SESSION['old']['category'] ?? '') === 'physics' ? 'selected' : '' ?>>فيزياء</option>
                        <option value="chemistry" <?= ($_SESSION['old']['category'] ?? '') === 'chemistry' ? 'selected' : '' ?>>كيمياء</option>
                        <option value="biology" <?= ($_SESSION['old']['category'] ?? '') === 'biology' ? 'selected' : '' ?>>أحياء</option>
                        <option value="ai" <?= ($_SESSION['old']['category'] ?? '') === 'ai' ? 'selected' : '' ?>>ذكاء اصطناعي</option>
                        <option value="cybersecurity" <?= ($_SESSION['old']['category'] ?? '') === 'cybersecurity' ? 'selected' : '' ?>>أمن سيبراني</option>
                        <option value="other" <?= ($_SESSION['old']['category'] ?? '') === 'other' ? 'selected' : '' ?>>أخرى</option>
                    </select>
                </div>
            </div>

            <!-- Logo Upload -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    شعار المسابقة
                </label>
                <div style="border: 2px dashed rgba(148, 163, 184, 0.3); border-radius: 12px; padding: 20px; text-align: center; background: var(--card-bg);">
                    <input type="file" 
                           name="logo" 
                           accept="image/*"
                           id="logoInput"
                           style="display: none;"
                           onchange="previewLogo(this)">
                    <div id="logoPreview" style="margin-bottom: 12px; display: none;">
                        <img id="logoImage" style="max-width: 120px; max-height: 120px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    </div>
                    <label for="logoInput" style="display: inline-block; padding: 10px 20px; background: var(--primary); color: white; border-radius: 999px; cursor: pointer; font-weight: 600; font-size: 14px;">
                        📁 اختر صورة الشعار
                    </label>
                    <p style="color: var(--text-muted); font-size: 13px; margin-top: 8px;">يفضل صورة PNG أو JPG بحجم 200x200 بكسل</p>
                </div>
            </div>

            <!-- Arabic Description -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    الوصف بالعربية
                </label>
                <textarea name="description_ar" 
                          rows="4"
                          style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; resize: vertical;"
                          placeholder="وصف تفصيلي للمسابقة..."><?= $this->e($_SESSION['old']['description_ar'] ?? '') ?></textarea>
            </div>

            <!-- English Description -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    الوصف بالإنجليزية
                </label>
                <textarea name="description_en" 
                          rows="4"
                          style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; resize: vertical;"
                          placeholder="Detailed description..."><?= $this->e($_SESSION['old']['description_en'] ?? '') ?></textarea>
            </div>

            <!-- Active Status -->
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           <?= isset($_SESSION['old']['is_active']) && $_SESSION['old']['is_active'] ? 'checked' : 'checked' ?>
                           style="width: 20px; height: 20px; cursor: pointer;">
                    <span style="font-weight: 600; color: var(--text-main);">المسابقة نشطة</span>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; gap: 12px; padding-top: 20px; border-top: 1px solid rgba(148, 163, 184, 0.1);">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    💾 حفظ المسابقة
                </button>
                <a href="<?= $this->url('/admin/competitions') ?>" 
                   class="btn btn-outline" 
                   style="flex: 1; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                    ❌ إلغاء
                </a>
            </div>
        </div>
    </form>
</div>

<?php 
unset($_SESSION['old']);
unset($_SESSION['errors']);
?>

<script>
function previewLogo(input) {
    const preview = document.getElementById('logoPreview');
    const image = document.getElementById('logoImage');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            image.src = e.target.result;
            preview.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
