<section id="competitions" class="section" style="padding: 60px 0; background: #f8fafc;">
    <div class="container">
        <div class="section-header" style="text-align: center; max-width: 800px; margin: 0 auto 50px;">
            <div class="section-title" style="font-size: 38px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">
                المسابقات الدولية المعتمدة في البوابة
            </div>
            <div class="section-subtitle" style="font-size: 17px; color: #64748b; line-height: 1.7;">
                تضم البوابة مجموعة من أهم الأوليمبيادات العلمية الدولية المعترف بها عالمياً، وتتيح للطلبة الفلسطينيين
                التسجيل والتأهيل والمشاركة تحت مظلة وطنية موحدة.
            </div>
        </div>

        <?php if (!empty($competitions)): ?>
            <div class="cards-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px; margin-top: 40px;">
                <?php foreach ($competitions as $comp): ?>
                    <?php
                    // Category colors
                    $categoryInfo = [
                        'physics' => ['name' => 'فيزياء', 'color' => '#3b82f6'],
                        'chemistry' => ['name' => 'كيمياء', 'color' => '#8b5cf6'],
                        'biology' => ['name' => 'أحياء', 'color' => '#10b981'],
                        'mathematics' => ['name' => 'رياضيات', 'color' => '#f59e0b'],
                        'informatics' => ['name' => 'معلوماتية', 'color' => '#6366f1'],
                        'astronomy' => ['name' => 'فلك', 'color' => '#ec4899'],
                        'earth_science' => ['name' => 'علوم الأرض', 'color' => '#14b8a6'],
                        'junior_science' => ['name' => 'علوم ناشئين', 'color' => '#f97316']
                    ];
                    $catInfo = $categoryInfo[$comp['category']] ?? ['name' => $comp['category'], 'color' => '#64748b'];
                    ?>
                    <article class="comp-card" style="background: white; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; transition: all 0.3s ease;"
                             onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.12)';" 
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        
                        <div class="comp-logo" style="margin: 30px auto 20px; width: 100px; height: 80px; display: flex; align-items: center; justify-content: center;">
                            <?php if (!empty($comp['logo_path'])): ?>
                                <img src="<?= $this->asset($comp['logo_path']) ?>" alt="<?= $this->e($comp['name_ar']) ?>" style="width:80px; height:80px; object-fit:contain; border-radius:14px; background: <?= $catInfo['color'] ?>10; padding:6px;">
                            <?php else: ?>
                                <div class="comp-logo-placeholder" style="width: 80px; height: 80px; background: <?= $catInfo['color'] ?>20; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: 900; color: <?= $catInfo['color'] ?>;">
                                    <?= $this->e($comp['code']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div style="padding: 0 28px 28px;">
                            <h3 class="comp-title" style="font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 8px; text-align: center; line-height: 1.4;">
                                <?= $this->e($comp['name_ar']) ?>
                            </h3>
                            
                            <div class="comp-acronym" style="text-align: center; color: #64748b; font-size: 13px; font-weight: 600; margin-bottom: 18px; letter-spacing: 0.5px;">
                                (<?= $this->e($comp['code']) ?>)
                            </div>
                            
                            <p class="comp-text" style="color: #64748b; font-size: 14px; line-height: 1.7; margin-bottom: 20px; min-height: 84px;">
                                <?= $this->e(mb_substr($comp['description_ar'] ?? 'مسابقة علمية دولية تهدف لاكتشاف المواهب العلمية وتطوير مهارات الطلبة في مختلف المجالات العلمية.', 0, 150)) ?>...
                            </p>
                            
                            <!-- Category Badge -->
                            <div style="margin-bottom: 20px; text-align: center;">
                                <span style="background: <?= $catInfo['color'] ?>15; color: <?= $catInfo['color'] ?>; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; display: inline-block;">
                                    <?= $catInfo['name'] ?>
                                </span>
                            </div>
                            
                            <div class="comp-footer" style="display: flex; align-items: center; justify-content: space-between; padding-top: 16px; border-top: 1px solid #f1f5f9; cursor: pointer;"
                                 onclick="window.location.href='<?= $this->url('/competitions/' . $comp['id']) ?>'">
                                <span style="color: #e11d48; font-weight: 600; font-size: 14px;">قراءة المزيد عن المسابقة</span>
                                <span class="icon" style="color: #e11d48; font-size: 20px; font-weight: 700;">›</span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 16px; border: 1px solid #e2e8f0;">
                <div style="font-size: 48px; margin-bottom: 16px;">📚</div>
                <h3 style="color: #0f172a; font-size: 20px; font-weight: 600; margin-bottom: 8px;">لا توجد مسابقات متاحة حالياً</h3>
                <p style="color: #64748b; font-size: 15px;">سيتم إضافة المسابقات قريباً</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Call to Action -->
<section style="background: #0f172a; padding: 60px 0;">
    <div class="container">
        <div style="max-width: 700px; margin: 0 auto; text-align: center;">
            <h2 style="color: white; font-size: 36px; font-weight: 800; margin-bottom: 16px;">
                هل أنت منسق مدرسة؟
            </h2>
            <p style="color: rgba(255,255,255,0.8); font-size: 18px; margin-bottom: 32px; line-height: 1.6;">
                سجل مدرستك وساعد طلابك على المشاركة في المسابقات العلمية الدولية
            </p>
            <a href="<?= $this->url('/register/school') ?>" 
               style="background: #e11d48; color: white; padding: 16px 40px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 17px; display: inline-block; transition: all 0.3s;"
               onmouseover="this.style.background='#be123c'; this.style.transform='translateY(-2px)';" 
               onmouseout="this.style.background='#e11d48'; this.style.transform='translateY(0)';">
                تسجيل المدرسة
            </a>
        </div>
    </div>
</section>