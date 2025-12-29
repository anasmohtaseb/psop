# PSOP RESTful API Documentation

## نظرة عامة

API متكامل لإدارة بوابة الأولمبياد العلمي الفلسطيني باستخدام معايير REST و OpenAPI 3.0.

## الوصول للتوثيق التفاعلي

### Swagger UI
```
http://localhost:82/psop/api/docs
```

### Swagger JSON
```
http://localhost:82/psop/swagger.json
```

## Base URLs

- **Local**: `http://localhost:82/psop/api/v1`
- **Production**: `https://psop.ps/api/v1`

## المصادقة (Authentication)

يستخدم API نظام Bearer Token للمصادقة:

```http
Authorization: Bearer YOUR_TOKEN_HERE
```

### تسجيل الدخول للحصول على Token

```bash
curl -X POST http://localhost:82/psop/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@psop.ps",
    "password": "admin123"
  }'
```

**الاستجابة:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "token": "base64_encoded_token",
    "user": {
      "id": 1,
      "name": "Admin",
      "email": "admin@psop.ps",
      "type": "admin"
    }
  }
}
```

## Endpoints المتاحة

### 🏆 المسابقات (Competitions)

#### 1. الحصول على جميع المسابقات
```http
GET /api/v1/competitions
```

**Query Parameters:**
- `category` (optional): mathematics, informatics, physics, etc.
- `is_active` (optional): true/false

**مثال:**
```bash
curl http://localhost:82/psop/api/v1/competitions?category=mathematics
```

**الاستجابة:**
```json
{
  "success": true,
  "message": "Competitions retrieved successfully",
  "data": [
    {
      "id": 1,
      "name_ar": "الأولمبياد الدولي للرياضيات",
      "name_en": "International Mathematical Olympiad",
      "code": "IMO",
      "category": "mathematics",
      "is_active": true
    }
  ]
}
```

#### 2. الحصول على مسابقة واحدة
```http
GET /api/v1/competitions/{id}
```

```bash
curl http://localhost:82/psop/api/v1/competitions/1
```

#### 3. إنشاء مسابقة جديدة (Admin فقط)
```http
POST /api/v1/competitions
Authorization: Bearer {token}
```

```bash
curl -X POST http://localhost:82/psop/api/v1/competitions \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name_ar": "الأولمبياد الدولي للبرمجة",
    "name_en": "International Olympiad in Informatics",
    "code": "IOI",
    "category": "informatics",
    "description_ar": "مسابقة برمجية دولية",
    "is_active": true
  }'
```

#### 4. تحديث مسابقة (Admin فقط)
```http
PUT /api/v1/competitions/{id}
Authorization: Bearer {token}
```

```bash
curl -X PUT http://localhost:82/psop/api/v1/competitions/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name_ar": "اسم محدث",
    "is_active": false
  }'
```

#### 5. حذف مسابقة (Admin فقط)
```http
DELETE /api/v1/competitions/{id}/delete
Authorization: Bearer {token}
```

### 👥 المستخدمون (Users)

#### 1. الحصول على جميع المستخدمين (Admin فقط)
```http
GET /api/v1/users
Authorization: Bearer {token}
```

**Query Parameters:**
- `type` (optional): student, admin, school_coordinator, trainer
- `status` (optional): active, inactive, pending

#### 2. الحصول على مستخدم واحد
```http
GET /api/v1/users/{id}
Authorization: Bearer {token}
```

#### 3. تسجيل مستخدم جديد
```http
POST /api/v1/auth/register
```

```bash
curl -X POST http://localhost:82/psop/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "أحمد محمد",
    "email": "ahmad@example.com",
    "password": "password123",
    "phone": "0599123456"
  }'
```

#### 4. تسجيل الدخول
```http
POST /api/v1/auth/login
```

```bash
curl -X POST http://localhost:82/psop/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@psop.ps",
    "password": "admin123"
  }'
```

## هيكل الاستجابة (Response Structure)

### استجابة ناجحة
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {
    // البيانات المطلوبة
  }
}
```

### استجابة خطأ
```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field_name": "Error description"
  }
}
```

## أكواد الحالة (Status Codes)

| الكود | الوصف |
|------|-------|
| 200 | نجح الطلب |
| 201 | تم الإنشاء بنجاح |
| 400 | خطأ في البيانات المرسلة |
| 401 | غير مصرح (تحتاج تسجيل دخول) |
| 403 | محظور (ليس لديك صلاحية) |
| 404 | غير موجود |
| 500 | خطأ في الخادم |

## CORS

تم تفعيل CORS للسماح بالوصول من أي domain:

```
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS
Access-Control-Allow-Headers: Content-Type, Authorization
```

## أمثلة باستخدام JavaScript

### Fetch API
```javascript
// تسجيل الدخول
async function login(email, password) {
  const response = await fetch('http://localhost:82/psop/api/v1/auth/login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ email, password })
  });
  
  const data = await response.json();
  if (data.success) {
    localStorage.setItem('token', data.data.token);
    return data.data;
  }
  throw new Error(data.message);
}

// الحصول على المسابقات
async function getCompetitions() {
  const response = await fetch('http://localhost:82/psop/api/v1/competitions');
  const data = await response.json();
  return data.data;
}

// إنشاء مسابقة (يتطلب token)
async function createCompetition(competitionData) {
  const token = localStorage.getItem('token');
  const response = await fetch('http://localhost:82/psop/api/v1/competitions', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    },
    body: JSON.stringify(competitionData)
  });
  
  return await response.json();
}
```

### Axios
```javascript
import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:82/psop/api/v1',
  headers: {
    'Content-Type': 'application/json'
  }
});

// Interceptor لإضافة Token تلقائياً
api.interceptors.request.use(config => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// استخدام
async function getCompetitions() {
  const response = await api.get('/competitions');
  return response.data.data;
}
```

## تحديث التوثيق

بعد تعديل الـ annotations في Controllers، قم بتشغيل:

```bash
cd public
php generate-swagger.php
```

سيتم تحديث ملف `swagger.json` تلقائياً.

## الأمان

### في بيئة الإنتاج:
1. استخدم JWT بدلاً من Token بسيط
2. استخدم HTTPS فقط
3. قم بتفعيل Rate Limiting
4. سجل جميع الطلبات في Activity Log
5. استخدم validation قوي للبيانات

### مثال JWT Implementation:
```bash
composer require firebase/php-jwt
```

## Activity Logging

جميع عمليات API يتم تسجيلها تلقائياً في `activity_logs` table عبر:
```php
logCreate('competition', $id, 'إنشاء مسابقة عبر API');
logUpdate('user', $userId, 'تحديث بيانات المستخدم عبر API');
```

## المساعدة والدعم

- **التوثيق التفاعلي**: http://localhost:82/psop/api/docs
- **الكود المصدري**: `src/Controllers/Api/`
- **الـ Models**: `src/Models/`

## Postman Collection

يمكنك استيراد `swagger.json` مباشرة في Postman:
1. افتح Postman
2. اذهب إلى Import → Upload Files
3. اختر `public/swagger.json`
4. سيتم إنشاء Collection كامل تلقائياً!
