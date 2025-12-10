<div class="dashboard-header" style="margin-bottom: 30px;">
    <div>
        <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">مرحباً، <?= $this->e($user['name']) ?> 👋</h1>
        <p style="color: var(--text-muted); font-size: 16px;">لوحة تحكم الطالب - تابع تسجيلاتك واستكشف المسابقات المتاحة</p>
    </div>
</div>

<!-- Subscription Status Alert -->
<?php if (isset($subscription_status)): ?>
    <?php if ($subscription_status['has_active']): ?>
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; padding: 16px 20px; color: white; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="font-size: 16px; font-weight: 600; margin-bottom: 4px;">
                ✓ اشتراكك نشط - <?= $this->e($subscription_status['plan_name']) ?>
            </div>
            <div style="font-size: 13px; opacity: 0.9;">
                صالح حتى: <?= date('Y-m-d', strtotime($subscription_status['end_date'])) ?>
                (<?= $subscription_status['days_remaining'] ?> يوم متبقي)
            </div>
        </div>
        <a href="<?= $this->url('/subscriptions/my-subscription') ?>" style="background: rgba(255,255,255,0.2); color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600;">
            التفاصيل
        </a>
    </div>
    <?php else: ?>
    <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 12px; padding: 16px 20px; color: white; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="font-size: 16px; font-weight: 600; margin-bottom: 4px;">
                ⚠️ لا يوجد اشتراك نشط
            </div>
            <div style="font-size: 13px; opacity: 0.9;">
                للتسجيل في المسابقات، يجب تفعيل اشتراك سنوي
            </div>
        </div>
        <a href="<?= $this->url('/subscriptions/plans') ?>" style="background: white; color: #f59e0b; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 700;">
            اشترك الآن
        </a>
    </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Quick Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div style="background: linear-gradient(135deg, #e11d48 0%, #be123c 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 4px 12px rgba(225, 29, 72, 0.3);">
        <div style="font-size: 14px; opacity: 0.9; margin-bottom: 8px;">المسابقات المتاحة</div>
        <div style="font-size: 36px; font-weight: 800;"><?= count($open_competitions) ?></div>
        <div style="font-size: 13px; opacity: 0.8; margin-top: 4px;">متاحة للتسجيل الآن</div>
    </div>
    
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);">
        <div style="font-size: 14px; opacity: 0.9; margin-bottom: 8px;">تسجيلاتي</div>
        <div style="font-size: 36px; font-weight: 800;"><?= count($registrations) ?></div>
        <div style="font-size: 13px; opacity: 0.8; margin-top: 4px;">إجمالي التسجيلات</div>
    </div>
    
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
        <div style="font-size: 14px; opacity: 0.9; margin-bottom: 8px;">المقبولة</div>
        <div style="font-size: 36px; font-weight: 800;">
            <?php 
            $accepted = array_filter($registrations, fn($r) => in_array($r['status'], ['accepted_training', 'accepted_final']));
            echo count($accepted);
            ?>
        </div>
        <div style="font-size: 13px; opacity: 0.8; margin-top: 4px;">طلبات مقبولة</div>
    </div>
</div>

<!-- Available Competitions -->
<div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="color: var(--text-main); font-size: 22px; font-weight: 700; margin: 0;">🏆 المسابقات المتاحة للتسجيل</h2>
        <a href="<?= $this->url('/competitions') ?>" style="color: var(--primary); text-decoration: none; font-weight: 600; font-size: 14px;">
            عرض الكل ←
        </a>
    </div>
    
    <?php if (!empty($open_competitions)): ?>
        <div style="display: grid; gap: 16px;">
            <?php foreach ($open_competitions as $comp): ?>
                <?php
                // Check if already registered
                $isRegistered = false;
                foreach ($registrations as $reg) {
                    if ($reg['competition_edition_id'] == $comp['id']) {
                        $isRegistered = true;
                        break;
                    }
                }
                ?>
                <div style="border: 2px solid <?= $isRegistered ? '#10b981' : '#e5e7eb' ?>; border-radius: 14px; padding: 20px; transition: all 0.3s; <?= $isRegistered ? 'background: #f0fdf4;' : '' ?>"
                     onmouseover="if (!<?= $isRegistered ? 'true' : 'false' ?>) { this.style.borderColor='var(--primary)'; this.style.boxShadow='0 4px 12px rgba(225,29,72,0.1)'; }" 
                     onmouseout="if (!<?= $isRegistered ? 'true' : 'false' ?>) { this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'; }">
                    <div style="display: flex; justify-content: space-between; align-items: start; gap: 16px;">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                                <h3 style="color: var(--text-main); font-size: 18px; font-weight: 700; margin: 0;">
                                    <?= $this->e($comp['name_ar']) ?>
                                </h3>
                                <span style="background: var(--primary); color: white; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px;">
                                    <?= $this->e($comp['code']) ?>
                                </span>
                            </div>
                            
                            <div style="display: flex; gap: 20px; color: var(--text-muted); font-size: 14px; margin-bottom: 12px;">
                                <span>📅 السنة: <?= $comp['year'] ?></span>
                                <span>⏰ آخر موعد: <?= date('Y-m-d', strtotime($comp['registration_end_date'])) ?></span>
                                <?php
                                $daysLeft = (strtotime($comp['registration_end_date']) - time()) / (60 * 60 * 24);
                                if ($daysLeft > 0):
                                ?>
                                    <span style="color: <?= $daysLeft <= 7 ? '#ef4444' : '#10b981' ?>; font-weight: 600;">
                                        <?= (int)$daysLeft ?> يوم متبقي
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($isRegistered): ?>
                                <div style="background: #10b981; color: white; padding: 8px 14px; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600;">
                                    <span>✓</span>
                                    <span>مسجل بالفعل</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!$isRegistered): ?>
                            <a href="<?= $this->url('/registrations/create/' . $comp['id']) ?>" 
                               style="background: var(--primary); color: white; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px; white-space: nowrap; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;"
                               onmouseover="this.style.background='#be123c'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(225,29,72,0.4)';" 
                               onmouseout="this.style.background='var(--primary)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <span>سجل الآن</span>
                                <span>→</span>
                            </a>
                        <?php else: ?>
                            <a href="<?= $this->url('/dashboard/registrations') ?>" 
                               style="background: #f3f4f6; color: var(--text-main); padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px; white-space: nowrap;">
                                عرض التفاصيل
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 60px 20px; background: #f9fafb; border-radius: 12px;">
            <div style="font-size: 64px; margin-bottom: 16px; opacity: 0.5;">🏆</div>
            <h3 style="color: var(--text-main); font-size: 18px; font-weight: 700; margin-bottom: 8px;">
                لا توجد مسابقات متاحة للتسجيل حالياً
            </h3>
            <p style="color: var(--text-muted); font-size: 15px; margin-bottom: 20px;">
                تابع المنصة للحصول على آخر التحديثات حول المسابقات القادمة
            </p>
            <a href="<?= $this->url('/competitions') ?>" 
               style="background: var(--primary); color: white; padding: 10px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block;">
                تصفح جميع المسابقات
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- My Registrations -->
<div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="color: var(--text-main); font-size: 22px; font-weight: 700; margin: 0;">📝 تسجيلاتي الأخيرة</h2>
        <a href="<?= $this->url('/dashboard/registrations') ?>" style="color: var(--primary); text-decoration: none; font-weight: 600; font-size: 14px;">
            عرض الكل ←
        </a>
    </div>
    
    <?php if (!empty($registrations)): ?>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                        <th style="padding: 14px 12px; text-align: right; font-weight: 600; color: var(--text-main); font-size: 14px;">المسابقة</th>
                        <th style="padding: 14px 12px; text-align: right; font-weight: 600; color: var(--text-main); font-size: 14px;">السنة</th>
                        <th style="padding: 14px 12px; text-align: right; font-weight: 600; color: var(--text-main); font-size: 14px;">الحالة</th>
                        <th style="padding: 14px 12px; text-align: right; font-weight: 600; color: var(--text-main); font-size: 14px;">تاريخ التسجيل</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($registrations, 0, 5) as $reg): ?>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 14px 12px;">
                                <div style="font-weight: 600; color: var(--text-main);"><?= $this->e($reg['competition_name']) ?></div>
                                <div style="font-size: 12px; color: var(--text-muted);"><?= $this->e($reg['competition_code']) ?></div>
                            </td>
                            <td style="padding: 14px 12px; color: var(--text-main); font-weight: 500;"><?= $reg['year'] ?></td>
                            <td style="padding: 14px 12px;">
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
                                    'accepted_training' => 'مقبولة',
                                    'accepted_final' => 'مقبولة نهائي',
                                    'rejected' => 'مرفوضة',
                                    'cancelled' => 'ملغاة'
                                ];
                                $color = $statusColors[$reg['status']] ?? '#6b7280';
                                $label = $statusLabels[$reg['status']] ?? $reg['status'];
                                ?>
                                <span style="background: <?= $color ?>; color: white; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; display: inline-block;">
                                    <?= $label ?>
                                </span>
                            </td>
                            <td style="padding: 14px 12px; color: var(--text-muted); font-size: 14px;">
                                <?= date('Y-m-d', strtotime($reg['created_at'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 40px 20px; background: #f9fafb; border-radius: 12px;">
            <div style="font-size: 48px; margin-bottom: 12px; opacity: 0.5;">📋</div>
            <p style="color: var(--text-muted); font-size: 15px;">لم تسجل في أي مسابقة بعد</p>
        </div>
    <?php endif; ?>
</div>

<!-- Announcements -->
<?php if (!empty($announcements)): ?>
<div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <h2 style="color: var(--text-main); font-size: 22px; font-weight: 700; margin-bottom: 20px;">📢 الإعلانات</h2>
    
    <div style="display: grid; gap: 14px;">
        <?php foreach ($announcements as $announcement): ?>
            <div style="border-right: 3px solid var(--primary); padding: 14px 16px; background: #f9fafb; border-radius: 8px;">
                <div style="display: flex; justify-content: between; align-items: start; margin-bottom: 8px;">
                    <h3 style="color: var(--text-main); font-size: 16px; font-weight: 600; margin: 0;">
                        <?= $this->e($announcement['title'] ?? 'إعلان') ?>
                    </h3>
                    <span style="color: var(--text-muted); font-size: 13px;">
                        <?= date('Y-m-d', strtotime($announcement['created_at'])) ?>
                    </span>
                </div>
                <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6; margin: 0;">
                    <?= $this->e(mb_substr($announcement['content'] ?? '', 0, 150)) ?>...
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>