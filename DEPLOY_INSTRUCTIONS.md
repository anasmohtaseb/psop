# تعليمات النشر على السيرفر
## Deployment Instructions

تم رفع التعديلات إلى GitHub بنجاح ✅

### الطريقة الأولى: استخدام SSH (الأسرع)

1. **اتصل بالسيرفر عبر SSH:**
```bash
ssh u186996263@psop.ps
```

2. **انتقل إلى مجلد المشروع:**
```bash
cd /home/u186996263/domains/psop.ps/public_html
```

3. **اسحب آخر التحديثات:**
```bash
git pull origin main
```

4. **تأكد من الصلاحيات:**
```bash
chmod 644 views/admin/schools/edit.php
```

5. **تحقق من النتيجة:**
افتح المتصفح: `https://psop.ps/check_views.php`

---

### الطريقة الثانية: استخدام سكريبت Deployment

1. **ارفع ملف `deploy.sh` إلى السيرفر عبر FTP/cPanel**

2. **نفذ السكريبت:**
```bash
bash deploy.sh
```

---

### الطريقة الثالثة: cPanel File Manager

1. **افتح cPanel File Manager**

2. **احذف الملف القديم (إن وُجد):**
   - `/home/u186996263/domains/psop.ps/public_html/views/admin/schools/edit.php`

3. **ارفع الملف الجديد من:**
   - المسار المحلي: `c:\xampp\htdocs\psop\views\admin\schools\edit.php`
   - إلى: `/public_html/views/admin/schools/`

4. **تأكد من الصلاحيات:**
   - انقر بزر الماوس الأيمن على الملف → Change Permissions
   - اختر: `644` أو `-rw-r--r--`

---

### التحقق من النجاح

بعد أي من الطرق أعلاه، افتح:
- ✅ `https://psop.ps/check_views.php` للتأكد من وجود الملف
- ✅ `https://psop.ps/admin/schools` ثم حاول التعديل على أي مدرسة

---

### إذا استمرت المشكلة

تحقق من:
1. **المسار الصحيح على السيرفر:**
   ```
   /home/u186996263/domains/psop.ps/public_html/views/admin/schools/edit.php
   ```

2. **حالة الأحرف (Case-sensitive):**
   - يجب: `views/admin/schools/edit.php`
   - ليس: `Views/Admin/Schools/edit.php`

3. **الملكية والصلاحيات:**
   ```bash
   ls -la /home/u186996263/domains/psop.ps/public_html/views/admin/schools/
   ```
   يجب أن تظهر: `-rw-r--r-- edit.php`
