<div class="dashboard-header" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="font-size: 14px; color: var(--text-muted); margin-bottom: 8px;">
                <a href="<?= $this->url('/dashboard/registrations') ?>" style="text-decoration: none; color: inherit;">تسجيلاتي</a>
                <span class="mx-2">/</span>
                <span style="color: var(--primary);">تفاصيل التسجيل #<?= $registration['id'] ?></span>
            </div>
            <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">
                <?= $this->e($registration['competition_name']) ?>
            </h1>
            <p style="color: var(--text-muted);">
                 نسخة <?= $registration['year'] ?> - <?= $this->e($registration['competition_code']) ?>
            </p>
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
            'submitted' => 'تم التقديم',
            'under_review' => 'قيد المراجعة',
            'accepted_training' => 'مقبول للتدريب',
            'accepted_final' => 'مقبول للنهائيات',
            'rejected' => 'مرفوض',
            'cancelled' => 'ملغي'
        ];
        $color = $statusColors[$registration['status']] ?? '#6b7280';
        $label = $statusLabels[$registration['status']] ?? $registration['status'];
        ?>
        <div style="background: <?= $color ?>; color: white; padding: 12px 24px; border-radius: 12px; font-weight: 700; font-size: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <?= $label ?>
        </div>
    </div>
</div>

<div class="row" style="display: flex; gap: 24px; flex-wrap: wrap;">
    <!-- Main Info -->
    <div class="col-8" style="flex: 2; min-width: 300px;">
        <div class="card" style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 24px;">
            <h3 style="color: var(--text-main); font-size: 18px; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                معلومات التسجيل
            </h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 24px;">
                <div>
                    <div style="color: var(--text-muted); font-size: 13px; margin-bottom: 4px;">تاريخ التسجيل</div>
                    <div style="color: var(--text-main); font-weight: 600;">
                        <?= date('Y/m/d h:i A', strtotime($registration['created_at'])) ?>
                    </div>
                </div>
                <div>
                    <div style="color: var(--text-muted); font-size: 13px; margin-bottom: 4px;">نوع المشاركة</div>
                    <div style="color: var(--text-main); font-weight: 600;">
                        <?= $registration['registration_type'] === 'individual' ? '👤 فردي' : '👥 جماعي' ?>
                    </div>
                </div>
                <?php if ($registration['track_name']): ?>
                <div>
                    <div style="color: var(--text-muted); font-size: 13px; margin-bottom: 4px;">المسار</div>
                    <div style="color: var(--text-main); font-weight: 600;">
                        <?= $this->e($registration['track_name']) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($registration['notes'])): ?>
                <div style="background: #f8fafc; border-radius: 12px; padding: 16px; border: 1px solid #e2e8f0;">
                    <div style="color: var(--text-muted); font-size: 13px; margin-bottom: 8px;">ملاحظات الطالب</div>
                    <p style="margin: 0; color: var(--text-main); line-height: 1.6;">
                        <?= nl2br($this->e($registration['notes'])) ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Timeline / Status History could go here -->
    </div>

    <!-- Sidebar Info -->
    <div class="col-4" style="flex: 1; min-width: 300px;">
        <!-- Student Card -->
        <div class="card" style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 24px;">
            <h3 style="color: var(--text-main); font-size: 16px; margin-bottom: 16px; font-weight: 700;">
                الطالب المسجل
            </h3>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="width: 48px; height: 48px; background: #e11d48; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 20px;">
                    <?= mb_substr($registration['student_name'], 0, 1) ?>
                </div>
                <div>
                    <div style="font-weight: 700; color: var(--text-main);"><?= $this->e($registration['student_name']) ?></div>
                    <div style="font-size: 13px; color: var(--text-muted);"><?= $this->e($registration['student_email']) ?></div>
                </div>
            </div>
            <div style="padding-top: 16px; border-top: 1px solid #f1f5f9;">
                <div style="color: var(--text-muted); font-size: 13px; margin-bottom: 4px;">المدرسة</div>
                <div style="color: var(--text-main); font-weight: 600;">
                    <?= $this->e($registration['school_name'] ?? 'غير محدد') ?>
                </div>
            </div>
        </div>

        <!-- Competition Time -->
        <div class="card" style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 16px; padding: 24px;">
            <h3 style="color: #166534; font-size: 16px; margin-bottom: 16px; font-weight: 700;">
                📅 موعد المسابقة
            </h3>
            <?php if ($registration['competition_start_date']): ?>
                <div style="margin-bottom: 12px;">
                    <div style="color: #166534; opacity: 0.8; font-size: 13px;">تبدأ في</div>
                    <div style="color: #14532d; font-weight: 700; font-size: 18px;">
                        <?= date('Y/m/d', strtotime($registration['competition_start_date'])) ?>
                    </div>
                </div>
                <div>
                    <div style="color: #166534; opacity: 0.8; font-size: 13px;">تنتهي في</div>
                    <div style="color: #14532d; font-weight: 700; font-size: 18px;">
                        <?= date('Y/m/d', strtotime($registration['competition_end_date'])) ?>
                    </div>
                </div>
            <?php else: ?>
                <p style="color: #166534;">لم يتم تحديد موعد بعد</p>
            <?php endif; ?>
        </div>
    </div>
</div>
