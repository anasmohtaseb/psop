<!-- About Page - Simple Version v2.0 [UPDATED] -->
<style>
    .about-simple {
        min-height: 60vh;
        display: flex;
        align-items: center;
        padding: 100px 0;
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    }
    
    .about-content {
        max-width: 900px;
        margin: 0 auto;
        text-align: center;
    }
    
    .about-logo {
        margin-bottom: 32px;
        animation: fadeInDown 0.8s ease-out;
    }
    
    .logo-image {
        max-width: 200px;
        height: auto;
        filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));
        transition: transform 0.3s ease;
    }
    
    .logo-image:hover {
        transform: scale(1.05);
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .about-title {
        font-size: clamp(36px, 5vw, 56px);
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 32px;
        line-height: 1.2;
    }
    
    .about-description {
        font-size: 20px;
        color: #475569;
        line-height: 2;
        margin-bottom: 48px;
    }
    
    .about-cta {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 40px;
    }
    
    .btn-cta {
        padding: 16px 40px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 16px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #e11d48, #be123c);
        color: white;
        box-shadow: 0 8px 24px rgba(225, 29, 72, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(225, 29, 72, 0.4);
    }
    
    .btn-secondary {
        background: transparent;
        color: #e11d48;
        border: 2px solid #e11d48;
    }
    
    .btn-secondary:hover {
        background: #e11d48;
        color: white;
        transform: translateY(-3px);
    }
    
    @media (max-width: 768px) {
        .about-simple {
            padding: 60px 0;
        }
        
        .about-cta {
            flex-direction: column;
            align-items: stretch;
        }
        
        .btn-cta {
            justify-content: center;
        }
    }
</style>

<section class="about-simple">
    <div class="container">
        <div class="about-content">
            <div class="about-logo">
                <img src="<?= $this->url($settings['site_logo'] ?? '/assets/img/logo.png') ?>" alt="<?= $this->e($settings['site_name'] ?? 'الأولمبياد العلمي الفلسطيني') ?>" class="logo-image">
            </div>
            <h1 class="about-title"><?= $this->e($settings['site_name'] ?? 'بوابة الأولمبياد العلمي الفلسطيني') ?></h1>
            <p class="about-description">
                منصة متكاملة واحترافية لإدارة المشاركة في الأولمبيادات العلمية الدولية. نهدف إلى اكتشاف ورعاية المواهب العلمية المتميزة، وتوفير بيئة تمكّن الطلاب الموهوبين من التحضير والمشاركة في أرقى المسابقات العلمية العالمية. نؤمن بأن كل طالب موهوب يستحق فرصة لإظهار قدراته والتنافس على أعلى المستويات، وتحقيق التميز والمنافسة على المستوى العالمي.
            </p>
            
            <div class="about-cta">
                <a href="<?= $this->url('/register/student') ?>" class="btn-cta btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                    التسجيل الآن
                </a>
                <a href="<?= $this->url('/competitions') ?>" class="btn-cta btn-secondary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    تصفح المسابقات
                </a>
            </div>
        </div>
    </div>
</section>