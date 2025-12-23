<div class="dashboard-header">
    <div>
        <h1 class="dashboard-title">تعديل: <?= $this->e($page['page_title_ar']) ?></h1>
        <p class="dashboard-subtitle">إدارة محتوى وأقسام الصفحة</p>
    </div>
    <div>
        <a href="<?= $this->url('/admin/pages') ?>" class="btn btn-secondary">
            ← رجوع للصفحات
        </a>
        <a href="<?= $this->url('/' . $page['page_key']) ?>" class="btn btn-primary" target="_blank">
            معاينة الصفحة
        </a>
    </div>
</div>

<!-- معلومات الصفحة الأساسية -->
<div class="card mb-4">
    <div class="card-header">
        <h2>معلومات الصفحة الأساسية</h2>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= $this->url('/admin/pages/update-info') ?>">
            <input type="hidden" name="csrf_token" value="<?= $this->generateCsrfToken() ?>">
            <input type="hidden" name="page_id" value="<?= $page['id'] ?>">
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="page_title_ar">عنوان الصفحة (عربي) *</label>
                    <input type="text" id="page_title_ar" name="page_title_ar" class="form-control" 
                           value="<?= $this->e($page['page_title_ar']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="page_title_en">عنوان الصفحة (إنجليزي)</label>
                    <input type="text" id="page_title_en" name="page_title_en" class="form-control" 
                           value="<?= $this->e($page['page_title_en'] ?? '') ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="meta_description">وصف الصفحة (SEO)</label>
                <textarea id="meta_description" name="meta_description" class="form-control" rows="3"><?= $this->e($page['meta_description'] ?? '') ?></textarea>
                <small class="form-text">يستخدم في محركات البحث والمشاركات الاجتماعية</small>
            </div>
            
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" <?= $page['is_active'] ? 'checked' : '' ?>>
                    تفعيل الصفحة
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
        </form>
    </div>
</div>

<!-- الأقسام -->
<div class="card mb-4">
    <div class="card-header">
        <h2>أقسام الصفحة</h2>
        <button type="button" class="btn btn-primary" onclick="toggleAddSection()">+ إضافة قسم جديد</button>
    </div>
    <div class="card-body">
        <!-- نموذج إضافة قسم جديد -->
        <div id="addSectionForm" style="display: none; margin-bottom: 30px; padding: 20px; background: #f8fafc; border-radius: 8px;">
            <h3 style="margin-bottom: 20px;">إضافة قسم جديد</h3>
            <form method="POST" action="<?= $this->url('/admin/pages/create-section') ?>">
                <input type="hidden" name="csrf_token" value="<?= $this->generateCsrfToken() ?>">
                <input type="hidden" name="page_id" value="<?= $page['id'] ?>">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="new_section_key">مفتاح القسم *</label>
                        <input type="text" id="new_section_key" name="section_key" class="form-control" 
                               placeholder="hero_title, about_us, etc" required>
                        <small class="form-text">اسم تقني فريد بالإنجليزية فقط (بدون مسافات)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_section_type">نوع القسم *</label>
                        <select id="new_section_type" name="section_type" class="form-control" required>
                            <option value="text">نص</option>
                            <option value="hero">عنوان رئيسي</option>
                            <option value="cards">بطاقات</option>
                            <option value="stats">إحصائيات</option>
                            <option value="cta">دعوة لإجراء</option>
                            <option value="list">قائمة</option>
                            <option value="custom">مخصص</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="new_section_title_ar">عنوان القسم (عربي) *</label>
                        <input type="text" id="new_section_title_ar" name="section_title_ar" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_section_title_en">عنوان القسم (إنجليزي)</label>
                        <input type="text" id="new_section_title_en" name="section_title_en" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="new_section_content_ar">المحتوى (عربي)</label>
                    <textarea id="new_section_content_ar" name="section_content_ar" class="form-control" rows="4"></textarea>
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="new_section_icon">الأيقونة</label>
                        <input type="text" id="new_section_icon" name="section_icon" class="form-control" placeholder="🎯">
                        <small class="form-text">رمز تعبيري أو اسم أيقونة</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_section_order">الترتيب</label>
                        <input type="number" id="new_section_order" name="section_order" class="form-control" value="0">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">إضافة القسم</button>
                    <button type="button" class="btn btn-secondary" onclick="toggleAddSection()">إلغاء</button>
                </div>
            </form>
        </div>
        
        <!-- قائمة الأقسام الحالية -->
        <?php if (empty($page['sections'])): ?>
            <div class="alert alert-info">
                <p>لا توجد أقسام في هذه الصفحة بعد</p>
            </div>
        <?php else: ?>
            <div class="sections-list">
                <?php foreach ($page['sections'] as $section): ?>
                    <div class="section-item">
                        <div class="section-header">
                            <div>
                                <span class="section-badge"><?= $this->e($section['section_type']) ?></span>
                                <span class="section-icon"><?= $this->e($section['section_icon'] ?? '') ?></span>
                                <strong><?= $this->e($section['section_title_ar']) ?></strong>
                                <code style="margin-right: 10px; font-size: 12px;"><?= $this->e($section['section_key']) ?></code>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-primary" onclick="editSection(<?= $section['id'] ?>)">تعديل</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteSection(<?= $section['id'] ?>)">حذف</button>
                            </div>
                        </div>
                        
                        <div id="edit-section-<?= $section['id'] ?>" class="section-edit-form" style="display: none;">
                            <form method="POST" action="<?= $this->url('/admin/pages/update-section') ?>" class="section-form">
                                <input type="hidden" name="csrf_token" value="<?= $this->generateCsrfToken() ?>">
                                <input type="hidden" name="section_id" value="<?= $section['id'] ?>">
                                
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label>عنوان القسم (عربي)</label>
                                        <input type="text" name="section_title_ar" class="form-control" 
                                               value="<?= $this->e($section['section_title_ar']) ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>عنوان القسم (إنجليزي)</label>
                                        <input type="text" name="section_title_en" class="form-control" 
                                               value="<?= $this->e($section['section_title_en'] ?? '') ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>المحتوى (عربي)</label>
                                    <textarea name="section_content_ar" class="form-control" rows="6"><?= $this->e($section['section_content_ar'] ?? '') ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>المحتوى (إنجليزي)</label>
                                    <textarea name="section_content_en" class="form-control" rows="4"><?= $this->e($section['section_content_en'] ?? '') ?></textarea>
                                </div>
                                
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label>الأيقونة</label>
                                        <input type="text" name="section_icon" class="form-control" 
                                               value="<?= $this->e($section['section_icon'] ?? '') ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>الترتيب</label>
                                        <input type="number" name="section_order" class="form-control" 
                                               value="<?= $section['section_order'] ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="is_active" <?= $section['is_active'] ? 'checked' : '' ?>>
                                        تفعيل القسم
                                    </label>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                    <button type="button" class="btn btn-secondary" onclick="cancelEdit(<?= $section['id'] ?>)">إلغاء</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- الإحصائيات -->
<div class="card">
    <div class="card-header">
        <h2>الإحصائيات والأرقام</h2>
        <button type="button" class="btn btn-primary" onclick="toggleAddStat()">+ إضافة إحصائية</button>
    </div>
    <div class="card-body">
        <!-- نموذج إضافة إحصائية جديدة -->
        <div id="addStatForm" style="display: none; margin-bottom: 30px; padding: 20px; background: #f8fafc; border-radius: 8px;">
            <h3 style="margin-bottom: 20px;">إضافة إحصائية جديدة</h3>
            <form method="POST" action="<?= $this->url('/admin/pages/create-stat') ?>">
                <input type="hidden" name="csrf_token" value="<?= $this->generateCsrfToken() ?>">
                <input type="hidden" name="page_id" value="<?= $page['id'] ?>">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="new_stat_value">القيمة *</label>
                        <input type="text" id="new_stat_value" name="stat_value" class="form-control" 
                               placeholder="500+, 6+, etc" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_stat_order">الترتيب</label>
                        <input type="number" id="new_stat_order" name="stat_order" class="form-control" value="0">
                    </div>
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="new_stat_label_ar">النص (عربي) *</label>
                        <input type="text" id="new_stat_label_ar" name="stat_label_ar" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_stat_label_en">النص (إنجليزي)</label>
                        <input type="text" id="new_stat_label_en" name="stat_label_en" class="form-control">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">إضافة الإحصائية</button>
                    <button type="button" class="btn btn-secondary" onclick="toggleAddStat()">إلغاء</button>
                </div>
            </form>
        </div>
        
        <!-- قائمة الإحصائيات الحالية -->
        <?php if (empty($page['stats'])): ?>
            <div class="alert alert-info">
                <p>لا توجد إحصائيات في هذه الصفحة بعد</p>
            </div>
        <?php else: ?>
            <div class="stats-grid">
                <?php foreach ($page['stats'] as $stat): ?>
                    <div class="stat-item">
                        <div class="stat-value"><?= $this->e($stat['stat_value']) ?></div>
                        <div class="stat-label"><?= $this->e($stat['stat_label_ar']) ?></div>
                        <div class="stat-actions">
                            <button type="button" class="btn btn-sm btn-primary" onclick="editStat(<?= $stat['id'] ?>)">تعديل</button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteStat(<?= $stat['id'] ?>)">حذف</button>
                        </div>
                        
                        <div id="edit-stat-<?= $stat['id'] ?>" class="stat-edit-form" style="display: none;">
                            <form method="POST" action="<?= $this->url('/admin/pages/update-stat') ?>" class="stat-form">
                                <input type="hidden" name="csrf_token" value="<?= $this->generateCsrfToken() ?>">
                                <input type="hidden" name="stat_id" value="<?= $stat['id'] ?>">
                                
                                <div class="form-group">
                                    <label>القيمة</label>
                                    <input type="text" name="stat_value" class="form-control" 
                                           value="<?= $this->e($stat['stat_value']) ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>النص (عربي)</label>
                                    <input type="text" name="stat_label_ar" class="form-control" 
                                           value="<?= $this->e($stat['stat_label_ar']) ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>النص (إنجليزي)</label>
                                    <input type="text" name="stat_label_en" class="form-control" 
                                           value="<?= $this->e($stat['stat_label_en'] ?? '') ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>الترتيب</label>
                                    <input type="number" name="stat_order" class="form-control" 
                                           value="<?= $stat['stat_order'] ?>">
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                    <button type="button" class="btn btn-secondary" onclick="cancelStatEdit(<?= $stat['id'] ?>)">إلغاء</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.dashboard-header > div:last-child {
    display: flex;
    gap: 10px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #334155;
}

.form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.1);
}

.form-text {
    display: block;
    margin-top: 6px;
    font-size: 13px;
    color: #64748b;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.mb-4 {
    margin-bottom: 30px;
}

.sections-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.section-item {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px;
    background: white;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.section-badge {
    display: inline-block;
    padding: 4px 10px;
    background: #e0e7ff;
    color: #4338ca;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    margin-left: 8px;
}

.section-icon {
    font-size: 20px;
    margin-left: 8px;
}

.section-edit-form {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.stat-item {
    background: linear-gradient(135deg, #fdf2f8, #fff5f7);
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    border: 1px solid #fce7f3;
}

.stat-value {
    font-size: 36px;
    font-weight: 800;
    background: linear-gradient(135deg, var(--primary), #f97316);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 8px;
}

.stat-label {
    color: #64748b;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 16px;
}

.stat-actions {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.stat-edit-form {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #fce7f3;
}

.alert {
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.alert-info {
    background: #e0f2fe;
    color: #075985;
    border: 1px solid #bae6fd;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function toggleAddSection() {
    const form = document.getElementById('addSectionForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function toggleAddStat() {
    const form = document.getElementById('addStatForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function editSection(id) {
    const form = document.getElementById('edit-section-' + id);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function cancelEdit(id) {
    document.getElementById('edit-section-' + id).style.display = 'none';
}

function deleteSection(id) {
    if (!confirm('هل أنت متأكد من حذف هذا القسم؟')) return;
    
    const formData = new FormData();
    formData.append('csrf_token', '<?= $this->generateCsrfToken() ?>');
    formData.append('section_id', id);
    
    fetch('<?= $this->url('/admin/pages/delete-section') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('فشل حذف القسم: ' + data.message);
        }
    })
    .catch(error => {
        alert('حدث خطأ أثناء حذف القسم');
        console.error(error);
    });
}

function editStat(id) {
    const form = document.getElementById('edit-stat-' + id);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function cancelStatEdit(id) {
    document.getElementById('edit-stat-' + id).style.display = 'none';
}

function deleteStat(id) {
    if (!confirm('هل أنت متأكد من حذف هذه الإحصائية؟')) return;
    
    const formData = new FormData();
    formData.append('csrf_token', '<?= $this->generateCsrfToken() ?>');
    formData.append('stat_id', id);
    
    fetch('<?= $this->url('/admin/pages/delete-stat') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('فشل حذف الإحصائية: ' + data.message);
        }
    })
    .catch(error => {
        alert('حدث خطأ أثناء حذف الإحصائية');
        console.error(error);
    });
}
</script>
