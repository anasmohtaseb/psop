<!-- Contact Page -->
<div class="contact-page">
    
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">تواصل معنا</h1>
            <p class="page-subtitle">نحن هنا لمساعدتك والإجابة على استفساراتك</p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="contact-content">
        <div class="container">
            <div class="contact-grid">
                
                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    <h2 class="section-heading">أرسل رسالة</h2>
                    
                    <form method="POST" action="<?= $this->url('/contact/send') ?>" class="contact-form">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        
                        <div class="form-row">
                            <div class="form-field">
                                <label for="name">الاسم الكامل *</label>
                                <input type="text" id="name" name="name" required>
                            </div>

                            <div class="form-field">
                                <label for="email">البريد الإلكتروني *</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-field">
                                <label for="phone">رقم الهاتف</label>
                                <input type="tel" id="phone" name="phone">
                            </div>

                            <div class="form-field">
                                <label for="subject">الموضوع *</label>
                                <select id="subject" name="subject" required>
                                    <option value="">اختر الموضوع</option>
                                    <option value="general">استفسار عام</option>
                                    <option value="registration">التسجيل</option>
                                    <option value="competitions">المسابقات</option>
                                    <option value="technical">دعم تقني</option>
                                    <option value="partnership">شراكة</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="message">الرسالة *</label>
                            <textarea id="message" name="message" rows="6" required></textarea>
                        </div>

                        <button type="submit" class="submit-btn">
                            <span>إرسال الرسالة</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="contact-info">
                    <h2 class="section-heading">معلومات التواصل</h2>
                    
                    <div class="info-cards">
                        <div class="info-card">
                            <div class="info-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </div>
                            <div class="info-content">
                                <h3>البريد الإلكتروني</h3>
                                <a href="mailto:<?= $this->e($settings['site_email'] ?? 'info@psop.ps') ?>">
                                    <?= $this->e($settings['site_email'] ?? 'info@psop.ps') ?>
                                </a>
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="info-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </div>
                            <div class="info-content">
                                <h3>الهاتف</h3>
                                <a href="tel:<?= $this->e($settings['site_phone'] ?? '+970XXXXXXXX') ?>">
                                    <?= $this->e($settings['site_phone'] ?? '+970-XXX-XXX-XXX') ?>
                                </a>
                                <p class="info-note">السبت - الخميس: 9 ص - 5 م</p>
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="info-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div class="info-content">
                                <h3>العنوان</h3>
                                <p><?= $this->e($settings['site_address'] ?? 'رام الله - المقر الرئيسي') ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="social-links">
                        <h3>تابعنا</h3>
                        <div class="social-icons">
                            <a href="#" aria-label="Facebook">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" aria-label="Twitter">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="#" aria-label="LinkedIn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

<style>
.contact-page {
    background: #f8fafc;
}

.page-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    padding: 60px 0;
    text-align: center;
}

.page-title {
    font-size: 36px;
    font-weight: 700;
    color: white;
    margin-bottom: 12px;
}

.page-subtitle {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.85);
}

.contact-content {
    padding: 60px 0;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 50px;
}

.contact-form-wrapper,
.contact-info {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.section-heading {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e2e8f0;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-field label {
    font-size: 14px;
    font-weight: 600;
    color: #334155;
}

.form-field input,
.form-field select,
.form-field textarea {
    padding: 12px 16px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 15px;
    font-family: 'Cairo', sans-serif;
    transition: border-color 0.2s;
}

.form-field input:focus,
.form-field select:focus,
.form-field textarea:focus {
    outline: none;
    border-color: #e11d48;
}

.form-field textarea {
    resize: vertical;
    min-height: 120px;
}

.submit-btn {
    padding: 14px 32px;
    background: linear-gradient(135deg, #e11d48, #f97316);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    justify-content: center;
    transition: transform 0.2s, box-shadow 0.2s;
    align-self: flex-start;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(225, 29, 72, 0.3);
}

.info-cards {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 30px;
}

.info-card {
    display: flex;
    gap: 16px;
    padding: 20px;
    background: #f8fafc;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
}

.info-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #e11d48, #f97316);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-icon svg {
    color: white;
}

.info-content h3 {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 6px;
}

.info-content a {
    color: #e11d48;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
}

.info-content a:hover {
    text-decoration: underline;
}

.info-content p {
    color: #64748b;
    font-size: 14px;
    margin: 0;
}

.info-note {
    margin-top: 4px;
    font-size: 13px !important;
}

.social-links {
    padding-top: 30px;
    border-top: 2px solid #e2e8f0;
}

.social-links h3 {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 16px;
}

.social-icons {
    display: flex;
    gap: 12px;
}

.social-icons a {
    width: 44px;
    height: 44px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    transition: all 0.2s;
}

.social-icons a:hover {
    background: linear-gradient(135deg, #e11d48, #f97316);
    color: white;
    border-color: transparent;
    transform: translateY(-3px);
}

@media (max-width: 992px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}

@media (max-width: 640px) {
    .page-header {
        padding: 40px 0;
    }
    
    .page-title {
        font-size: 28px;
    }
    
    .contact-form-wrapper,
    .contact-info {
        padding: 24px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .submit-btn {
        width: 100%;
    }
}
</style>
