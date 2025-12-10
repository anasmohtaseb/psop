<div class="dashboard-header" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">إدارة المستخدمين</h1>
            <p style="color: var(--text-muted);">عرض وإدارة جميع مستخدمي النظام</p>
        </div>
        <a href="<?= $this->url('/admin/users/create') ?>" style="background: var(--primary); color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <span style="font-size: 20px;">➕</span>
            إضافة مستخدم جديد
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 8px;">إجمالي المستخدمين</div>
        <div style="font-size: 32px; font-weight: 700; color: var(--text-main);"><?= $totalUsers ?></div>
    </div>
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 8px;">المستخدمين النشطين</div>
        <div style="font-size: 32px; font-weight: 700; color: #10b981;"><?= $activeUsers ?></div>
    </div>
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 8px;">قيد الانتظار</div>
        <div style="font-size: 32px; font-weight: 700; color: #f59e0b;"><?= $pendingUsers ?></div>
    </div>
</div>

<!-- Filters -->
<div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 14px;">البحث</label>
            <input type="text" name="search" value="<?= $this->e($filters['search']) ?>" placeholder="اسم، بريد، أو هاتف..." style="width: 100%; padding: 10px 14px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 10px; font-size: 14px;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 14px;">نوع المستخدم</label>
            <select name="type" style="width: 100%; padding: 10px 14px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 10px; font-size: 14px;">
                <option value="">الكل</option>
                <option value="student" <?= $filters['type'] === 'student' ? 'selected' : '' ?>>طالب</option>
                <option value="school_coordinator" <?= $filters['type'] === 'school_coordinator' ? 'selected' : '' ?>>منسق مدرسة</option>
                <option value="trainer" <?= $filters['type'] === 'trainer' ? 'selected' : '' ?>>مدرب</option>
                <option value="admin" <?= $filters['type'] === 'admin' ? 'selected' : '' ?>>مدير</option>
                <option value="competition_manager" <?= $filters['type'] === 'competition_manager' ? 'selected' : '' ?>>مدير مسابقات</option>
            </select>
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 14px;">الحالة</label>
            <select name="status" style="width: 100%; padding: 10px 14px; border: 2px solid rgba(148, 163, 184, 0.3); border-radius: 10px; font-size: 14px;">
                <option value="">الكل</option>
                <option value="active" <?= $filters['status'] === 'active' ? 'selected' : '' ?>>نشط</option>
                <option value="inactive" <?= $filters['status'] === 'inactive' ? 'selected' : '' ?>>غير نشط</option>
                <option value="pending" <?= $filters['status'] === 'pending' ? 'selected' : '' ?>>قيد الانتظار</option>
                <option value="suspended" <?= $filters['status'] === 'suspended' ? 'selected' : '' ?>>موقوف</option>
            </select>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: var(--primary); color: white; padding: 10px 20px; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; flex: 1;">بحث</button>
            <a href="<?= $this->url('/admin/users') ?>" style="background: #e2e8f0; color: var(--text-main); padding: 10px 20px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; justify-content: center;">إعادة تعيين</a>
        </div>
    </form>
</div>

<!-- Users Table -->
<div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 16px; text-align: right; font-weight: 600; color: var(--text-main);">المستخدم</th>
                <th style="padding: 16px; text-align: right; font-weight: 600; color: var(--text-main);">البريد الإلكتروني</th>
                <th style="padding: 16px; text-align: right; font-weight: 600; color: var(--text-main);">الهاتف</th>
                <th style="padding: 16px; text-align: right; font-weight: 600; color: var(--text-main);">النوع</th>
                <th style="padding: 16px; text-align: right; font-weight: 600; color: var(--text-main);">الحالة</th>
                <th style="padding: 16px; text-align: right; font-weight: 600; color: var(--text-main);">تاريخ التسجيل</th>
                <th style="padding: 16px; text-align: center; font-weight: 600; color: var(--text-main);">الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="7" style="padding: 40px; text-align: center; color: var(--text-muted);">
                        لا توجد مستخدمين
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 16px;">
                            <div style="font-weight: 600; color: var(--text-main); margin-bottom: 4px;"><?= $this->e($user['name']) ?></div>
                            <div style="font-size: 12px; color: var(--text-muted);">ID: <?= $user['id'] ?></div>
                        </td>
                        <td style="padding: 16px; color: var(--text-main);"><?= $this->e($user['email']) ?></td>
                        <td style="padding: 16px; color: var(--text-main);"><?= $this->e($user['phone'] ?? '-') ?></td>
                        <td style="padding: 16px;">
                            <?php
                            $typeLabels = [
                                'student' => 'طالب',
                                'school_coordinator' => 'منسق مدرسة',
                                'trainer' => 'مدرب',
                                'admin' => 'مدير',
                                'competition_manager' => 'مدير مسابقات'
                            ];
                            $typeColors = [
                                'student' => '#3b82f6',
                                'school_coordinator' => '#8b5cf6',
                                'trainer' => '#06b6d4',
                                'admin' => '#ef4444',
                                'competition_manager' => '#f59e0b'
                            ];
                            ?>
                            <span style="background: <?= $typeColors[$user['type']] ?>15; color: <?= $typeColors[$user['type']] ?>; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 600;">
                                <?= $typeLabels[$user['type']] ?>
                            </span>
                        </td>
                        <td style="padding: 16px;">
                            <?php
                            $statusLabels = [
                                'active' => 'نشط',
                                'inactive' => 'غير نشط',
                                'pending' => 'قيد الانتظار',
                                'suspended' => 'موقوف'
                            ];
                            $statusColors = [
                                'active' => '#10b981',
                                'inactive' => '#6b7280',
                                'pending' => '#f59e0b',
                                'suspended' => '#ef4444'
                            ];
                            ?>
                            <span style="background: <?= $statusColors[$user['status']] ?>15; color: <?= $statusColors[$user['status']] ?>; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 600;">
                                <?= $statusLabels[$user['status']] ?>
                            </span>
                        </td>
                        <td style="padding: 16px; color: var(--text-muted); font-size: 14px;">
                            <?= date('Y/m/d', strtotime($user['created_at'])) ?>
                        </td>
                        <td style="padding: 16px;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="<?= $this->url('/admin/users/' . $user['id'] . '/edit') ?>" style="background: #3b82f6; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600;">تعديل</a>
                                <form method="POST" action="<?= $this->url('/admin/users/' . $user['id'] . '/delete') ?>" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
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
