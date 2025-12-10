# Palestine Science Olympiad Portal - AI Coding Agent Instructions

## Project Overview

Pure PHP 8.0+ web application (no Laravel/Symfony) for managing international science olympiad competitions for Palestinian students. Uses custom MVC architecture with PSR-4 autoloading, MySQL/PDO, and role-based access control.

## Architecture

### Core Framework (`src/Core/`)
- **Router**: Pattern-based routing with parameter extraction (`/competitions/{id}`). Routes defined in `public/index.php`
- **Controller**: Base class providing view rendering, redirects, flash messages, CSRF protection, and auth checks
- **View**: PHP templates with layout system. Extracts data as variables, supports nested layouts
- **Auth**: Session-based authentication with RBAC. Loads user with roles on init, checks via `hasRole()`
- **Validator**: Fluent validation with chainable methods. Returns errors array, supports custom database uniqueness checks

### Request Flow
1. `public/index.php` (front controller) → autoloader → config → Router
2. Router matches HTTP method + URI pattern → instantiates Controller → calls action method
3. Controller can: render views with layouts, redirect, set flash messages, validate CSRF, check auth/roles
4. Views in `views/` use `$viewContent` in layouts. Access helper methods via `$this->` (e.g., `$this->url()`, `$this->e()`)

### Database Layer
- **BaseModel** (`src/Models/BaseModel.php`): CRUD operations, query builders with prepared statements
- Entity models extend BaseModel, set `$table` property, add domain-specific methods
- PDO connection initialized in `config/database.php`, reused across models via constructor injection

## Key Conventions

### Routing
```php
// public/index.php
$router->get('/path', 'ControllerName', 'action'); // Maps to App\Controllers\ControllerName::action()
$router->get('/items/{id}', 'ItemController', 'show'); // {id} becomes parameter
```

### Controllers
- Extend `App\Core\Controller`
- Use `$this->requireAuth()` or `$this->requireRole('admin')` for access control
- CSRF validation: `$this->validateCsrfToken()` for POST requests
- Flash messages: `$this->setFlash('success', 'message')` → displayed in layout on next request
- Render: `$this->render('view/path', $data, 'layout_name')` (layout optional, defaults to 'dashboard')

### Models
- Extend `App\Models\BaseModel`, set `protected string $table = 'table_name'`
- Use `findById()`, `findAll()`, `findOne()`, `create()`, `update()`, `delete()` from BaseModel
- Custom queries: `$this->query($sql, $params)` or `$this->queryOne($sql, $params)`
- Always use prepared statements: `$stmt = $this->db->prepare($sql); $stmt->execute($params);`

### Views
- PHP templates in `views/`, access data as variables (extracted from array)
- Layouts in `views/layouts/`: `public.php` (unauthenticated), `dashboard.php` (authenticated)
- Helper methods: `$this->e($str)` (escape), `$this->url($path)` (generate URL), `$this->asset($path)`
- Flash messages auto-displayed in layouts via `$_SESSION['flash']`

### Validation
```php
$validator = new Validator($_POST);
$validator->required('field')->email('email')->min('password', 8);
if ($validator->fails()) {
    $_SESSION['errors'] = $validator->errors();
    $_SESSION['old'] = $_POST; // Preserve input
    $this->redirect('/form');
}
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
- `users`: name, email, password_hash, phone, type (enum), status
- `roles` + `user_roles`: RBAC junction table
- `schools`: name, type, governorate, city, status (active/pending)
- `school_users`: Links coordinators/trainers to schools
- `students_profile`: user_id (PK/FK), gender, date_of_birth, grade, school_id, guardian info

### Competition Tables
- `competitions`: name_ar/en, code (unique), category (enum), description, is_active
- `competition_editions`: competition_id, year, dates (registration, training, competition), status, host_country
- `competition_tracks`: edition_id, name_ar/en, age/grade ranges, participation_type (individual/team)
- `registrations`: edition_id, student_user_id (nullable), team_id (nullable), school_id, status, notes
- `teams` + `team_members`: For team-based competitions

### Supporting Tables
- `training_resources`: competition_id, title_ar/en, resource_type, url/file_path
- `announcements`: title, content, target_audience (enum), status, publish_date
- `notifications`: user_id, title, message, type, is_read

## Development Workflows

### Adding a Feature
1. Add route in `public/index.php`: `$router->get('/path', 'NewController', 'action')`
2. Create controller in `src/Controllers/NewController.php` extending `Controller`
3. Create model if needed in `src/Models/` extending `BaseModel`
4. Create view in `views/` directory with appropriate layout
5. Update database schema if needed (add SQL to `database/schema.sql`)

### Common Pitfalls
- Forgetting CSRF validation on POST requests → add `$this->validateCsrfToken()` check
- Not checking auth/roles → use `$this->requireAuth()` or `$this->requireRole()`
- SQL injection via string concatenation → use prepared statements
- Not preserving form input on validation errors → store in `$_SESSION['old']`
- Flash messages not showing → ensure layout includes flash display code

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
