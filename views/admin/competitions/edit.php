<div class="dashboard-header" style="margin-bottom: 30px;">
    <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">تعديل المسابقة</h1>
    <p style="color: var(--text-muted);">تحديث بيانات المسابقة: <?= $this->e($competition['name_ar']) ?></p>
</div>

<div class="card" style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 30px; max-width: 900px;">
    <form method="POST" action="<?= $this->url('/admin/competitions/' . $competition['id'] . '/update') ?>" enctype="multipart/form-data">
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
                       value="<?= $this->e($_SESSION['old']['name_ar'] ?? $competition['name_ar']) ?>"
                       style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px;">
            </div>

            <!-- English Name -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    الاسم بالإنجليزية <span style="color: var(--primary);">*</span>
                </label>
                <input type="text" 
                       name="name_en" 
                       required
                       value="<?= $this->e($_SESSION['old']['name_en'] ?? $competition['name_en']) ?>"
                       style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px;">
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
                           value="<?= $this->e($_SESSION['old']['code'] ?? $competition['code']) ?>"
                           style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; text-transform: uppercase;">
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                        الفئة <span style="color: var(--primary);">*</span>
                    </label>
                    <select name="category" 
                            required
                            style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px;">
                        <?php $currentCategory = $_SESSION['old']['category'] ?? $competition['category']; ?>
                        <option value="mathematics" <?= $currentCategory === 'mathematics' ? 'selected' : '' ?>>رياضيات</option>
                        <option value="informatics" <?= $currentCategory === 'informatics' ? 'selected' : '' ?>>معلوماتية</option>
                        <option value="physics" <?= $currentCategory === 'physics' ? 'selected' : '' ?>>فيزياء</option>
                        <option value="chemistry" <?= $currentCategory === 'chemistry' ? 'selected' : '' ?>>كيمياء</option>
                        <option value="biology" <?= $currentCategory === 'biology' ? 'selected' : '' ?>>أحياء</option>
                        <option value="ai" <?= $currentCategory === 'ai' ? 'selected' : '' ?>>ذكاء اصطناعي</option>
                        <option value="cybersecurity" <?= $currentCategory === 'cybersecurity' ? 'selected' : '' ?>>أمن سيبراني</option>
                        <option value="other" <?= $currentCategory === 'other' ? 'selected' : '' ?>>أخرى</option>
                    </select>
                </div>
            </div>

            <!-- Logo Upload -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    شعار المسابقة
                </label>
                <div style="border: 2px dashed rgba(148, 163, 184, 0.3); border-radius: 12px; padding: 20px; text-align: center; background: var(--card-bg);">
                    <?php if (!empty($competition['logo_path'])): ?>
                        <div style="margin-bottom: 12px;">
                            <img src="<?= $this->asset($competition['logo_path']) ?>" 
                                 style="max-width: 120px; max-height: 120px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            <p style="color: var(--text-muted); font-size: 13px; margin-top: 8px;">الشعار الحالي</p>
                        </div>
                    <?php endif; ?>
                    <input type="file" 
                           name="logo" 
                           accept="image/*"
                           id="logoInput"
                           style="display: none;"
                           onchange="previewLogo(this)">
                    <div id="logoPreview" style="margin-bottom: 12px; display: none;">
                        <img id="logoImage" style="max-width: 120px; max-height: 120px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <p style="color: var(--text-muted); font-size: 13px; margin-top: 8px;">الشعار الجديد</p>
                    </div>
                    <label for="logoInput" style="display: inline-block; padding: 10px 20px; background: var(--primary); color: white; border-radius: 999px; cursor: pointer; font-weight: 600; font-size: 14px;">
                        📁 <?= !empty($competition['logo_path']) ? 'تغيير الشعار' : 'اختر صورة الشعار' ?>
                    </label>
                    <p style="color: var(--text-muted); font-size: 13px; margin-top: 8px;">يفضل صورة PNG أو JPG بحجم 200x200 بكسل</p>
                </div>
            </div>

            <!-- Arabic Description -->

            <!-- Short Description (Arabic) -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    الوصف المختصر بالعربية
                </label>
                <textarea name="description_ar" 
                          rows="3"
                          style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; resize: vertical;"><?= $this->e($_SESSION['old']['description_ar'] ?? $competition['description_ar'] ?? '') ?></textarea>
            </div>

            <!-- Short Description (English) -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    الوصف المختصر بالإنجليزية
                </label>
                <textarea name="description_en" 
                          rows="3"
                          style="width: 100%; padding: 12px 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; resize: vertical;"><?= $this->e($_SESSION['old']['description_en'] ?? $competition['description_en'] ?? '') ?></textarea>
            </div>

            <!-- Long Description (Arabic) -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    الوصف التفصيلي بالعربية (محرر نصوص)
                </label>
                <textarea name="long_description_ar" class="wysiwyg-ar" rows="8"><?= $this->e($_SESSION['old']['long_description_ar'] ?? $competition['long_description_ar'] ?? '') ?></textarea>
            </div>

            <!-- Long Description (English) -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    الوصف التفصيلي بالإنجليزية (WYSIWYG)
                </label>
                <textarea name="long_description_en" class="wysiwyg-en" rows="8"><?= $this->e($_SESSION['old']['long_description_en'] ?? $competition['long_description_en'] ?? '') ?></textarea>
            </div>

            <!-- Active Status -->
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           <?= ($competition['is_active'] ?? false) ? 'checked' : '' ?>
                           style="width: 20px; height: 20px; cursor: pointer;">
                    <span style="font-weight: 600; color: var(--text-main);">المسابقة نشطة</span>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; gap: 12px; padding-top: 20px; border-top: 1px solid rgba(148, 163, 184, 0.1);">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    💾 حفظ التعديلات
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
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script src="<?= $this->asset('js/summernote-loader.js') ?>"></script>
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
