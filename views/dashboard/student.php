<div class="page-header">
    <h1 class="page-title">مرحباً، <?= $this->e($user['name']) ?> 👋</h1>
    <p class="page-subtitle">لوحة تحكم الطالب - تابع تسجيلاتك واستكشف المسابقات المتاحة</p>
</div>

<!-- Subscription Status Alert -->
<?php if ($this->isSubscriptionsEnabled() && isset($subscription_status)): ?>
    <?php if ($subscription_status['has_active']): ?>
    <div class="alert alert-success" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <strong>✓ اشتراكك نشط - <?= $this->e($subscription_status['plan_name']) ?></strong>
            <div style="font-size: 0.9rem; margin-top: 0.25rem;">
                صالح حتى: <?= date('Y-m-d', strtotime($subscription_status['end_date'])) ?>
                (<?= $subscription_status['days_remaining'] ?> يوم متبقي)
            </div>
        </div>
        <a href="<?= $this->url('/subscriptions/my-subscription') ?>" class="btn btn-sm btn-outline-success">التفاصيل</a>
    </div>
    <?php else: ?>
    <div class="alert alert-warning" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <strong>⚠️ لا يوجد اشتراك نشط</strong>
            <div style="font-size: 0.9rem; margin-top: 0.25rem;">للتسجيل في المسابقات، يجب تفعيل اشتراك سنوي</div>
        </div>
        <a href="<?= $this->url('/subscriptions/plans') ?>" class="btn btn-sm btn-primary">اشترك الآن</a>
    </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Quick Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon bg-info-soft">🏆</div>
        </div>
        <div class="stat-value"><?= count($open_competitions) ?></div>
        <div class="stat-label">المسابقات المتاحة للتسجيل</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon bg-primary-soft">📋</div>
        </div>
        <div class="stat-value"><?= count($registrations) ?></div>
        <div class="stat-label">إجمالي تسجيلاتي</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon bg-success-soft">✅</div>
        </div>
        <div class="stat-value">
            <?php 
            $accepted = array_filter($registrations, fn($r) => in_array($r['status'], ['accepted_training', 'accepted_final']));
            echo count($accepted);
            ?>
        </div>
        <div class="stat-label">طلبات مقبولة</div>
    </div>
</div>

<!-- Available Competitions -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">🏆 المسابقات المتاحة للتسجيل</h3>
        <a href="<?= $this->url('/competitions') ?>" class="btn btn-sm btn-nav-action">عرض الكل</a>
    </div>
    
    <div class="card-body">
        <?php if (!empty($open_competitions)): ?>
            <div style="display: grid; gap: 1rem;">
                <?php foreach ($open_competitions as $comp): ?>
                    <?php
                    $isRegistered = false;
                    foreach ($registrations as $reg) {
                        if ($reg['competition_edition_id'] == $comp['id']) {
                            $isRegistered = true;
                            break;
                        }
                    }
                    ?>
                    <div style="border: 1px solid var(--border-color); border-radius: 0.5rem; padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; background: <?= $isRegistered ? 'var(--bg-secondary)' : 'var(--bg-primary)' ?>;">
                        <div>
                            <h4 style="margin: 0 0 0.5rem 0; font-weight: 600; font-size: 1.1rem; color: var(--text-primary);"><?= $this->e($comp['name_ar']) ?> <span class="badge badge-primary"><?= $this->e($comp['code']) ?></span></h4>
                            <p style="margin: 0; color: var(--text-secondary); font-size: 0.9rem;">
                                <?= $this->e($comp['description_ar'] ?? 'لا يوجد وصف') ?>
                            </p>
                            <div style="margin-top: 0.5rem; font-size: 0.85rem; color: var(--text-tertiary);">
                                📅 ينتهي التسجيل: <?= date('Y/m/d', strtotime($comp['registration_end_date'])) ?>
                            </div>
                        </div>
                        
                        <?php if ($isRegistered): ?>
                            <span class="badge badge-success">تم التسجيل</span>
                        <?php else: ?>
                            <a href="<?= $this->url('/registrations/create/' . $comp['id']) ?>" class="btn btn-primary">سجل الآن</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem 0; color: var(--text-tertiary);">
                <div style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;">📭</div>
                <p>لا توجد مسابقات متاحة للتسجيل حالياً</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- My Recent Registrations -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">📝 تسجيلاتي الأخيرة</h3>
    </div>
    
    <div class="card-body">
        <?php if (!empty($registrations)): ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-color); text-align: right;">
                            <th style="padding: 1rem; color: var(--text-secondary); font-size: 0.85rem;">المسابقة</th>
                            <th style="padding: 1rem; color: var(--text-secondary); font-size: 0.85rem;">تاريخ التسجيل</th>
                            <th style="padding: 1rem; color: var(--text-secondary); font-size: 0.85rem;">الحالة</th>
                            <th style="padding: 1rem; color: var(--text-secondary); font-size: 0.85rem;">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($registrations, 0, 5) as $reg): ?>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 1rem;">
                                <div style="font-weight: 600; color: var(--text-primary);"><?= $this->e($reg['competition_name']) ?></div>
                                <div style="font-size: 0.85rem; color: var(--text-tertiary);"><?= $this->e($reg['edition_year']) ?></div>
                            </td>
                            <td style="padding: 1rem; color: var(--text-secondary);">
                                <?= date('Y/m/d', strtotime($reg['created_at'])) ?>
                            </td>
                            <td style="padding: 1rem;">
                                <?php
                                $statusMap = [
                                    'draft' => ['class' => 'badge-secondary', 'text' => 'مسودة'],
                                    'submitted' => ['class' => 'badge-info', 'text' => 'تم التقديم'],
                                    'under_review' => ['class' => 'badge-warning', 'text' => 'قيد المراجعة'],
                                    'accepted_training' => ['class' => 'badge-primary', 'text' => 'مقبول للتدريب'],
                                    'accepted_final' => ['class' => 'badge-success', 'text' => 'مقبول للنهائيات'],
                                    'rejected' => ['class' => 'badge-danger', 'text' => 'مرفوض'],
                                    'cancelled' => ['class' => 'badge-secondary', 'text' => 'ملغي']
                                ];
                                $s = $statusMap[$reg['status']] ?? ['class' => 'badge-secondary', 'text' => $reg['status']];
                                ?>
                                <span class="badge <?= $s['class'] ?>"><?= $s['text'] ?></span>
                            </td>
                            <td style="padding: 1rem;">
                                <a href="<?= $this->url('/registrations/view/' . $reg['id']) ?>" class="btn btn-sm btn-nav-action">عرض</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem 0; color: var(--text-tertiary);">
                <p>لم تقم بالتسجيل في أي مسابقة بعد</p>
            </div>
        <?php endif; ?>
    </div>
</div>
