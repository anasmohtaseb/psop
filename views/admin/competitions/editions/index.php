<div class="dashboard-header" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="font-size: 14px; color: var(--text-muted); margin-bottom: 8px;">
                <a href="<?= $this->url('/admin/competitions') ?>" style="text-decoration: none; color: inherit;">المسابقات</a>
                <span class="mx-2">/</span>
                <span style="color: var(--primary);"><?= $this->e($competition['name_ar']) ?></span>
            </div>
            <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">نسخ المسابقة (Editions)</h1>
            <p style="color: var(--text-muted);">إدارة السنوات والدورات الخاصة بالمسابقة</p>
        </div>
        <a href="<?= $this->url('/admin/competitions/' . $competition['id'] . '/editions/create') ?>" class="btn btn-primary">
            ➕ إضافة نسخة جديدة
        </a>
    </div>
</div>

<?php if (!empty($editions)): ?>
    <div class="card" style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--card-bg); border-bottom: 2px solid rgba(225, 29, 72, 0.1);">
                        <th style="padding: 16px; text-align: right; font-weight: 700; color: var(--text-main);">السنة</th>
                        <th style="padding: 16px; text-align: right; font-weight: 700; color: var(--text-main);">البلد المضيف</th>
                        <th style="padding: 16px; text-align: right; font-weight: 700; color: var(--text-main);">فترة التسجيل</th>
                        <th style="padding: 16px; text-align: right; font-weight: 700; color: var(--text-main);">تاريخ المسابقة</th>
                        <th style="padding: 16px; text-align: center; font-weight: 700; color: var(--text-main);">الحالة</th>
                        <th style="padding: 16px; text-align: center; font-weight: 700; color: var(--text-main);">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($editions as $edition): ?>
                        <tr style="border-bottom: 1px solid rgba(148, 163, 184, 0.1); transition: background 0.2s;">
                            <td style="padding: 16px;">
                                <span style="font-size: 16px; font-weight: 700; color: var(--primary);">
                                    <?= $this->e($edition['year']) ?>
                                </span>
                            </td>
                            <td style="padding: 16px; color: var(--text-main);">
                                <?= $this->e($edition['host_country'] ?? '-') ?>
                            </td>
                            <td style="padding: 16px; color: var(--text-muted); font-size: 14px;">
                                <?php if ($edition['registration_start_date']): ?>
                                    <div>من: <?= $edition['registration_start_date'] ?></div>
                                    <div>إلى: <?= $edition['registration_end_date'] ?></div>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td style="padding: 16px; color: var(--text-muted); font-size: 14px;">
                                <?php if ($edition['competition_start_date']): ?>
                                    <div>من: <?= $edition['competition_start_date'] ?></div>
                                    <div>إلى: <?= $edition['competition_end_date'] ?></div>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <?php
                                $statusClass = match($edition['status']) {
                                    'open' => 'bg-green-100 text-green-800',
                                    'draft' => 'bg-gray-100 text-gray-800',
                                    'completed' => 'bg-blue-100 text-blue-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    default => 'bg-yellow-100 text-yellow-800'
                                };
                                $statusLabel = match($edition['status']) {
                                    'open' => 'مفتوح للتسجيل',
                                    'draft' => 'مسودة',
                                    'completed' => 'مكتملة',
                                    'cancelled' => 'ملغاة',
                                    'registration_closed' => 'التسجيل مغلق',
                                    'ongoing' => 'جارية',
                                    'training' => 'مرحلة التدريب',
                                    default => $edition['status']
                                };
                                ?>
                                <span class="<?= $statusClass ?>" style="padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 600;">
                                    <?= $statusLabel ?>
                                </span>
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="<?= $this->url('/admin/competitions/' . $competition['id'] . '/editions/' . $edition['id'] . '/edit') ?>" 
                                       class="btn btn-sm btn-outline-primary"
                                       title="تعديل">
                                        ✏️
                                    </a>
                                    
                                    <form action="<?= $this->url('/admin/competitions/' . $competition['id'] . '/editions/' . $edition['id'] . '/delete') ?>" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذه النسخة؟');">
                                        <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <div style="font-size: 48px; margin-bottom: 20px;">📅</div>
        <h3 style="margin-bottom: 10px; color: var(--text-main);">لا توجد نسخ مضافة لهذا المسابقة</h3>
        <p style="color: var(--text-muted); margin-bottom: 20px;">قم بإضافة نسخة للسنة الحالية لبدء استقبال التسجيلات</p>
        <a href="<?= $this->url('/admin/competitions/' . $competition['id'] . '/editions/create') ?>" class="btn btn-primary">
            إضافة النسخة الأولى
        </a>
    </div>
<?php endif; ?>

<style>
.bg-green-100 { background-color: #dcfce7; }
.text-green-800 { color: #166534; }
.bg-gray-100 { background-color: #f3f4f6; }
.text-gray-800 { color: #1f2937; }
.bg-blue-100 { background-color: #dbeafe; }
.text-blue-800 { color: #1e40af; }
.bg-red-100 { background-color: #fee2e2; }
.text-red-800 { color: #991b1b; }
.bg-yellow-100 { background-color: #fef9c3; }
.text-yellow-800 { color: #854d0e; }
</style>
