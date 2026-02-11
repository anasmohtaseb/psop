<div class="dashboard-header" style="margin-bottom: 30px;">
    <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">تعديل بيانات المدرسة</h1>
    <p style="color: var(--text-muted);">تعديل بيانات المدرسة: <?= $this->e($school['name']) ?></p>
</div>

<div class="card" style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 30px; max-width: 900px;">
    <form method="POST" action="<?= $this->url('/admin/schools/update/' . $school['id']) ?>">
        <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
        
        <div style="display: grid; gap: 24px;">
            <!-- Name -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    اسم المدرسة <span style="color: var(--primary);">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       required
                       value="<?= $this->e($_SESSION['old']['name'] ?? $school['name']) ?>"
                       style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
                <?php if (isset($_SESSION['errors']['name'])): ?>
                    <div style="color: var(--primary); font-size: 14px; margin-top: 6px;"><?= $_SESSION['errors']['name'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Type -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    نوع المدرسة <span style="color: var(--primary);">*</span>
                </label>
                <select name="type" 
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
                    <option value="">اختر نوع المدرسة</option>
                    <?php 
                    $selectedType = $_SESSION['old']['type'] ?? $school['type'];
                    ?>
                    <option value="government" <?= $selectedType === 'government' ? 'selected' : '' ?>>حكومية</option>
                    <option value="private" <?= $selectedType === 'private' ? 'selected' : '' ?>>خاصة</option>
                    <option value="unrwa" <?= $selectedType === 'unrwa' ? 'selected' : '' ?>>وكالة</option>
                </select>
                <?php if (isset($_SESSION['errors']['type'])): ?>
                    <div style="color: var(--primary); font-size: 14px; margin-top: 6px;"><?= $_SESSION['errors']['type'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Governorate -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    المحافظة <span style="color: var(--primary);">*</span>
                </label>
                <select name="governorate" 
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
                    <option value="">اختر المحافظة</option>
                    <?php
                    $governorates = ['الخليل', 'رام الله', 'القدس', 'نابلس', 'بيت لحم', 'جنين', 'طولكرم', 'قلقيلية', 'سلفيت', 'أريحا', 'طوباس', 'غزة', 'خان يونس', 'رفح', 'الشمال', 'الوسطى'];
                    $selectedGov = $_SESSION['old']['governorate'] ?? $school['governorate'];
                    foreach ($governorates as $gov):
                    ?>
                    <option value="<?= $gov ?>" <?= $selectedGov === $gov ? 'selected' : '' ?>><?= $gov ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($_SESSION['errors']['governorate'])): ?>
                    <div style="color: var(--primary); font-size: 14px; margin-top: 6px;"><?= $_SESSION['errors']['governorate'] ?></div>
                <?php endif; ?>
            </div>

            <!-- City -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    المدينة <span style="color: var(--primary);">*</span>
                </label>
                <input type="text" 
                       name="city" 
                       required
                       value="<?= $this->e($_SESSION['old']['city'] ?? $school['city']) ?>"
                       style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
                <?php if (isset($_SESSION['errors']['city'])): ?>
                    <div style="color: var(--primary); font-size: 14px; margin-top: 6px;"><?= $_SESSION['errors']['city'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    العنوان
                </label>
                <textarea name="address" 
                          rows="3"
                          style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s; resize: vertical;"><?= $this->e($_SESSION['old']['address'] ?? $school['address']) ?></textarea>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">
                    الحالة
                </label>
                <select name="status" 
                        class="form-control"
                        style="width: 100%; padding: 12px 16px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 12px; font-size: 15px; transition: all 0.2s;">
                    <?php $selectedStatus = $_SESSION['old']['status'] ?? $school['status']; ?>
                    <option value="active" <?= $selectedStatus === 'active' ? 'selected' : '' ?>>نشط</option>
                    <option value="pending" <?= $selectedStatus === 'pending' ? 'selected' : '' ?>>معلق</option>
                    <option value="inactive" <?= $selectedStatus === 'inactive' ? 'selected' : '' ?>>غير نشط</option>
                </select>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 10px;">
                <button type="submit" style="background: linear-gradient(135deg, var(--primary) 0%, #be123c 100%); color: white; border: none; padding: 14px 32px; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s;">
                    حفظ التعديلات
                </button>
                <a href="<?= $this->url('/admin/schools') ?>" style="padding: 14px 24px; border-radius: 12px; font-size: 16px; font-weight: 600; text-decoration: none; color: var(--text-main); background: #f1f5f9; transition: all 0.2s;">
                    إلغاء
                </a>
            </div>
        </div>
    </form>
</div>
