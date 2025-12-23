<?php
/**
 * Admin Slider - Edit Slide
 */
?>

<div class="admin-container">
    <div class="admin-header">
        <div>
            <h1 class="admin-title">✏️ تعديل صورة السلايدر</h1>
            <p class="admin-subtitle">تعديل معلومات وإعدادات صورة السلايدر</p>
        </div>
        <a href="<?= $this->url('/admin/slider') ?>" class="btn-outline">
            ← رجوع للقائمة
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="<?= $this->url('/admin/slider/update') ?>" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <input type="hidden" name="id" value="<?= $slide['id'] ?>">

            <div class="form-section">
                <h3 class="form-section-title">📝 معلومات الصورة</h3>
                
                <div class="form-group">
                    <label for="title_ar" class="required">عنوان الصورة</label>
                    <input type="text" 
                           id="title_ar" 
                           name="title_ar" 
                           class="form-control" 
                           value="<?= $this->e($slide['title_ar']) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label for="description_ar">الوصف</label>
                    <textarea id="description_ar" 
                              name="description_ar" 
                              class="form-control" 
                              rows="3"><?= $this->e($slide['description_ar']) ?></textarea>
                </div>

                <div class="form-group">
                    <label>الصورة الحالية</label>
                    <div style="margin-bottom: 15px;">
                        <img src="<?= $this->asset($slide['image_path']) ?>" 
                             alt="<?= $this->e($slide['title_ar']) ?>"
                             style="max-width: 100%; max-height: 300px; border-radius: 12px; border: 2px solid #e5e7eb;"
                             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'200\'%3E%3Crect fill=\'%23e5e7eb\' width=\'400\' height=\'200\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' font-size=\'24\' fill=\'%23666\' text-anchor=\'middle\' dy=\'.3em\'%3E🖼️ الصورة غير متوفرة%3C/text%3E%3C/svg%3E'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">تغيير الصورة (اختياري)</label>
                    <input type="file" 
                           id="image" 
                           name="image" 
                           class="form-control" 
                           accept="image/jpeg,image/png,image/jpg,image/webp">
                    <small class="form-help">
                        🖼️ اترك الحقل فارغاً للاحتفاظ بالصورة الحالية | الأبعاد المثالية: 1200x600 بكسل
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
                               value="<?= $slide['slide_order'] ?>">
                        <small class="form-help">الترتيب يحدد تسلسل ظهور الصورة (0 = أول صورة)</small>
                    </div>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               <?= $slide['is_active'] ? 'checked' : '' ?>>
                        <span>تفعيل الصورة (عرضها في السلايدر)</span>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    💾 حفظ التعديلات
                </button>
                <a href="<?= $this->url('/admin/slider') ?>" class="btn-outline">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Image preview for new upload
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
