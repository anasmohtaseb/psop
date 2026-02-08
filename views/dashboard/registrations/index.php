<div class="dashboard-header" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">تسجيلاتي</h1>
            <p style="color: var(--text-muted);">عرض جميع تسجيلاتك في المسابقات</p>
        </div>
        <a href="<?= $this->url('/competitions') ?>" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);">
            <span style="font-size: 20px;">➕</span>
            تسجيل في مسابقة جديدة
        </a>
    </div>
</div>

<?php if (empty($registrations)): ?>
    <div style="background: white; border-radius: 16px; padding: 60px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="font-size: 64px; margin-bottom: 16px;">📝</div>
        <h3 style="color: var(--text-main); font-size: 20px; margin-bottom: 12px;">لا توجد تسجيلات</h3>
        <p style="color: var(--text-muted); margin-bottom: 24px;">لم تقم بالتسجيل في أي مسابقة حتى الآن</p>
        <a href="<?= $this->url('/competitions') ?>" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 12px 32px; border-radius: 12px; text-decoration: none; font-weight: 600; display: inline-block; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);">
            تصفح المسابقات المتاحة
        </a>
    </div>
<?php else: ?>
    <div style="display: grid; gap: 20px;">
        <?php foreach ($registrations as $reg): ?>
            <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-right: 4px solid var(--primary);">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                    <div>
                        <h3 style="color: var(--text-main); font-size: 20px; font-weight: 700; margin-bottom: 8px;">
                            <?= $this->e($reg['competition_name']) ?>
                        </h3>
                        <div style="display: flex; gap: 16px; color: var(--text-muted); font-size: 14px;">
                            <span>🏆 كود المسابقة: <?= $this->e($reg['competition_code']) ?></span>
                            <span>📅 السنة: <?= $reg['year'] ?></span>
                        </div>
                    </div>
                    <?php
                    $statusColors = [
                        'draft' => '#6b7280',
                        'submitted' => '#3b82f6',
                        'under_review' => '#f59e0b',
                        'accepted_training' => '#10b981',
                        'accepted_final' => '#059669',
                        'rejected' => '#ef4444',
                        'cancelled' => '#9ca3af'
                    ];
                    $statusLabels = [
                        'draft' => 'مسودة',
                        'submitted' => 'مقدمة',
                        'under_review' => 'قيد المراجعة',
                        'accepted_training' => 'مقبولة - مرحلة التدريب',
                        'accepted_final' => 'مقبولة - المسابقة النهائية',
                        'rejected' => 'مرفوضة',
                        'cancelled' => 'ملغاة'
                    ];
                    $color = $statusColors[$reg['status']] ?? '#6b7280';
                    $label = $statusLabels[$reg['status']] ?? $reg['status'];
                    ?>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <span style="background: <?= $color ?>; color: white; padding: 8px 16px; border-radius: 12px; font-size: 14px; font-weight: 600;">
                            <?= $label ?>
                        </span>
                        <a href="<?= $this->url('/registrations/view/' . $reg['id']) ?>" style="background: #f1f5f9; color: var(--text-muted); width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 10px; text-decoration: none; transition: all 0.2s;" title="عرض التفاصيل" onmouseover="this.style.background='#e2e8f0'; this.style.color='var(--primary)';" onmouseout="this.style.background='#f1f5f9'; this.style.color='var(--text-muted)';">
                            👁️
                        </a>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; padding: 16px; background: #f9fafb; border-radius: 12px; margin-bottom: 16px;">
                    <div>
                        <div style="color: var(--text-muted); font-size: 13px; margin-bottom: 4px;">نوع التسجيل</div>
                        <div style="color: var(--text-main); font-weight: 600;">
                            <?= $reg['registration_type'] === 'individual' ? '👤 فردي' : '👥 جماعي' ?>
                        </div>
                    </div>
                    <div>
                        <div style="color: var(--text-muted); font-size: 13px; margin-bottom: 4px;">تاريخ التسجيل</div>
                        <div style="color: var(--text-main); font-weight: 600;">
                            <?= date('Y-m-d', strtotime($reg['created_at'])) ?>
                        </div>
                    </div>
                    <div>
                        <div style="color: var(--text-muted); font-size: 13px; margin-bottom: 4px;">آخر تحديث</div>
                        <div style="color: var(--text-main); font-weight: 600;">
                            <?= date('Y-m-d', strtotime($reg['updated_at'])) ?>
                        </div>
                    </div>
                </div>

                <?php if (!empty($reg['notes'])): ?>
                    <div style="background: #fef3c7; border-right: 3px solid #f59e0b; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
                        <div style="color: #92400e; font-size: 13px; font-weight: 600; margin-bottom: 4px;">📝 ملاحظات:</div>
                        <div style="color: #78350f; font-size: 14px;"><?= $this->e($reg['notes']) ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($reg['status'] === 'accepted_training' || $reg['status'] === 'accepted_final'): ?>
                    <div style="background: #d1fae5; border-right: 3px solid #10b981; padding: 12px 16px; border-radius: 8px;">
                        <div style="color: #065f46; font-size: 13px; font-weight: 600; margin-bottom: 4px;">✅ تهانينا!</div>
                        <div style="color: #047857; font-size: 14px;">
                            تم قبولك في <?= $reg['status'] === 'accepted_training' ? 'مرحلة التدريب' : 'المسابقة النهائية' ?>. سيتم التواصل معك قريباً بتفاصيل المرحلة القادمة.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
