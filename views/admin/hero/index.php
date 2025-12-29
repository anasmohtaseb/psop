<?php
/**
 * Admin Hero Section Content Management
 */
?>

<div class="admin-container">
    <div class="admin-header">
        <div>
            <h1 class="admin-title">🎯 إدارة محتوى Hero Section</h1>
            <p class="admin-subtitle">تحكم في النص الرئيسي الذي يظهر بجانب السلايدر في الصفحة الرئيسية</p>
        </div>
        <a href="<?= $this->url('/admin/slider') ?>" class="btn-secondary">
            <span>🖼️</span> إدارة السلايدر
        </a>
    </div>

    <form method="POST" action="<?= $this->url('/admin/hero/update') ?>" class="hero-form">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        
        <div class="card" style="margin-bottom: 24px;">
            <div class="card-header" style="background: linear-gradient(135deg, #e11d48, #f97316); color: white; padding: 20px; border-radius: 12px 12px 0 0;">
                <h2 style="margin: 0; font-size: 20px;">📝 محتوى النص الرئيسي</h2>
                <p style="margin: 8px 0 0 0; font-size: 14px; opacity: 0.95;">هذا النص يظهر في الجهة اليمنى من Hero Section</p>
            </div>
            
            <div class="card-body" style="padding: 24px;">
                <!-- Hero Title -->
                <div class="form-group" style="margin-bottom: 24px;">
                    <label for="hero_title" class="form-label" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1f2937;">
                        <span style="font-size: 20px; margin-left: 8px;">✨</span>
                        العنوان الرئيسي
                        <span style="color: #ef4444;">*</span>
                    </label>
                    <div class="info-box" style="margin-bottom: 12px; background: #f0fdf4; border: 1px solid #86efac; padding: 12px; border-radius: 8px;">
                        <strong>💡 نصيحة:</strong> استخدم <code>&lt;span&gt;النص&lt;/span&gt;</code> لتلوين كلمة معينة باللون الوردي
                    </div>
                    <textarea 
                        name="hero_title" 
                        id="hero_title" 
                        rows="3"
                        class="form-control"
                        required
                        style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px; font-family: 'Cairo', sans-serif; resize: vertical;"
                        placeholder="مثال: اكتشاف ورعاية <span>العقول المبدعة</span> عبر الأوليمبيادات"
                    ><?= $this->e($hero_title) ?></textarea>
                    <small style="color: #6b7280; display: block; margin-top: 6px;">
                        يظهر كعنوان رئيسي كبير في أعلى الصفحة
                    </small>
                </div>

                <!-- Hero Subtitle -->
                <div class="form-group" style="margin-bottom: 24px;">
                    <label for="hero_subtitle" class="form-label" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1f2937;">
                        <span style="font-size: 20px; margin-left: 8px;">📋</span>
                        النص التوضيحي
                        <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea 
                        name="hero_subtitle" 
                        id="hero_subtitle" 
                        rows="6"
                        class="form-control"
                        required
                        style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; font-family: 'Cairo', sans-serif; line-height: 1.8; resize: vertical;"
                        placeholder="نص توضيحي عن الأولمبيادات العلمية وأهدافها..."
                    ><?= $this->e($hero_subtitle) ?></textarea>
                    <small style="color: #6b7280; display: block; margin-top: 6px;">
                        نص تفصيلي يشرح طبيعة الأولمبيادات وأهدافها (2-4 جمل)
                    </small>
                </div>

                <!-- Hero Footnote -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="hero_footnote" class="form-label" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1f2937;">
                        <span style="font-size: 20px; margin-left: 8px;">📌</span>
                        الملاحظة السفلية
                        <span style="color: #9ca3af; font-weight: 400; font-size: 14px;">(اختياري)</span>
                    </label>
                    <div class="info-box" style="margin-bottom: 12px; background: #fef3c7; border: 1px solid #fcd34d; padding: 12px; border-radius: 8px;">
                        <strong>💡 نصيحة:</strong> استخدم <code>&lt;strong&gt;النص&lt;/strong&gt;</code> لجعل النص غامقاً
                    </div>
                    <textarea 
                        name="hero_footnote" 
                        id="hero_footnote" 
                        rows="3"
                        class="form-control"
                        style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-family: 'Cairo', sans-serif; resize: vertical;"
                        placeholder="مثال: البوابة موجهة لطلبة المدارس والجامعات..."
                    ><?= $this->e($hero_footnote) ?></textarea>
                    <small style="color: #6b7280; display: block; margin-top: 6px;">
                        ملاحظة صغيرة تظهر أسفل النص الرئيسي (معلومات إضافية أو تنبيهات)
                    </small>
                </div>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="card" style="margin-bottom: 24px; border: 2px solid #e11d48;">
            <div class="card-header" style="background: #fff1f2; padding: 16px;">
                <h3 style="margin: 0; color: #e11d48; font-size: 18px;">
                    <span>👁️</span> معاينة مباشرة
                </h3>
            </div>
            <div class="card-body" style="padding: 32px; background: linear-gradient(135deg, rgba(225, 29, 72, 0.03), rgba(249, 115, 22, 0.03));">
                <div id="preview-content" style="max-width: 600px;">
                    <h1 id="preview-title" style="font-size: 32px; font-weight: 800; color: #1f2937; line-height: 1.3; margin-bottom: 16px;">
                        <!-- Will be updated by JavaScript -->
                    </h1>
                    <p id="preview-subtitle" style="font-size: 16px; color: #6b7280; line-height: 1.8; margin-bottom: 20px;">
                        <!-- Will be updated by JavaScript -->
                    </p>
                    <div id="preview-footnote" style="font-size: 14px; color: #9ca3af; padding: 12px; background: rgba(255, 255, 255, 0.8); border-radius: 8px; border-right: 4px solid #e11d48;">
                        <!-- Will be updated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 12px; justify-content: flex-start;">
            <button type="submit" class="btn-primary" style="padding: 14px 32px; font-size: 16px;">
                <span>💾</span> حفظ التغييرات
            </button>
            <a href="<?= $this->url('/dashboard') ?>" class="btn-secondary" style="padding: 14px 32px; font-size: 16px; text-decoration: none; display: inline-block;">
                <span>↩️</span> إلغاء
            </a>
        </div>
    </form>
</div>

<script>
// Live preview
function updatePreview() {
    const title = document.getElementById('hero_title').value;
    const subtitle = document.getElementById('hero_subtitle').value;
    const footnote = document.getElementById('hero_footnote').value;
    
    // Update preview with HTML rendering
    document.getElementById('preview-title').innerHTML = title || '<span style="color: #d1d5db;">عنوان فارغ</span>';
    document.getElementById('preview-subtitle').textContent = subtitle || 'نص توضيحي فارغ';
    document.getElementById('preview-footnote').innerHTML = footnote || '<span style="color: #d1d5db;">لا توجد ملاحظة</span>';
}

// Add event listeners
document.getElementById('hero_title').addEventListener('input', updatePreview);
document.getElementById('hero_subtitle').addEventListener('input', updatePreview);
document.getElementById('hero_footnote').addEventListener('input', updatePreview);

// Initial preview
updatePreview();

// Character counter
function addCharCounter(elementId, max = null) {
    const element = document.getElementById(elementId);
    const counter = document.createElement('div');
    counter.style.cssText = 'text-align: left; color: #6b7280; font-size: 13px; margin-top: 4px;';
    element.parentNode.appendChild(counter);
    
    function update() {
        const count = element.value.length;
        counter.textContent = `${count} حرف`;
        if (max && count > max) {
            counter.style.color = '#ef4444';
        } else {
            counter.style.color = '#6b7280';
        }
    }
    
    element.addEventListener('input', update);
    update();
}

addCharCounter('hero_title', 150);
addCharCounter('hero_subtitle', 500);
addCharCounter('hero_footnote', 300);
</script>

<style>
.hero-form .card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.form-control:focus {
    outline: none;
    border-color: #e11d48;
    box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.1);
}

.info-box strong {
    font-weight: 600;
}

.info-box code {
    background: rgba(0,0,0,0.05);
    padding: 2px 6px;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    font-size: 13px;
}

#preview-content h1 span {
    color: #e11d48;
}

#preview-content strong {
    font-weight: 700;
    color: #1f2937;
}
</style>
