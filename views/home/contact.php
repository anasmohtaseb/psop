<!-- Contact Hero -->
<section style="padding: 80px 0 60px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.03; background-image: repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.05) 35px, rgba(255,255,255,.05) 70px);"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <div style="text-align: center; max-width: 700px; margin: 0 auto;">
            <h1 style="color: white; font-size: 48px; font-weight: 900; margin-bottom: 20px; letter-spacing: -0.5px;">
                اتصل بنا
            </h1>
            <p style="color: rgba(255,255,255,0.85); font-size: 18px; line-height: 1.7;">
                نحن هنا لمساعدتك. لا تتردد في التواصل معنا للاستفسارات والدعم
            </p>
        </div>
    </div>
</section>

<!-- Contact Content -->
<section style="padding: 80px 0; background: #f8fafc;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start;">
            
            <!-- Contact Form -->
            <div style="background: white; padding: 40px; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;">
                <h2 style="font-size: 28px; font-weight: 700; color: #0f172a; margin-bottom: 10px;">
                    أرسل لنا رسالة
                </h2>
                <p style="color: #64748b; font-size: 15px; margin-bottom: 30px;">
                    املأ النموذج أدناه وسنرد عليك في أقرب وقت ممكن
                </p>

                <form method="POST" action="<?= $this->url('/contact/send') ?>" style="display: flex; flex-direction: column; gap: 20px;">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    
                    <div class="form-group">
                        <label class="form-label" for="name">الاسم الكامل *</label>
                        <input type="text" id="name" name="name" class="form-control" required 
                               placeholder="أدخل اسمك الكامل">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">البريد الإلكتروني *</label>
                        <input type="email" id="email" name="email" class="form-control" required 
                               placeholder="example@email.com">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">رقم الهاتف</label>
                        <input type="tel" id="phone" name="phone" class="form-control" 
                               placeholder="+970-XXX-XXX-XXX">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="subject">الموضوع *</label>
                        <select id="subject" name="subject" class="form-control" required>
                            <option value="">اختر الموضوع</option>
                            <option value="general">استفسار عام</option>
                            <option value="registration">التسجيل والاشتراكات</option>
                            <option value="competitions">المسابقات</option>
                            <option value="technical">دعم تقني</option>
                            <option value="partnership">شراكة أو تعاون</option>
                            <option value="other">أخرى</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">الرسالة *</label>
                        <textarea id="message" name="message" class="form-control" rows="6" required 
                                  placeholder="اكتب رسالتك هنا..."></textarea>
                    </div>

                    <button type="submit" class="btn-primary" style="padding: 14px 32px; font-size: 16px;">
                        إرسال الرسالة
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                
                <!-- Info Card 1 -->
                <div style="background: white; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #e11d48, #f97316); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                        <span style="font-size: 28px;">📧</span>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">
                        البريد الإلكتروني
                    </h3>
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 12px;">
                        راسلنا في أي وقت
                    </p>
                    <a href="mailto:info@psop.ps" style="color: #e11d48; font-weight: 600; font-size: 16px; text-decoration: none;">
                        info@psop.ps
                    </a>
                </div>

                <!-- Info Card 2 -->
                <div style="background: white; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #3b82f6, #6366f1); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                        <span style="font-size: 28px;">📱</span>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">
                        الهاتف
                    </h3>
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 12px;">
                        من السبت إلى الخميس، 9 صباحاً - 5 مساءً
                    </p>
                    <a href="tel:+970-XXX-XXX-XXX" style="color: #3b82f6; font-weight: 600; font-size: 16px; text-decoration: none;">
                        +970-XXX-XXX-XXX
                    </a>
                </div>

                <!-- Info Card 3 -->
                <div style="background: white; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #10b981, #14b8a6); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                        <span style="font-size: 28px;">📍</span>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">
                        الموقع
                    </h3>
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 0;">
                        فلسطين - رام الله<br>
                        المقر الرئيسي
                    </p>
                </div>

                <!-- Social Media -->
                <div style="background: linear-gradient(135deg, #0f172a, #1e293b); padding: 30px; border-radius: 16px;">
                    <h3 style="font-size: 18px; font-weight: 700; color: white; margin-bottom: 16px;">
                        تابعنا على وسائل التواصل
                    </h3>
                    <div style="display: flex; gap: 12px;">
                        <a href="#" style="width: 44px; height: 44px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; text-decoration: none; transition: all 0.3s;"
                           onmouseover="this.style.background='rgba(225,29,72,0.9)'" 
                           onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                            📘
                        </a>
                        <a href="#" style="width: 44px; height: 44px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; text-decoration: none; transition: all 0.3s;"
                           onmouseover="this.style.background='rgba(225,29,72,0.9)'" 
                           onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                            🐦
                        </a>
                        <a href="#" style="width: 44px; height: 44px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; text-decoration: none; transition: all 0.3s;"
                           onmouseover="this.style.background='rgba(225,29,72,0.9)'" 
                           onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                            📷
                        </a>
                        <a href="#" style="width: 44px; height: 44px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; text-decoration: none; transition: all 0.3s;"
                           onmouseover="this.style.background='rgba(225,29,72,0.9)'" 
                           onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                            💼
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div style="text-align: center; max-width: 700px; margin: 0 auto 50px;">
            <h2 style="font-size: 36px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">
                الأسئلة الشائعة
            </h2>
            <p style="color: #64748b; font-size: 16px; line-height: 1.7;">
                إجابات سريعة للأسئلة الأكثر شيوعاً
            </p>
        </div>

        <div style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 16px;">
            
            <details style="background: #f8fafc; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <summary style="font-size: 18px; font-weight: 600; color: #0f172a; cursor: pointer; list-style: none;">
                    ▸ كيف يمكنني التسجيل في المسابقات؟
                </summary>
                <p style="color: #64748b; font-size: 15px; line-height: 1.7; margin-top: 16px; margin-bottom: 0;">
                    يمكنك التسجيل كطالب من خلال إنشاء حساب جديد، ثم اختيار المسابقة المناسبة وملء نموذج التسجيل.
                </p>
            </details>

            <details style="background: #f8fafc; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <summary style="font-size: 18px; font-weight: 600; color: #0f172a; cursor: pointer; list-style: none;">
                    ▸ ما هي شروط الاشتراك؟
                </summary>
                <p style="color: #64748b; font-size: 15px; line-height: 1.7; margin-top: 16px; margin-bottom: 0;">
                    يجب أن تكون طالباً في مدرسة أو جامعة فلسطينية، وأن تستوفي الشروط العمرية لكل مسابقة.
                </p>
            </details>

            <details style="background: #f8fafc; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <summary style="font-size: 18px; font-weight: 600; color: #0f172a; cursor: pointer; list-style: none;">
                    ▸ هل هناك رسوم للمشاركة؟
                </summary>
                <p style="color: #64748b; font-size: 15px; line-height: 1.7; margin-top: 16px; margin-bottom: 0;">
                    نعم، هناك اشتراكات سنوية بأسعار مخفضة للطلبة والمدارس. يمكنك الاطلاع على الخطط من صفحة الاشتراكات.
                </p>
            </details>

            <details style="background: #f8fafc; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <summary style="font-size: 18px; font-weight: 600; color: #0f172a; cursor: pointer; list-style: none;">
                    ▸ هل تقدمون تدريبات؟
                </summary>
                <p style="color: #64748b; font-size: 15px; line-height: 1.7; margin-top: 16px; margin-bottom: 0;">
                    نعم، نوفر برامج تدريبية وورش عمل ومخيمات تحضيرية للطلبة المسجلين.
                </p>
            </details>

        </div>
    </div>
</section>

<style>
@media (max-width: 768px) {
    section > div > div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
        gap: 40px !important;
    }
}
</style>
