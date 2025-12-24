<!-- Hero -->
<section id="hero" class="hero">
    <div class="container hero-grid">
        <div>
            <h1 class="hero-title">
                اكتشاف ورعاية
                <span>العقول المبدعة</span>
                عبر الأوليمبيادات العلمية العالمية
            </h1>
            <p class="hero-subtitle">
                الأولمبيادات العلمية هي أكبر تجمع للمواهب الشابة في فلسطين، تهدف إلى اكتشاف العقول اللامعة وتنمية مهاراتها في مجالات متعددة مثل البرمجة، الرياضيات، الفيزياء، والكيمياء. تقدم هذه المسابقات فرصة استثنائية للمشاركين للتعلم، الإبداع، والتألق على المستويين المحلي والدولي.
            </p>
            <div class="hero-actions">
                <a href="<?= $this->url('/register/student') ?>" class="btn-primary">تسجيل طالب / طالبة</a>
                <a href="<?= $this->url('/register/school') ?>" class="btn-outline">تسجيل مدرسة أو مؤسسة تعليمية</a>
                <a href="<?= $this->url('/about') ?>" class="btn-outline">دليل المشاركة والمدربين</a>
            </div>
            <div class="hero-footnote">
                البوابة موجهة لطلبة المدارس والجامعات، مع إتاحة
                برامج تدريبية وتأهيلية بإشراف لجنة علمية متخصصة.
                <strong>إطلاق الدورة الأولى التجريبية قريباً.</strong>
            </div>
        </div>

        <aside class="hero-slider-container" aria-label="معرض الصور">
            <div class="hero-slider">
                <div class="slider-wrapper">
                    <?php if (!empty($hero_slides)): ?>
                        <?php foreach ($hero_slides as $index => $slide): ?>
                            <div class="slide <?= $index === 0 ? 'active' : '' ?>">
                                <img src="<?= $this->asset($slide['image_path']) ?>" 
                                     alt="<?= $this->e($slide['title_ar']) ?>" 
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'600\' height=\'400\'%3E%3Crect fill=\'%23e11d48\' width=\'600\' height=\'400\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' font-size=\'24\' fill=\'white\' text-anchor=\'middle\' dominant-baseline=\'middle\' font-family=\'Cairo\'%3E<?= $this->e($slide['title_ar']) ?>%3C/text%3E%3C/svg%3E'">
                                <div class="slide-caption">
                                    <h3><?= $this->e($slide['title_ar']) ?></h3>
                                    <?php if (!empty($slide['description_ar'])): ?>
                                        <p><?= $this->e($slide['description_ar']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Default slides if no slides in database -->
                        <div class="slide active">
                            <img src="<?= $this->asset('uploads/competitions/slide1.jpg') ?>" alt="طلاب في مسابقة عالمية" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'600\' height=\'400\'%3E%3Crect fill=\'%23e11d48\' width=\'600\' height=\'400\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' font-size=\'24\' fill=\'white\' text-anchor=\'middle\' dominant-baseline=\'middle\' font-family=\'Cairo\'%3Eطلاب في الأوليمبياد%3C/text%3E%3C/svg%3E'">
                            <div class="slide-caption">
                                <h3>طلاب يتألقون في الأوليمبياد الدولي</h3>
                                <p>تمثيل مشرف في المسابقات العالمية</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Navigation Arrows -->
                <button class="slider-nav prev" onclick="changeSlide(-1)" aria-label="الصورة السابقة">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button class="slider-nav next" onclick="changeSlide(1)" aria-label="الصورة التالية">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
                
                <!-- Dots Navigation -->
                <div class="slider-dots">
                    <?php 
                    $slideCount = !empty($hero_slides) ? count($hero_slides) : 1;
                    for ($i = 0; $i < $slideCount; $i++): 
                    ?>
                        <span class="dot <?= $i === 0 ? 'active' : '' ?>" onclick="goToSlide(<?= $i ?>)"></span>
                    <?php endfor; ?>
                </div>
            </div>
        </aside>
    </div>
</section>

<!-- Competitions -->
<section id="competitions" class="section">
    <div class="container">
        <div class="section-header-pro">
            <h2 class="section-title-pro">استكشف أبرز الأولمبيادات العلمية العالمية</h2>
            <p class="section-description-pro">
                تضم البوابة مجموعة من أهم الأوليمبيادات العلمية المعترف بها عالمياً في مجالات الرياضيات والمعلوماتية والذكاء الاصطناعي والبرمجة
            </p>
        </div>

        <div class="cards-grid">
            <?php if (!empty($active_competitions)): ?>
                <?php foreach ($active_competitions as $competition): ?>
                    <article class="comp-card">
                        <div class="comp-logo">
                            <?php if (!empty($competition['logo_path'])): ?>
                                <img src="<?= $this->asset($competition['logo_path']) ?>" 
                                     alt="<?= $this->e($competition['name_ar']) ?>"
                                     style="width: 100%; height: 100%; object-fit: contain;">
                            <?php else: ?>
                                <div class="comp-logo-placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <h3 class="comp-title"><?= $this->e($competition['name_ar']) ?></h3>
                        <div class="comp-acronym">(<?= $this->e($competition['code']) ?>)</div>
                        <p class="comp-text">
                            <?= $this->e($competition['description_ar'] ?? $competition['description_en'] ?? 'International competition') ?>
                        </p>
                        <div class="comp-footer">
                            <span>Read more about this competition</span>
                            <span class="icon">›</span>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default message if no competitions -->
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                    <p style="color: #666; font-size: 16px;">No competitions available at the moment</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Why -->
<section id="about" class="section why-section">
    <div class="container">
        <div class="section-header-pro">
            <h2 class="section-title-pro">بوابتك نحو التميز العلمي العالمي</h2>
            <p class="section-description-pro">
                إطار شامل لإدارة المشاركة في الأولمبيادات العلمية الدولية مع توفير قنوات تدريب مستدامة ودعم أكاديمي متميز
            </p>
        </div>

        <div class="features-grid">
            <article class="feature-card">
                <div class="feature-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="M3 9h18M9 3v18"/>
                    </svg>
                </div>
                <h3 class="feature-title">منصة موحدة للتسجيل والمتابعة</h3>
                <p class="feature-description">
                    واجهة واحدة للتسجيل في جميع المسابقات، متابعة المواعيد، الاطلاع على مواد
                    التدريب، وإدارة ملفات الطلبة والمدربين والمدارس بكل سهولة.
                </p>
                <ul class="feature-list">
                    <li>✓ تسجيل سريع لعدة مسابقات</li>
                    <li>✓ متابعة التقدم بشكل مباشر</li>
                    <li>✓ إدارة مركزية للوثائق</li>
                </ul>
            </article>

            <article class="feature-card featured">
                <div class="feature-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
                <h3 class="feature-title">برامج تدريب وتأهيل متقدمة</h3>
                <p class="feature-description">
                    مخيمات تدريبية، ورش عمل، ودورات أونلاين بإشراف خبراء متخصصين وشركاء دوليين،
                    مع مسارات متدرجة من المبتدئ حتى مستوى الفريق المتقدم.
                </p>
                <ul class="feature-list">
                    <li>✓ جلسات تدريبية من الخبراء</li>
                    <li>✓ مسارات تعليمية منظمة</li>
                    <li>✓ تعاون دولي مميز</li>
                </ul>
            </article>

            <article class="feature-card">
                <div class="feature-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                </div>
                <h3 class="feature-title">تمثيل دولي منظم</h3>
                <p class="feature-description">
                    اختيار شفاف للفرق يضمن استمرارية المشاركة في الأولمبيادات
                    العلمية وفق معايير دولية واضحة ومهنية.
                </p>
                <ul class="feature-list">
                    <li>✓ عملية اختيار عادلة وشفافة</li>
                    <li>✓ مشاركة دولية مستمرة</li>
                    <li>✓ تتبع الأداء والتحليلات</li>
                </ul>
            </article>
        </div>

        <!-- Stats Section -->
        <div class="stats-showcase">
            <div class="stat-item">
                <div class="stat-number">+500</div>
                <div class="stat-label">طالب وطالبة</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">6</div>
                <div class="stat-label">مسابقات دولية</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">+80</div>
                <div class="stat-label">مدرسة شريكة</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">دعم فني مستمر</div>
            </div>
        </div>
    </div>
</section>

<!-- How to join -->
<section id="join" class="section">
    <div class="container">
        <div class="section-header-pro">
            <h2 class="section-title-pro">ابدأ رحلتك العلمية في 4 خطوات بسيطة</h2>
            <p class="section-description-pro">
                عملية تسجيل سهلة ومنظمة تضمن انضمامك إلى منظومة الأولمبيادات العلمية مع متابعة دقيقة ودعم مستمر
            </p>
        </div>

        <div class="steps">
            <article class="step">
                <div class="step-number">١</div>
                <div class="step-title">إنشاء حساب للطالب أو المدرسة</div>
                <div class="step-text">
                    تعبئة نموذج التسجيل الإلكتروني، وتحديد نوع الحساب (طالب، مدرسة، مدرّب)،
                    وتأكيد بيانات الاتصال الرسمية.
                </div>
            </article>
            <article class="step">
                <div class="step-number">٢</div>
                <div class="step-title">اختيار المسابقات المناسبة</div>
                <div class="step-text">
                    الاطلاع على المسابقات المتاحة، الفئات العمرية المستهدفة، شروط المشاركة، ومستوى
                    الصعوبة، ثم إرسال طلب الانضمام للمسابقات المختارة.
                </div>
            </article>
            <article class="step">
                <div class="step-number">٣</div>
                <div class="step-title">الالتحاق ببرامج التدريب</div>
                <div class="step-text">
                    متابعة الجلسات التدريبية، حل التمارين، المشاركة في المسابقات التحضيرية
                    المحلية، وتقييم الأداء بشكل دوري عبر المنصة.
                </div>
            </article>
            <article class="step">
                <div class="step-number">٤</div>
                <div class="step-title">المنافسة على المقاعد</div>
                <div class="step-text">
                    اجتياز الاختبارات التأهيلية واختيار أفضل الطلبة للتمثيل في الفرق
                    لكل أوليمبياد، والمشاركة في النهائيات الدولية.
                </div>
            </article>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section id="cta" class="section" style="padding-top: 80px;">
    <div class="container">
        <div class="cta-buttons">
            <a href="<?= $this->url('/register/student') ?>" class="btn btn-primary btn-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                تسجيل طالب/طالبة
            </a>
            <a href="<?= $this->url('/register/school') ?>" class="btn btn-outline btn-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                تسجيل مدرسة
            </a>
        </div>
    </div>
</section>
