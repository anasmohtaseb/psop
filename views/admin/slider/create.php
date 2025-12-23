<?php
/**
 * Admin Slider - Create New Slide
 */
?>

<div class="admin-container">
    <div class="admin-header">
        <div>
            <h1 class="admin-title">➕ إضافة صورة جديدة للسلايدر</h1>
            <p class="admin-subtitle">أضف صورة جديدة للسلايدر الرئيسي في الصفحة الرئيسية</p>
        </div>
        <a href="<?= $this->url('/admin/slider') ?>" class="btn-outline">
            ← رجوع للقائمة
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="<?= $this->url('/admin/slider/store') ?>" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

            <div class="form-section">
                <h3 class="form-section-title">📝 معلومات الصورة</h3>
                
                <div class="form-group">
                    <label for="title_ar" class="required">عنوان الصورة</label>
                    <input type="text" 
                           id="title_ar" 
                           name="title_ar" 
                           class="form-control" 
                           placeholder="مثال: طلاب فلسطينيون يتألقون في الأوليمبياد"
                           value="<?= $this->e($_SESSION['old']['title_ar'] ?? '') ?>"
                           required>
                    <?php if (isset($_SESSION['errors']['title_ar'])): ?>
                        <span class="error-message"><?= $_SESSION['errors']['title_ar'][0] ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="description_ar">الوصف</label>
                    <textarea id="description_ar" 
                              name="description_ar" 
                              class="form-control" 
                              rows="3"
                              placeholder="وصف قصير يظهر أسفل العنوان في السلايدر"><?= $this->e($_SESSION['old']['description_ar'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="image" class="required">صورة السلايدر</label>
                    <input type="file" 
                           id="image" 
                           name="image" 
                           class="form-control" 
                           accept="image/jpeg,image/png,image/jpg,image/webp"
                           required>
                    <small class="form-help">
                        🖼️ الأبعاد المثالية: 1200x600 بكسل | الحجم الأقصى: 5MB | الصيغ المسموحة: JPG, PNG, WEBP
                    </small>
                    <div id="imagePreview" style="margin-top: 10px; display: none;">
                        <img id="previewImg" src="" alt="معاينة" style="max-width: 100%; max-height: 300px; border-radius: 12px; border: 2px solid #e5e7eb;">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">⚙️ إعدادات العرض</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="slide_order">ترتيب العرض</label>
                        <input type="number" 
                               id="slide_order" 
                               name="slide_order" 
                               class="form-control" 
                               min="0"
                               value="<?= $this->e($_SESSION['old']['slide_order'] ?? '0') ?>"
                               placeholder="0">
                        <small class="form-help">الترتيب يحدد تسلسل ظهور الصورة (0 = أول صورة)</small>
                    </div>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               <?= isset($_SESSION['old']['is_active']) ? 'checked' : 'checked' ?>>
                        <span>تفعيل الصورة (عرضها في السلايدر)</span>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    💾 حفظ الصورة
                </button>
                <a href="<?= $this->url('/admin/slider') ?>" class="btn-outline">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Image preview
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>

<?php unset($_SESSION['old'], $_SESSION['errors']); ?>
