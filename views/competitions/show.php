<div class="hero" style="padding: 50px 0; background: linear-gradient(135deg, rgba(225, 29, 72, 0.05), rgba(249, 115, 22, 0.05));">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto; text-align: center;">
            <?php if (!empty($competition['logo_path'])): ?>
                <img src="<?= $this->asset($competition['logo_path']) ?>" 
                     alt="<?= $this->e($competition['name_ar']) ?>"
                     style="width: 120px; height: 120px; margin: 0 auto 20px; border-radius: 20px; object-fit: contain; background: white; padding: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <?php else: ?>
                <div style="width: 80px; height: 80px; margin: 0 auto 20px; border-radius: 20px; background: linear-gradient(135deg, #0ea5e9, #22c55e); opacity: 0.14;"></div>
            <?php endif; ?>
            <h1 class="section-title" style="margin-bottom: 10px;"><?= $this->e($competition['name_ar']) ?></h1>
            <div style="font-size: 18px; color: var(--primary); font-weight: 600; margin-bottom: 15px;">
                <?= $this->e($competition['code']) ?>
            </div>
            <p style="color: var(--text-muted); font-size: 16px; line-height: 1.8;">
                <?= $this->e($competition['description_ar'] ?? 'مسابقة علمية دولية') ?>
            </p>
        </div>
    </div>
</div>

<section>
    <div class="container">
        <div class="card" style="background: var(--card-bg); border: none; box-shadow: 0 14px 36px rgba(248, 113, 113, 0.15); border-radius: 22px; padding: 30px;">
            <h2 style="color: var(--text-main); margin-bottom: 20px;">معلومات عن المسابقة</h2>
            
            <div style="display: grid; gap: 20px;">
                <div>
                    <strong style="color: var(--text-main);">الفئة:</strong>
                    <span style="color: var(--text-muted); margin-right: 10px;">
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
                        echo $categories[$competition['category']] ?? $competition['category'];
                        ?>
                    </span>
                </div>
                
                <?php if (!empty($competition['description_en'])): ?>
                <div>
                    <strong style="color: var(--text-main);">الوصف بالإنجليزية:</strong>
                    <p style="color: var(--text-muted); margin-top: 8px; line-height: 1.8;">
                        <?= $this->e($competition['description_en']) ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($editions)): ?>
<section style="background: var(--card-bg);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">النسخ المتاحة</h2>
            <p class="section-subtitle">الدورات السابقة والحالية من المسابقة</p>
        </div>
        
        <div style="display: grid; gap: 20px; max-width: 900px; margin: 0 auto;">
            <?php foreach ($editions as $edition): ?>
                <div class="card" style="background: white; border: 1px solid rgba(225, 29, 72, 0.1); box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-radius: 16px; padding: 25px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; gap: 20px;">
                        <div style="flex: 1;">
                            <h3 style="color: var(--text-main); font-size: 20px; margin-bottom: 8px;">
                                نسخة عام <?= $this->e($edition['year']) ?>
                            </h3>
                            
                            <?php if (!empty($edition['host_country'])): ?>
                            <p style="color: var(--text-muted); margin-bottom: 15px;">
                                <strong>الدولة المضيفة:</strong> <?= $this->e($edition['host_country']) ?>
                            </p>
                            <?php endif; ?>
                            
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-top: 15px;">
                                <?php if (!empty($edition['registration_start_date'])): ?>
                                <div>
                                    <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">بداية التسجيل</div>
                                    <div style="font-weight: 600; color: var(--text-main);"><?= $this->e($edition['registration_start_date']) ?></div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($edition['registration_end_date'])): ?>
                                <div>
                                    <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">نهاية التسجيل</div>
                                    <div style="font-weight: 600; color: var(--text-main);"><?= $this->e($edition['registration_end_date']) ?></div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($edition['competition_start_date'])): ?>
                                <div>
                                    <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">بداية المسابقة</div>
                                    <div style="font-weight: 600; color: var(--text-main);"><?= $this->e($edition['competition_start_date']) ?></div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($edition['competition_end_date'])): ?>
                                <div>
                                    <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">نهاية المسابقة</div>
                                    <div style="font-weight: 600; color: var(--text-main);"><?= $this->e($edition['competition_end_date']) ?></div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div style="text-align: left;">
                            <?php
                            $statusColors = [
                                'draft' => '#6b7280',
                                'open_registration' => '#22c55e',
                                'closed_registration' => '#f59e0b',
                                'in_progress' => '#3b82f6',
                                'completed' => '#8b5cf6',
                                'cancelled' => '#ef4444'
                            ];
                            $statusLabels = [
                                'draft' => 'مسودة',
                                'open_registration' => 'مفتوح للتسجيل',
                                'closed_registration' => 'مغلق',
                                'in_progress' => 'جارية',
                                'completed' => 'مكتملة',
                                'cancelled' => 'ملغاة'
                            ];
                            $statusColor = $statusColors[$edition['status']] ?? '#6b7280';
                            $statusLabel = $statusLabels[$edition['status']] ?? $edition['status'];
                            ?>
                            <span style="display: inline-block; padding: 6px 14px; border-radius: 999px; font-size: 13px; font-weight: 600; background: <?= $statusColor ?>; color: white;">
                                <?= $statusLabel ?>
                            </span>
                            
                            <?php if ($edition['status'] === 'open_registration' && isset($_SESSION['user_id'])): ?>
                                <a href="<?= $this->url('/registrations/create/' . $edition['id']) ?>" 
                                   class="btn btn-primary" 
                                   style="display: inline-block; margin-top: 15px; padding: 10px 20px; text-decoration: none;">
                                    سجل الآن
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!isset($_SESSION['user_id'])): ?>
<section>
    <div class="container">
        <div class="card" style="background: linear-gradient(135deg, var(--primary), #f97316); border: none; border-radius: 22px; padding: 50px; text-align: center; color: white;">
            <h2 style="color: white; font-size: 28px; margin-bottom: 15px;">هل أنت مستعد للتحدي؟</h2>
            <p style="color: rgba(255, 255, 255, 0.9); font-size: 16px; margin-bottom: 25px;">
                سجل الآن وابدأ رحلتك في المسابقات العلمية الدولية
            </p>
            <a href="<?= $this->url('/register/student') ?>" 
               class="btn" 
               style="display: inline-block; padding: 12px 30px; background: white; color: var(--primary); font-weight: 700; text-decoration: none; border-radius: 999px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                سجل كطالب الآن
            </a>
        </div>
    </div>
</section>
<?php endif; ?>
