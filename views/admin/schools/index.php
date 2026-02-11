<div class="dashboard-header" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">إدارة المدارس</h1>
            <p style="color: var(--text-muted);">عرض وإدارة جميع المدارس المسجلة</p>
        </div>
        <a href="<?= $this->url('/admin/schools/create') ?>" style="background: var(--primary); color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <span style="font-size: 20px;">➕</span>
            إضافة مدرسة جديدة
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 8px;">إجمالي المدارس</div>
        <div style="font-size: 32px; font-weight: 700; color: var(--text-main);"><?= $totalSchools ?></div>
    </div>
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 8px;">المدارس النشطة</div>
        <div style="font-size: 32px; font-weight: 700; color: #10b981;"><?= $activeSchools ?></div>
    </div>
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 8px;">قيد الانتظار</div>
        <div style="font-size: 32px; font-weight: 700; color: #f59e0b;"><?= $pendingSchools ?></div>
    </div>
</div>

<!-- Filters -->
<div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 14px;">البحث</label>
            <input type="text" name="search" value="<?= $this->e($filters['search']) ?>" placeholder="اسم المدرسة أو المدينة..." style="width: 100%; padding: 10px 14px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 10px; font-size: 14px;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 14px;">نوع المدرسة</label>
            <select name="type" style="width: 100%; padding: 10px 14px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 10px; font-size: 14px;">
                <option value="">الكل</option>
                <option value="government" <?= $filters['type'] === 'government' ? 'selected' : '' ?>>حكومية</option>
                <option value="private" <?= $filters['type'] === 'private' ? 'selected' : '' ?>>خاصة</option>
                <option value="unrwa" <?= $filters['type'] === 'unrwa' ? 'selected' : '' ?>>وكالة</option>
            </select>
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 14px;">المحافظة</label>
            <select name="governorate" style="width: 100%; padding: 10px 14px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 10px; font-size: 14px;">
                <option value="">الكل</option>
                <option value="الخليل" <?= $filters['governorate'] === 'الخليل' ? 'selected' : '' ?>>الخليل</option>
                <option value="رام الله" <?= $filters['governorate'] === 'رام الله' ? 'selected' : '' ?>>رام الله</option>
                <option value="القدس" <?= $filters['governorate'] === 'القدس' ? 'selected' : '' ?>>القدس</option>
                <option value="نابلس" <?= $filters['governorate'] === 'نابلس' ? 'selected' : '' ?>>نابلس</option>
                <option value="بيت لحم" <?= $filters['governorate'] === 'بيت لحم' ? 'selected' : '' ?>>بيت لحم</option>
                <option value="غزة" <?= $filters['governorate'] === 'غزة' ? 'selected' : '' ?>>غزة</option>
            </select>
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 14px;">الحالة</label>
            <select name="status" style="width: 100%; padding: 10px 14px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 10px; font-size: 14px;">
                <option value="">الكل</option>
                <option value="active" <?= $filters['status'] === 'active' ? 'selected' : '' ?>>نشط</option>
                <option value="pending" <?= $filters['status'] === 'pending' ? 'selected' : '' ?>>قيد الانتظار</option>
                <option value="inactive" <?= $filters['status'] === 'inactive' ? 'selected' : '' ?>>غير نشط</option>
            </select>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: var(--primary); color: white; padding: 10px 20px; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; flex: 1;">بحث</button>
            <a href="<?= $this->url('/admin/schools') ?>" style="background: #e2e8f0; color: var(--text-main); padding: 10px 20px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; justify-content: center;">إعادة تعيين</a>
        </div>
    </form>
</div>

<!-- Schools Table -->
<div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 16px; text-align: right; font-weight: 600; color: var(--text-main);">المدرسة</th>
                <th style="padding: 16px; text-align: right; font-weight: 600; color: var(--text-main);">النوع</th>
                <th style="padding: 16px; text-align: right; font-weight: 600; color: var(--text-main);">المحافظة</th>
                <th style="padding: 16px; text-align: right; font-weight: 600; color: var(--text-main);">المدينة</th>
                <th style="padding: 16px; text-align: right; font-weight: 600; color: var(--text-main);">الحالة</th>
                <th style="padding: 16px; text-align: center; font-weight: 600; color: var(--text-main);">الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($schools)): ?>
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-muted);">
                        لا توجد مدارس
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($schools as $school): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 16px;">
                            <div style="font-weight: 600; color: var(--text-main);"><?= $this->e($school['name']) ?></div>
                        </td>
                        <td style="padding: 16px;">
                            <?php
                            $typeLabels = [
                                'government' => 'حكومية',
                                'private' => 'خاصة',
                                'unrwa' => 'وكالة'
                            ];
                            $typeColors = [
                                'government' => '#3b82f6',
                                'private' => '#8b5cf6',
                                'unrwa' => '#10b981'
                            ];
                            ?>
                            <span style="background: <?= $typeColors[$school['type']] ?>15; color: <?= $typeColors[$school['type']] ?>; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 600;">
                                <?= $typeLabels[$school['type']] ?>
                            </span>
                        </td>
                        <td style="padding: 16px; color: var(--text-main);"><?= $this->e($school['governorate']) ?></td>
                        <td style="padding: 16px; color: var(--text-main);"><?= $this->e($school['city']) ?></td>
                        <td style="padding: 16px;">
                            <?php
                            $statusLabels = [
                                'active' => 'نشط',
                                'inactive' => 'غير نشط',
                                'pending' => 'قيد الانتظار'
                            ];
                            $statusColors = [
                                'active' => '#10b981',
                                'inactive' => '#6b7280',
                                'pending' => '#f59e0b'
                            ];
                            ?>
                            <span style="background: <?= $statusColors[$school['status']] ?>15; color: <?= $statusColors[$school['status']] ?>; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 600;">
                                <?= $statusLabels[$school['status']] ?>
                            </span>
                        </td>
                        <td style="padding: 16px;">
                            <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                <?php if ($school['status'] === 'active'): ?>
                                    <form method="POST" action="<?= $this->url('/admin/schools/' . $school['id'] . '/toggle-status') ?>" style="display: inline;">
                                        <input type="hidden" name="_csrf_token" value="<?= $this->generateCsrfToken() ?>">
                                        <button type="submit" style="background: #f59e0b; color: white; padding: 8px 16px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600;">إلغاء التفعيل</button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" action="<?= $this->url('/admin/schools/' . $school['id'] . '/toggle-status') ?>" style="display: inline;">
                                        <input type="hidden" name="_csrf_token" value="<?= $this->generateCsrfToken() ?>">
                                        <button type="submit" style="background: #10b981; color: white; padding: 8px 16px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600;">تفعيل</button>
                                    </form>
                                <?php endif; ?>
                                <a href="<?= $this->url('/admin/schools/' . $school['id'] . '/edit') ?>" style="background: #3b82f6; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600;">تعديل</a>
                                <form method="POST" action="<?= $this->url('/admin/schools/' . $school['id'] . '/delete') ?>" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذه المدرسة؟')">
                                    <input type="hidden" name="_csrf_token" value="<?= $this->generateCsrfToken() ?>">
                                    <button type="submit" style="background: #ef4444; color: white; padding: 8px 16px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600;">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
