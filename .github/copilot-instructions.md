# Palestine Science Olympiad Portal - AI Coding Agent Instructions

## Project Overview

Pure PHP 8.0+ web application (no Laravel/Symfony) for managing international science olympiad competitions for Palestinian students. Uses custom MVC architecture with PSR-4 autoloading, MySQL/PDO, and role-based access control.

**Key Technologies**: PHP 8.0+, MySQL 5.7+, Apache with mod_rewrite, Composer for PSR-4 autoloading
**Environment**: XAMPP development stack, runs at `http://localhost/psop/public` with Apache DocumentRoot configuration
**API**: RESTful API with OpenAPI 3.0 documentation (Swagger UI at `/api/docs`)

## Architecture

### Core Framework (`src/Core/`)
- **Router**: Pattern-based routing with parameter extraction (`/competitions/{id}`). Routes defined in `public/index.php`. Regex-based pattern matching with named parameters. Supports GET, POST, and `any()` for PUT/DELETE
- **Controller**: Base class providing view rendering, redirects, flash messages, CSRF protection, and auth checks. All controllers extend this
- **View**: PHP templates with layout system. Uses `extract()` to make array keys available as variables, `$this` bound to View instance for helpers
- **Auth**: Session-based authentication with RBAC. Loads user with roles on init via `loadUser()`, checks via `hasRole()`, stores user in `$_SESSION['user']`
- **Validator**: Fluent validation with chainable methods. Returns errors array, supports custom database uniqueness checks with DB queries
- **ActivityLogger**: Global `logActivity()` function for tracking user actions across the system (login, CRUD operations, status changes)

### Request Flow
1. `public/index.php` (front controller) → Composer autoloader → config loading → Router instantiation
2. Router matches HTTP method + URI pattern → uses regex patterns to extract route parameters → instantiates Controller → calls action method
3. Controller can: render views with layouts, redirect, set flash messages, validate CSRF, check auth/roles
4. Views in `views/` use `$viewContent` in layouts. Access helper methods via `$this->` (e.g., `$this->url()`, `$this->e()`, `$this->asset()`)
5. Flash messages stored in `$_SESSION['flash']` and auto-displayed in layouts on next request (one-time messages)

### Database Layer
- **BaseModel** (`src/Models/BaseModel.php`): CRUD operations, query builders with prepared statements. All models extend this
- Entity models extend BaseModel, set `$table` property (required), optionally override `$primaryKey` (defaults to 'id')
- PDO connection initialized via `getDatabase()` function in `config/database.php`, reused across models
- Models instantiated with `new Model($config)`, pass config array from controller (`$this->config`)

### Environment & Configuration
- `.env` file (never committed): Database credentials, app debug mode, base URL
- `config/config.php`: Loads `.env` via custom parser, provides `env()` helper function with defaults
- Config array structure: `['app' => [...], 'database' => [...], 'session' => [...], 'paths' => [...]]`
- Session configured with secure settings: HttpOnly, SameSite=Strict, Secure flag in production

## Key Conventions

### Routing
```php
// public/index.php - ALL routes defined here
$router->get('/path', 'ControllerName', 'action'); // Maps to App\Controllers\ControllerName::action()
$router->post('/path', 'ControllerName', 'action'); // POST requests
$router->get('/items/{id}', 'ItemController', 'show'); // {id} becomes parameter, accessible as function parameter
$router->get('/admin/pages', 'Admin\PageController', 'index'); // Namespaced controllers in subfolders

// Router pattern conversion: /competitions/{id} becomes regex #^/competitions/(?P<id>[^/]+)$#
// Base path (/psop/public) stripped automatically by Router::dispatch()
```

### Controllers
- Extend `App\Core\Controller`, namespace matches directory structure (`Admin\` → `src/Controllers/Admin/`, `Api\` → `src/Controllers/Api/`)
- Constructor MUST call `parent::__construct($config)` first, then initialize models
- Use `$this->requireAuth()` or `$this->requireRole('admin')` at start of protected actions
- CSRF validation: `$this->validateCsrfToken()` in POST handlers (reads from `$_POST['csrf_token']`)
- Flash messages: `$this->setFlash('success', 'message')` → displayed in layout on next request (auto-cleared)
- Render: `$this->render('view/path', $data, 'layout_name')` (layout optional: 'dashboard' or 'public', defaults to 'dashboard')
- NEVER echo/print directly in controllers - use `$this->render()` or `$this->json()` for responses
- **API Controllers**: Extend `Api\ApiController`, use `$this->enableCors()` for cross-origin requests, return JSON with `$this->json()`, use OpenAPI annotations for documentation

### Models
- Extend `App\Models\BaseModel`, set `protected string $table = 'table_name'` (REQUIRED)
- Constructor: `parent::__construct($config)` initializes PDO connection automatically
- Use inherited methods: `findById()`, `findAll(['status' => 'active'], 50, 0)`, `findOne(['email' => $email])`, `create($data)`, `update($id, $data)`, `delete($id)`
- Custom queries: `$this->query($sql, $params)` returns all rows, `$this->queryOne($sql, $params)` returns single row or null
- Always use prepared statements: `$stmt = $this->db->prepare($sql); $stmt->execute($params);` NEVER string concatenation
- PDO fetch mode: `PDO::FETCH_ASSOC` (returns associative arrays, not objects)

### Views
- PHP templates in `views/`, data passed as array and extracted to variables (NOT objects)
- Layouts in `views/layouts/`: `public.php` (unauthenticated), `dashboard.php` (authenticated with sidebar)
- Helper methods via `$this->` (View instance): `$this->e($str)` (htmlspecialchars escape), `$this->url($path)` (generate full URL), `$this->asset($path)` (asset URLs)
- CSRF token: Auto-injected as `$csrf_token` variable, use in forms: `<input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">`
- Flash messages: Auto-displayed in layouts, read from `$_SESSION['flash']` and cleared after display
- Access current user: `$user` variable auto-injected if authenticated (array with id, name, email, type, roles)
- Arabic-first UI: Most text in Arabic (RTL), dir="rtl" in HTML, use `name_ar` fields for display

### Validation
```php
$validator = new Validator($_POST);
$validator->required('field', 'رسالة خطأ اختيارية')->email('email')->min('password', 8);
if ($validator->fails()) {
    $_SESSION['errors'] = $validator->errors(); // ['field' => ['error message']]
    $_SESSION['old'] = $_POST; // Preserve input for repopulation
    $this->redirect('/form');
}
// Validator methods chainable: required(), email(), min(), max(), unique($model, $field, $excludeId)
// All error messages default to Arabic
```

## User Roles & Types

### User Types (column: `type`)
- `student`: Can register for competitions, view training resources
- `school_coordinator`: Manages school students and registrations
- `trainer`: Accesses training resources
- `admin`: Full system access
- `competition_manager`: Manages specific competitions

### RBAC Roles (table: `roles`, junction: `user_roles`)
Same names as types. Check via `$this->auth->hasRole('admin')` or `$this->auth->isStudent()`

## Registration Workflow

**Statuses**: `draft` → `submitted` → `under_review` → `accepted_training` / `accepted_final` / `rejected` / `cancelled`

1. Student creates registration via `/registrations/create/{editionId}` (checks: authenticated, student type, not already registered)
2. Status set to `submitted`
3. Admin reviews via `/admin/registrations/{editionId}`, updates status
4. Registration links student to `competition_edition_id`, stores `school_id` from student profile

## Security Patterns

- **Passwords**: Use `password_hash()` in User model, `password_verify()` in Auth
- **CSRF**: Generate token with `$this->generateCsrfToken()`, validate with `$this->validateCsrfToken()` in POST handlers
- **SQL Injection**: Always prepared statements, never string concatenation in queries
- **Session**: Configured in `config/config.php` with HttpOnly, Secure (production), SameSite=Strict
- **Access Control**: Controllers call `$this->requireAuth()` or `$this->requireRole('role_name')` at start of protected actions

## Database Structure

### Core Tables
- `users`: name, email, password_hash, phone, type (enum: student/school_coordinator/trainer/admin/competition_manager), status (active/inactive/pending)
- `roles` + `user_roles`: RBAC junction table, role names match user types
- `schools`: name, type (government/private/UNRWA), governorate, city, status (active/pending)
- `school_users`: Links coordinators/trainers to schools (user_id, school_id, role in school)
- `students_profile`: user_id (PK/FK to users), gender, date_of_birth, grade, school_id, guardian info (name, phone, email)

### Competition Tables
- `competitions`: name_ar/en, code (unique, e.g., 'IMO'), category (enum: math/informatics/physics/multidisciplinary), description_ar/en, is_active
- `competition_editions`: competition_id, year, dates (registration_start/end, training_start/end, competition_start/end), status (upcoming/active/completed), host_country
- `competition_tracks`: edition_id, name_ar/en, min/max_age, min/max_grade, participation_type (individual/team), max_participants_per_team
- `registrations`: edition_id, student_user_id (nullable for teams), team_id (nullable), school_id, status (draft/submitted/under_review/accepted_training/accepted_final/rejected/cancelled), notes
- `teams` + `team_members`: For team-based competitions, team has name and leader_user_id, members link user_id to team_id

### Subscription System (docs/subscription-system.md)
- `subscription_plans`: name_ar/en, type (student/school/trial), price (decimal), duration_months, features (text), is_active
- `user_subscriptions`: user_id, plan_id, status (pending/active/expired/cancelled), payment_status (unpaid/paid/refunded), start_date, end_date, payment_date
- **Key Pattern**: Check active subscription before competition registration using `UserSubscription::getActiveSubscription($userId)` 
- Trial plans are free and auto-activated, paid plans require admin activation or payment gateway integration

### Dynamic Pages System
- `pages`: page_key (unique, e.g., 'about'), page_title_ar/en, meta_description, is_active, created_at, updated_at
- `page_sections`: page_id, section_type (hero/text/stats/features/grid), section_order, title_ar/en, content_ar/en, image_url, button_text/url
- `page_section_items`: section_id, item_type (stat/feature), item_order, title_ar/en, value/icon, description_ar/en
- **Admin Access**: `/admin/pages` for WYSIWYG-like editing of sections, stats, and features without touching code

### Supporting Tables
- `training_resources`: competition_id, title_ar/en, resource_type (pdf/video/link/quiz), url/file_path, description_ar/en
- `announcements`: title, content, target_audience (enum: all/students/coordinators/trainers), status (draft/published), publish_date
- `notifications`: user_id, title, message, type (info/success/warning/error), is_read, created_at
- `activity_logs`: user_id, user_type, action, description, entity_type, entity_id, metadata (JSON), ip_address, user_agent, created_at
- `hero_slides`: title_ar, description_ar, image_path, slide_order, is_active (homepage carousel)
- `site_settings`: setting_key, setting_value, setting_type (text/textarea/image/email/url), setting_group (general/contact/social), display_name_ar, display_order
- `contact_messages`: name, email, subject, message, status (new/read/replied), created_at

## Development Workflows

### Adding a Feature
1. Add route in `public/index.php`: `$router->get('/path', 'NewController', 'action')`
2. Create controller in `src/Controllers/NewController.php` extending `Controller`
3. Create model if needed in `src/Models/` extending `BaseModel`
4. Create view in `views/` directory with appropriate layout
5. Update database schema if needed (add SQL to `database/schema.sql`)
6. Add activity logging for important actions: `logActivity('action_name', 'وصف بالعربية', 'entity_type', $entityId)`

### Running Database Changes
```powershell
# Import full schema (WARNING: drops existing tables)
Get-Content database\schema.sql | mysql -u root -p psop_db

# Import specific feature schemas
Get-Content database\subscriptions.sql | mysql -u root -p psop_db
Get-Content database\pages.sql | mysql -u root -p psop_db
Get-Content database\activity_log.sql | mysql -u root -p psop_db
Get-Content database\hero_slider.sql | mysql -u root -p psop_db
Get-Content database\site_settings.sql | mysql -u root -p psop_db

# Reset admin password if locked out
php reset_admin_password.php
```

### Debugging
- Set `APP_DEBUG=true` in `.env` to see detailed errors and stack traces
- Check `public/debug.php` for database connection and config testing
- Use `public/test_login.php` to verify authentication flow
- Flash messages visible in browser via layout templates (success/error/info/warning)

### Common Pitfalls
- Forgetting CSRF validation on POST requests → add `$this->validateCsrfToken()` check
- Not checking auth/roles → use `$this->requireAuth()` or `$this->requireRole()`
- SQL injection via string concatenation → use prepared statements
- Not preserving form input on validation errors → store in `$_SESSION['old']`
- Flash messages not showing → ensure layout includes flash display code
- Base URL path issues → Router strips `/psop/public` automatically, `$this->url()` adds base_url from config

## File Locations
- **Config**: `config/config.php` (app settings), `config/database.php` (PDO connection)
- **Routing**: `public/index.php` (all route definitions)
- **Entry Point**: `public/index.php` (Apache should point to `public/` folder)
- **Environment**: `.env` (copy from `.env.example`, never commit)
- **Schema**: `database/schema.sql` (includes sample data for testing)
- **Assets**: `public/assets/css/style.css`, `public/assets/js/app.js`

## Running the Application

1. **Setup**: `composer install` → create `.env` from example → import `database/schema.sql`
2. **Access**: `http://localhost/psop/public` (or configure Apache DocumentRoot to `public/`)
3. **Default Admin**: Email: `admin@psop.ps`, Password: `admin123`
4. **Development**: Enable debug in `.env`: `APP_DEBUG=true` (shows errors and stack traces)
5. **Import Sample Data**: Database includes seed data for testing (competitions, sample students, schools)

## Activity Logging System

Global helper functions available throughout the application (loaded in `public/index.php`):

```php
// Basic activity log
logActivity('login', 'تسجيل دخول المستخدم أحمد');

// Log with entity reference
logActivity('update_competition', 'تعديل المسابقة', 'competition', $competitionId);

// Log with metadata (stores as JSON)
logActivity('payment', 'دفع اشتراك', 'subscription', $subId, ['amount' => 100, 'method' => 'paypal']);

// Quick log functions (shortcuts)
logCreate('competition', $id, 'إنشاء مسابقة جديدة'); // action='create'
logUpdate('user', $id, 'تعديل بيانات المستخدم'); // action='update'
logDelete('registration', $id, 'حذف تسجيل'); // action='delete'
```

**Admin Access**: `/admin/activity-logs` (admin-only, filterable by user, entity, action, date range)

## RESTful API

**Base URL**: `/api/v1/*`  
**Documentation**: `/api/docs` (Swagger UI) or `/swagger.json` (OpenAPI JSON)  
**Authentication**: Bearer token via `Authorization: Bearer {token}` header

### API Patterns
```php
// In Api\ApiController subclasses
protected function requireApiAuth(): ?array {
    // Returns user array or sends 401 JSON response
}

// OpenAPI annotations for documentation
/**
 * @OA\Get(
 *     path="/competitions",
 *     summary="List competitions",
 *     @OA\Response(response="200", description="Success")
 * )
 */
public function index() {
    $this->enableCors();
    $data = $model->findAll();
    $this->json(['success' => true, 'data' => $data]);
}
```

**Generate Swagger**: `php public/generate-swagger.php` (regenerates `/swagger.json` from annotations)

## Hero Slider & Site Settings

- **Hero Slides**: Manage homepage carousel at `/admin/slider` (upload images, reorder, toggle active)
- **Site Settings**: Admin can update site name, logo, contact info at `/admin/settings` without code changes
- Models: `HeroSlide`, `SiteSetting` with helper `SiteSetting::get('key', 'default')`

## Quick Reference

```php
// Controller patterns
$this->requireRole('admin'); // Check role
$this->render('view', $data, 'layout'); // Render view
$this->redirect('/path'); // Redirect
$this->setFlash('success', 'Done'); // Flash message
$this->json(['key' => 'value']); // JSON response

// Model patterns
$model = new User($this->config);
$user = $model->findById(1);
$users = $model->findAll(['status' => 'active'], 50, 0);
$id = $model->create(['name' => 'Test', 'email' => 'test@example.com']);

// Auth patterns
$this->auth->check(); // Is logged in?
$this->auth->user(); // Get current user array
$this->auth->hasRole('admin'); // Check role
$this->auth->attempt($email, $password); // Login
```
