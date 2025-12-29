# نظام Activity Log

نظام شامل لتتبع وتسجيل جميع النشاطات والإجراءات في المنصة.

## التثبيت

### 1. إنشاء الجدول في قاعدة البيانات

```powershell
Get-Content database\activity_log.sql | mysql -u root -p psop_db
```

### 2. الوصول إلى صفحة السجل

للمدراء فقط:
```
http://localhost:82/psop/admin/activity-logs
```

## طريقة الاستخدام

### تسجيل نشاط بسيط

```php
// في أي مكان في الكود
logActivity('login', 'تسجيل دخول المستخدم أحمد');
```

### تسجيل نشاط مع كيان

```php
// عند إنشاء مسابقة جديدة
logCreate('competition', $competitionId, 'إنشاء مسابقة: ' . $competitionName);

// عند تعديل مستخدم
logUpdate('user', $userId, 'تعديل بيانات المستخدم: ' . $userName);

// عند حذف تسجيل
logDelete('registration', $registrationId, 'حذف تسجيل في المسابقة');
```

### تسجيل مع بيانات إضافية (metadata)

```php
logActivity(
    'update_subscription',
    'تفعيل اشتراك الطالب محمد',
    'subscription',
    $subscriptionId,
    [
        'old_status' => 'pending',
        'new_status' => 'active',
        'plan_name' => 'خطة الطالب الشهرية'
    ]
);
```

### دوال مختصرة جاهزة

```php
// تسجيل دخول
logLogin($userId, $userName);

// تسجيل خروج
logLogout($userId, $userName);

// إنشاء
logCreate('competition', $id, 'إنشاء مسابقة IMO 2025');

// تعديل
logUpdate('user', $id, 'تحديث بيانات الطالب أحمد');

// حذف
logDelete('registration', $id, 'حذف تسجيل الطالب في المسابقة');
```

## أمثلة تطبيقية

### في AuthController (تسجيل الدخول)

```php
public function login(): void
{
    // ... validation code ...
    
    if ($this->auth->attempt($email, $password)) {
        $user = $this->auth->user();
        logLogin($user['id'], $user['name']);
        
        $this->redirect('/dashboard');
    }
}
```

### في CompetitionController (إنشاء مسابقة)

```php
public function store(): void
{
    // ... validation and creation code ...
    
    $competitionId = $this->competitionModel->create($data);
    
    if ($competitionId) {
        logCreate(
            'competition',
            $competitionId,
            'إنشاء مسابقة جديدة: ' . $data['name_ar']
        );
        
        $this->setFlash('success', 'تم إنشاء المسابقة بنجاح');
    }
}
```

### في SubscriptionController (تفعيل اشتراك)

```php
public function adminActivate(): void
{
    // ... validation code ...
    
    $success = $this->subscriptionModel->activateSubscription($id, $data);
    
    if ($success) {
        logUpdate(
            'subscription',
            $id,
            'تفعيل اشتراك المستخدم #' . $subscription['user_id'],
            [
                'plan_id' => $subscription['plan_id'],
                'method' => 'admin_activation'
            ]
        );
        
        $this->setFlash('success', 'تم تفعيل الاشتراك');
    }
}
```

## الميزات

### 1. صفحة عرض السجلات
- إحصائيات شاملة (إجمالي النشاطات، اليوم، الأسبوع، المستخدمون النشطون)
- فلترة حسب: الإجراء، نوع الكيان، التاريخ، البحث
- عرض تفاصيل كل نشاط (المستخدم، الإجراء، الوصف، IP، التاريخ)

### 2. التصدير إلى CSV
- تصدير السجلات المفلترة
- تنسيق UTF-8 لدعم العربية
- رابط مباشر للتصدير

### 3. عرض نشاطات مستخدم معين
```
/admin/activity-logs/user/{userId}
```

### 4. عرض نشاطات كيان معين
```
/admin/activity-logs/entity/competition/5
```

## الحقول المخزنة

| الحقل | الوصف |
|------|-------|
| `user_id` | معرف المستخدم (null للضيوف) |
| `user_type` | نوع المستخدم (student/admin/...) |
| `action` | اسم الإجراء (login/create/update/...) |
| `entity_type` | نوع الكيان المتأثر |
| `entity_id` | معرف الكيان |
| `description` | وصف بالعربية |
| `ip_address` | عنوان IP |
| `user_agent` | معلومات المتصفح |
| `metadata` | JSON لبيانات إضافية |
| `created_at` | تاريخ الإجراء |

## إجراءات شائعة مقترحة

- `login` - تسجيل دخول
- `logout` - تسجيل خروج
- `register` - تسجيل مستخدم جديد
- `create_user` - إنشاء مستخدم
- `update_user` - تعديل مستخدم
- `delete_user` - حذف مستخدم
- `create_competition` - إنشاء مسابقة
- `update_competition` - تعديل مسابقة
- `create_registration` - تسجيل في مسابقة
- `update_registration` - تعديل تسجيل
- `activate_subscription` - تفعيل اشتراك
- `cancel_subscription` - إلغاء اشتراك

## الصيانة

### حذف السجلات القديمة (أكثر من سنة)

```php
$activityLog = new ActivityLog($config);
$deletedCount = $activityLog->cleanOldLogs(365);
```

يمكن جدولة هذا الأمر ليعمل شهرياً للحفاظ على حجم الجدول.

## ملاحظات أمنية

- يتم تسجيل عنوان IP تلقائياً
- يمكن تتبع كل إجراء للمستخدم
- البيانات الحساسة (كلمات المرور) لا يجب تخزينها في metadata
- المدراء فقط يمكنهم الوصول للسجلات
