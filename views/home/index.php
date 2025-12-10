<!-- Hero -->
<section id="hero" class="hero">
    <div class="container hero-grid">
        <div>
            <div class="hero-badge-row">
                <div class="hero-badge">
                    بوابة وطنية تجمع <strong>الأوليمبيادات العلمية الدولية</strong> في فلسطين
                </div>
            </div>
            <h1 class="hero-title">
                اكتشاف ورعاية
                <span>العقول الفلسطينية المبدعة</span>
                عبر الأوليمبيادات العلمية العالمية
            </h1>
            <p class="hero-subtitle">
                تهدف بوابة الأوليمبياد العلمية في فلسطين إلى توحيد التسجيل، التدريب، وإدارة المشاركة الفلسطينية
                في أهم المسابقات الدولية في مجالات الرياضيات، المعلوماتية، الذكاء الاصطناعي، البرمجة، الأمن السيبراني
                والفلسفة، بالشراكة مع المدارس والجامعات ومؤسسات التعليم.
            </p>
            <div class="hero-actions">
                <a href="<?= $this->url('/register/student') ?>" class="btn-primary">تسجيل طالب / طالبة</a>
                <a href="<?= $this->url('/register/school') ?>" class="btn-outline">تسجيل مدرسة أو مؤسسة تعليمية</a>
                <a href="<?= $this->url('/about') ?>" class="btn-outline">دليل المشاركة والمدربين</a>
            </div>
            <div class="hero-footnote">
                البوابة موجهة لطلبة المدارس والجامعات في فلسطين، مع إتاحة
                برامج تدريبية وتأهيلية بإشراف لجنة علمية وطنية.
                <strong>إطلاق الدورة الأولى التجريبية قريباً.</strong>
            </div>
        </div>

        <aside class="hero-card" aria-label="موجز إحصائي">
            <div class="hero-card-header">
                <div>
                    <div class="hero-card-title">مؤشرات المشاركة الفلسطينية المتوقعة</div>
                    <div class="hero-card-sub">بحسب الخطة الوطنية للأوليمبيادات العلمية</div>
                </div>
                <div class="hero-chip">مرحلة الإطلاق التجريبي</div>
            </div>
            <div class="hero-stats">
                <div class="stat-box">
                    <div class="stat-label">عدد الطلبة المستهدفين</div>
                    <div class="stat-value">+500</div>
                    <div class="stat-tag">من مختلف المحافظات</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">مسابقات دولية</div>
                    <div class="stat-value">6</div>
                    <div class="stat-tag">ريادة فلسطينية في التمثيل</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">مدارس وجامعات</div>
                    <div class="stat-value">+80</div>
                    <div class="stat-tag">شركاء في التدريب والاحتضان</div>
                </div>
            </div>
            <div class="timeline">
                <span>فترة التسجيل الأولى: <strong>تعلن قريباً</strong></span>
                <span>التدريبات: ورش عمل، مخيمات، ولقاءات أونلاين</span>
            </div>
        </aside>
    </div>
</section>

<!-- Competitions -->
<section id="competitions" class="section">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="section-title">المسابقات الدولية المعتمدة في البوابة</div>
                <div class="section-subtitle">
                    تضم البوابة مجموعة من أهم الأوليمبيادات العلمية الدولية المعترف بها عالمياً، وتتيح للطلبة الفلسطينيين
                    التسجيل والتأهيل والمشاركة تحت مظلة وطنية موحدة.
                </div>
            </div>
            <div class="section-subtitle">
                يمكن لكل طالب ومدرسة الاطلاع على تفاصيل كل مسابقة، شروط المشاركة، مواد التدريب، وآلية اختيار الفرق الوطنية.
            </div>
        </div>

        <div class="cards-grid">
            <!-- IMO -->
            <article class="comp-card">
                <div class="comp-logo">
                    <div class="comp-logo-placeholder"></div>
                </div>
                <h3 class="comp-title">الأوليمبياد الدولي للرياضيات</h3>
                <div class="comp-acronym">(IMO)</div>
                <p class="comp-text">
                    أعرق مسابقة عالمية في الرياضيات لطلبة المدارس الثانوية. تهدف إلى تنمية مهارات
                    التفكير المنطقي وحل المسائل العليا، واكتشاف المواهب الرياضية المتميزة مبكراً.
                </p>
                <div class="comp-footer">
                    <span>قراءة المزيد عن المسابقة</span>
                    <span class="icon">›</span>
                </div>
            </article>

            <!-- IOAI -->
            <article class="comp-card">
                <div class="comp-logo">
                    <div class="comp-logo-placeholder"></div>
                </div>
                <h3 class="comp-title">الأوليمبياد الدولي للذكاء الاصطناعي</h3>
                <div class="comp-acronym">(IOAI)</div>
                <p class="comp-text">
                    منصة عالمية ناشئة لطلبة المدارس في مجالات الذكاء الاصطناعي، تعلم الآلة، وتحليل البيانات،
                    مع تركيز على حل المشكلات الواقعية باستخدام أدوات وخوارزميات حديثة.
                </p>
                <div class="comp-footer">
                    <span>قراءة المزيد عن المسابقة</span>
                    <span class="icon">›</span>
                </div>
            </article>

            <!-- IOI -->
            <article class="comp-card">
                <div class="comp-logo">
                    <div class="comp-logo-placeholder"></div>
                </div>
                <h3 class="comp-title">الأوليمبياد الدولي في المعلوماتية</h3>
                <div class="comp-acronym">(IOI)</div>
                <p class="comp-text">
                    مسابقة عالمية رائدة في البرمجة التنافسية والخوارزميات. تركز على تصميم حلول
                    برمجية فعّالة للمشكلات المعقدة باستخدام لغات البرمجة الحديثة.
                </p>
                <div class="comp-footer">
                    <span>قراءة المزيد عن المسابقة</span>
                    <span class="icon">›</span>
                </div>
            </article>

            <!-- ACPC Schools -->
            <article class="comp-card">
                <div class="comp-logo">
                    <div class="comp-logo-placeholder"></div>
                </div>
                <h3 class="comp-title">مسابقة البرمجة العربية لطلبة المدارس</h3>
                <div class="comp-acronym">(ACPC Schools)</div>
                <p class="comp-text">
                    مسابقة إقليمية تجمع الطلبة من الدول العربية في أجواء تنافسية في البرمجة،
                    وتشكل بوابة مبكرة نحو عالم المسابقات الإقليمية والعالمية مثل ICPC وIOI.
                </p>
                <div class="comp-footer">
                    <span>قراءة المزيد عن المسابقة</span>
                    <span class="icon">›</span>
                </div>
            </article>

            <!-- Cybersecurity Olympiad -->
            <article class="comp-card">
                <div class="comp-logo">
                    <div class="comp-logo-placeholder"></div>
                </div>
                <h3 class="comp-title">الأوليمبياد الدولي للأمن السيبراني</h3>
                <div class="comp-acronym">Cyber Security Olympiad</div>
                <p class="comp-text">
                    مسابقة متخصصة تركز على أمن المعلومات، اختبار الاختراق الأخلاقي، وتحليل الثغرات،
                    وتعمل على إعداد جيل واعٍ بمخاطر الفضاء الرقمي وطرق الحماية المتقدمة.
                </p>
                <div class="comp-footer">
                    <span>قراءة المزيد عن المسابقة</span>
                    <span class="icon">›</span>
                </div>
            </article>

            <!-- IPO -->
            <article class="comp-card">
                <div class="comp-logo">
                    <div class="comp-logo-placeholder"></div>
                </div>
                <h3 class="comp-title">الأوليمبياد الدولي للفلسفة</h3>
                <div class="comp-acronym">(IPO)</div>
                <p class="comp-text">
                    مسابقة عالمية تشجع الطلبة على التفكير النقدي والكتابة الفلسفية،
                    من خلال معالجة أسئلة كبرى تتعلق بالمعرفة، القيم، والإنسان والمجتمع.
                </p>
                <div class="comp-footer">
                    <span>قراءة المزيد عن المسابقة</span>
                    <span class="icon">›</span>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- Why -->
<section id="about" class="section">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="section-title">لماذا بوابة الأوليمبياد العلمية في فلسطين؟</div>
                <div class="section-subtitle">
                    تأتي هذه البوابة استجابة للحاجة إلى إطار وطني منظم لإدارة مشاركة الطلبة الفلسطينيين في الأوليمبيادات
                    العلمية الدولية، وتوفير قنوات تدريب ومرافقة أكاديمية مستدامة.
                </div>
            </div>
        </div>

        <div class="why-grid">
            <article class="why-card">
                <div class="why-title">منصة موحدة للتسجيل والمتابعة</div>
                <div class="why-text">
                    واجهة واحدة للتسجيل في جميع المسابقات، متابعة المواعيد، الاطلاع على مواد
                    التدريب، وإدارة ملفات الطلبة والمدربين والمدارس.
                </div>
            </article>
            <article class="why-card">
                <div class="why-title">برامج تدريب وتأهيل وطنية</div>
                <div class="why-text">
                    تصميم مخيمات تدريبية، ورش عمل، ودورات أونلاين بإشراف خبراء فلسطينيين وشركاء دوليين،
                    مع مسارات متدرجة من المبتدئ حتى مستوى الفريق الوطني.
                </div>
            </article>
            <article class="why-card">
                <div class="why-title">تمثيل فلسطيني منظم في المحافل الدولية</div>
                <div class="why-text">
                    اختيار الفرق الوطنية بطريقة شفافة ومنظمة، وضمان استمرارية المشاركة الفلسطينية
                    في الأوليمبيادات العلمية وفق معايير دولية واضحة.
                </div>
            </article>
        </div>
    </div>
</section>

<!-- How to join -->
<section id="join" class="section">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="section-title">كيف يمكن للطلبة والمدارس المشاركة؟</div>
                <div class="section-subtitle">
                    خطوات بسيطة تضمن انضمامكم إلى منظومة الأوليمبيادات العلمية، مع إمكانية
                    متابعة حالة الطلب والحصول على الدعم والإرشاد.
                </div>
            </div>
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
                <div class="step-title">المنافسة على المقاعد الوطنية</div>
                <div class="step-text">
                    اجتياز الاختبارات التأهيلية واختيار أفضل الطلبة لتمثيل فلسطين في الفرق الوطنية
                    لكل أوليمبياد، والمشاركة في النهائيات الدولية.
                </div>
            </article>
        </div>
    </div>
</section>

<!-- Contact -->
<section id="contact" class="section">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="section-title">تواصل مع فريق البوابة</div>
                <div class="section-subtitle">
                    في حال رغبتكم في الشراكة، أو اعتماد مدارسكم كمراكز تدريب، أو الاستفسار عن
                    آليات المشاركة، يمكنكم التواصل معنا عبر البريد الإلكتروني أو النموذج المخصص.
                </div>
            </div>
        </div>
        <div class="section-subtitle">
            البريد الإلكتروني الرسمي: info@psop.ps  
            <br>
            سيتم قريباً إتاحة نموذج تواصل مباشر داخل البوابة لتسجيل الاستفسارات واقتراحات الشركاء.
        </div>
    </div>
</section>
