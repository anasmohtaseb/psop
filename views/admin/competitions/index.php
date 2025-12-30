<div class="dashboard-header" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">إدارة المسابقات</h1>
            <p style="color: var(--text-muted);">عرض وإدارة جميع المسابقات العلمية</p>
        </div>
        <a href="<?= $this->url('/admin/competitions/create') ?>" class="btn btn-primary">
            ➕ إضافة مسابقة جديدة
        </a>
    </div>
</div>

<?php if (!empty($competitions)): ?>
    <div class="card" style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--card-bg); border-bottom: 2px solid rgba(225, 29, 72, 0.1);">
                        <th style="padding: 16px; text-align: right; font-weight: 700; color: var(--text-main);">#</th>
                        <th style="padding: 16px; text-align: center; font-weight: 700; color: var(--text-main);">الشعار</th>
                        <th style="padding: 16px; text-align: right; font-weight: 700; color: var(--text-main);">الاسم بالعربية</th>
                        <th style="padding: 16px; text-align: right; font-weight: 700; color: var(--text-main);">الرمز</th>
                        <th style="padding: 16px; text-align: right; font-weight: 700; color: var(--text-main);">الفئة</th>
                        <th style="padding: 16px; text-align: center; font-weight: 700; color: var(--text-main);">الحالة</th>
                        <th style="padding: 16px; text-align: center; font-weight: 700; color: var(--text-main);">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($competitions as $comp): ?>
                        <tr style="border-bottom: 1px solid rgba(148, 163, 184, 0.1); transition: background 0.2s;">
                            <td style="padding: 16px; color: var(--text-muted);"><?= $comp['id'] ?></td>
                            <td style="padding: 16px; text-align: center;">
                                <?php if (!empty($comp['logo_path'])): ?>
                                    <img src="<?= $this->asset($comp['logo_path']) ?>" 
                                         alt="<?= $this->e($comp['name_ar']) ?>"
                                         style="width: 40px; height: 40px; object-fit: contain; border-radius: 8px; background: var(--card-bg); padding: 4px;">
                                <?php else: ?>
                                    <div style="width: 40px; height: 40px; margin: 0 auto; background: linear-gradient(135deg, #0ea5e9, #22c55e); opacity: 0.2; border-radius: 8px;"></div>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 16px; color: var(--text-main); font-weight: 600;">
                                <?= $this->e($comp['name_ar']) ?>
                            </td>
                            <td style="padding: 16px;">
                                <span style="display: inline-block; padding: 4px 12px; background: var(--primary-soft); color: var(--primary); border-radius: 999px; font-size: 13px; font-weight: 600;">
                                    <?= $this->e($comp['code']) ?>
                                </span>
                            </td>
                            <td style="padding: 16px; color: var(--text-muted);">
                                <?php
                                $categories = [
                                    'mathematics' => 'رياضيات',
                                    'informatics' => 'معلوماتية',
                                    'physics' => 'فيزياء',
                                    'chemistry' => 'كيمياء',
                                    'biology' => 'أحياء',
                                    'ai' => 'ذكاء اصطناعي',
                                    'cybersecurity' => 'أمن سيبراني',
                                    'other' => 'أخرى'
                                ];
                                echo $categories[$comp['category']] ?? $comp['category'];
                                ?>
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <?php if ($comp['is_active']): ?>
                                    <span style="display: inline-block; padding: 6px 14px; background: #22c55e; color: white; border-radius: 999px; font-size: 13px; font-weight: 600;">
                                        نشط
                                    </span>
                                <?php else: ?>
                                    <span style="display: inline-block; padding: 6px 14px; background: #6b7280; color: white; border-radius: 999px; font-size: 13px; font-weight: 600;">
                                        معطل
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="<?= $this->url('/competitions/' . $comp['id']) ?>" 
                                       style="display: inline-block; padding: 6px 12px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600;"
                                       title="عرض">
                                        👁️ عرض
                                    </a>
                                    <a href="<?= $this->url('/admin/competitions/' . $comp['id'] . '/edit') ?>" 
                                       style="display: inline-block; padding: 6px 12px; background: rgba(249, 115, 22, 0.1); color: #f97316; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600;"
                                       title="تعديل">
                                        ✏️ تعديل
                                    </a>
                                    <a href="<?= $this->url('/admin/competitions/' . $comp['id'] . '/images') ?>"
                                       style="display: inline-block; padding: 6px 12px; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600;"
                                       title="مكتبة الصور">
                                        🖼️ مكتبة الصور
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="card" style="background: var(--card-bg); border: 2px dashed rgba(225, 29, 72, 0.2); border-radius: 16px; padding: 60px; text-align: center;">
        <div style="font-size: 48px; margin-bottom: 16px;">📚</div>
        <h3 style="color: var(--text-main); margin-bottom: 8px;">لا توجد مسابقات</h3>
        <p style="color: var(--text-muted); margin-bottom: 24px;">ابدأ بإضافة أول مسابقة علمية</p>
        <a href="<?= $this->url('/admin/competitions/create') ?>" class="btn btn-primary">
            ➕ إضافة مسابقة جديدة
        </a>
    </div>
<?php endif; ?>
