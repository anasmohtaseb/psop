<?php
// صفحة "عن البوابة" الديناميكية - تُحمّل من قاعدة البيانات
$sections = $page['sections_by_key'] ?? [];
?>

<!-- Hero Section -->
<div class="hero" style="background: linear-gradient(135deg, #fdf2f8 0%, #fff5f7 50%, #fef2f2 100%); padding: 80px 0 60px; position: relative; overflow: hidden;">
    <div class="hero-pattern" style="position: absolute; inset: 0; opacity: 0.03; background: radial-gradient(circle at 20% 50%, var(--primary) 0%, transparent 50%), radial-gradient(circle at 80% 80%, #f97316 0%, transparent 50%);"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <div style="text-align: center; max-width: 800px; margin: 0 auto;">
            <?php if (isset($sections['hero_badge'])): ?>
                <div style="display: inline-block; padding: 8px 20px; background: linear-gradient(135deg, rgba(225, 29, 72, 0.1), rgba(249, 115, 22, 0.1)); border-radius: 999px; margin-bottom: 20px; font-size: 14px; font-weight: 600; color: var(--primary);">
                    <?= $this->e($sections['hero_badge']['section_title_ar']) ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($sections['hero_title'])): ?>
                <h1 style="font-size: clamp(32px, 4vw, 48px); font-weight: 800; color: var(--text-main); margin-bottom: 20px; line-height: 1.3;">
                    <?= $this->e($sections['hero_title']['section_title_ar']) ?>
                </h1>
            <?php endif; ?>
            
            <?php if (isset($sections['hero_description'])): ?>
                <p style="font-size: 18px; color: var(--text-muted); line-height: 1.8; max-width: 700px; margin: 0 auto;">
                    <?= $this->e($sections['hero_description']['section_title_ar']) ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<section style="padding: 80px 0; background: white;">
    <div class="container">
        <!-- Vision, Mission, Values Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; margin-bottom: 80px;">
            <?php 
            $cardSections = ['vision', 'mission', 'values'];
            foreach ($cardSections as $cardKey):
                if (isset($sections[$cardKey])):
                    $section = $sections[$cardKey];
            ?>
                <div style="text-align: center;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(225, 29, 72, 0.1), rgba(249, 115, 22, 0.1)); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 36px;">
                        <?= $this->e($section['section_icon'] ?? '🎯') ?>
                    </div>
                    <h3 style="font-size: 22px; font-weight: 700; color: var(--text-main); margin-bottom: 12px;">
                        <?= $this->e($section['section_title_ar']) ?>
                    </h3>
                    <p style="color: var(--text-muted); line-height: 1.8;">
                        <?= nl2br($this->e($section['section_content_ar'] ?? '')) ?>
                    </p>
                </div>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>

        <!-- About Olympiads Section -->
        <?php if (isset($sections['about_olympiads'])): ?>
            <div style="background: linear-gradient(135deg, #fdf2f8, #fff5f7); border-radius: 24px; padding: 60px 40px; margin-bottom: 80px;">
                <h2 style="font-size: 32px; font-weight: 700; color: var(--text-main); text-align: center; margin-bottom: 40px;">
                    <?= $this->e($sections['about_olympiads']['section_title_ar']) ?>
                </h2>
                <div style="max-width: 900px; margin: 0 auto;">
                    <?php
                    $content = $sections['about_olympiads']['section_content_ar'] ?? '';
                    // تحويل النص إلى فقرات وقوائم
                    $paragraphs = explode("\n\n", $content);
                    foreach ($paragraphs as $para):
                        $para = trim($para);
                        if (empty($para)) continue;
                        
                        if (strpos($para, '- ') !== false):
                            // قائمة
                            $items = explode("\n", $para);
                            echo '<ul style="color: var(--text-muted); line-height: 2; font-size: 17px; margin-right: 30px;">';
                            foreach ($items as $item):
                                $item = trim($item);
                                if (strpos($item, '- ') === 0):
                                    echo '<li style="margin-bottom: 12px;">' . $this->e(substr($item, 2)) . '</li>';
                                else:
                                    echo '<p style="color: var(--text-muted); line-height: 2; font-size: 17px; margin-bottom: 24px;">' . nl2br($this->e($item)) . '</p>';
                                endif;
                            endforeach;
                            echo '</ul>';
                        else:
                            // فقرة عادية
                            echo '<p style="color: var(--text-muted); line-height: 2; font-size: 17px; margin-bottom: 24px;">' . nl2br($this->e($para)) . '</p>';
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Statistics Section -->
        <?php if (!empty($page['stats'])): ?>
            <div style="text-align: center; margin-bottom: 60px;">
                <?php if (isset($sections['stats_title'])): ?>
                    <h2 style="font-size: 32px; font-weight: 700; color: var(--text-main); margin-bottom: 20px;">
                        <?= $this->e($sections['stats_title']['section_title_ar']) ?>
                    </h2>
                    <?php if (!empty($sections['stats_title']['section_content_ar'])): ?>
                        <p style="color: var(--text-muted); font-size: 17px; max-width: 600px; margin: 0 auto 50px;">
                            <?= $this->e($sections['stats_title']['section_content_ar']) ?>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; max-width: 1000px; margin: 0 auto;">
                    <?php foreach ($page['stats'] as $stat): ?>
                        <div style="background: white; border-radius: 20px; padding: 40px 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.06); border: 1px solid rgba(226, 232, 240, 0.6);">
                            <div style="font-size: 48px; font-weight: 800; background: linear-gradient(135deg, var(--primary), #f97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 10px;">
                                <?= $this->e($stat['stat_value']) ?>
                            </div>
                            <div style="color: var(--text-muted); font-weight: 600; font-size: 15px;">
                                <?= $this->e($stat['stat_label_ar']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- CTA Section -->
        <?php if (isset($sections['cta_title'])): ?>
            <div style="background: linear-gradient(135deg, var(--primary), #f97316); border-radius: 24px; padding: 60px 40px; text-align: center; color: white;">
                <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 20px;">
                    <?= $this->e($sections['cta_title']['section_title_ar']) ?>
                </h2>
                <?php if (!empty($sections['cta_title']['section_content_ar'])): ?>
                    <p style="font-size: 18px; opacity: 0.95; margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
                        <?= $this->e($sections['cta_title']['section_content_ar']) ?>
                    </p>
                <?php endif; ?>
                <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                    <a href="<?= $this->url('/register/student') ?>" class="btn" style="background: white; color: var(--primary); padding: 14px 32px; font-weight: 700; box-shadow: 0 10px 30px rgba(0,0,0,0.2); border: none;">
                        سجل الآن
                    </a>
                    <a href="<?= $this->url('/competitions') ?>" class="btn" style="background: rgba(255,255,255,0.2); color: white; padding: 14px 32px; font-weight: 700; border: 2px solid white; backdrop-filter: blur(10px);">
                        تصفح المسابقات
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
