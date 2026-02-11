<?php declare(strict_types=1);



/**
 * Front Controller - Entry point for all requests
 * Palestine Science Olympiad Portal
 */

// Start session configuration
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');

// Error reporting based on environment
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load configuration
$config = require __DIR__ . '/../config/config.php';

// Load activity logger helper
require_once __DIR__ . '/../src/Core/ActivityLogger.php';

// Set error display based on debug mode
if ($config['app']['debug']) {
    ini_set('display_errors', '1');
}

// Set timezone
date_default_timezone_set('Asia/Gaza');

// Initialize router
$router = new App\Core\Router($config);

$router->post('/admin/competitions/{id}/images/upload', 'Admin\\CompetitionImageController', 'upload');
$router->post('/admin/competitions/{id}/images/{imageId}/delete', 'Admin\\CompetitionImageController', 'delete');
$router->post('/admin/competitions/{id}/images/{imageId}/feature', 'Admin\\CompetitionImageController', 'feature');
$router->get('/admin/competitions/{id}/images', 'Admin\\CompetitionImageController', 'index');

// Public routes
$router->get('/', 'HomeController', 'index');
$router->get('/about', 'HomeController', 'about');
$router->get('/contact', 'HomeController', 'contact');
$router->post('/contact/send', 'HomeController', 'sendContact');

// Authentication routes
$router->get('/login', 'AuthController', 'showLogin');
$router->post('/login', 'AuthController', 'login');
$router->get('/logout', 'AuthController', 'logout');
$router->get('/register/student', 'AuthController', 'showRegisterStudent');
$router->post('/register/student', 'AuthController', 'registerStudent');
$router->get('/register/school', 'AuthController', 'showRegisterSchool');
$router->post('/register/school', 'AuthController', 'registerSchool');

// Dashboard routes
$router->get('/dashboard', 'DashboardController', 'index');
$router->get('/dashboard/profile', 'DashboardController', 'profile');
$router->post('/dashboard/profile/update', 'DashboardController', 'updateProfile');

// Competition routes (public)
$router->get('/competitions', 'CompetitionController', 'index');
$router->get('/competitions/{id}', 'CompetitionController', 'show');

// Registration routes (authenticated)
$router->get('/dashboard/registrations', 'RegistrationController', 'myRegistrations');
$router->get('/registrations/create/{editionId}', 'RegistrationController', 'create');
$router->post('/registrations/store', 'RegistrationController', 'store');
$router->get('/registrations/view/{id}', 'RegistrationController', 'show');

// Admin routes
$router->get('/admin/competitions', 'CompetitionController', 'adminIndex');
$router->get('/admin/competitions/create', 'CompetitionController', 'create');
$router->post('/admin/competitions/store', 'CompetitionController', 'store');
$router->get('/admin/competitions/{id}/edit', 'CompetitionController', 'edit');
$router->post('/admin/competitions/{id}/update', 'CompetitionController', 'update');

// Admin Competition Editions routes
$router->get('/admin/competitions/{id}/editions', 'Admin\CompetitionEditionController', 'index');
$router->get('/admin/competitions/{id}/editions/create', 'Admin\CompetitionEditionController', 'create');
$router->post('/admin/competitions/{id}/editions/store', 'Admin\CompetitionEditionController', 'store');
$router->get('/admin/competitions/{id}/editions/{editionId}/edit', 'Admin\CompetitionEditionController', 'edit');
$router->post('/admin/competitions/{id}/editions/{editionId}/update', 'Admin\CompetitionEditionController', 'update');
$router->post('/admin/competitions/{id}/editions/{editionId}/delete', 'Admin\CompetitionEditionController', 'delete');

$router->get('/admin/registrations', 'RegistrationController', 'adminList');
$router->get('/admin/registrations/create', 'RegistrationController', 'adminCreate');
$router->post('/admin/registrations/store', 'RegistrationController', 'adminStore');
$router->get('/admin/registrations/{editionId}', 'RegistrationController', 'adminIndex');
$router->post('/admin/registrations/{id}/status', 'RegistrationController', 'updateStatus');

// User management routes
$router->get('/admin/users', 'UserController', 'index');
$router->get('/admin/users/create', 'UserController', 'create');
$router->post('/admin/users/store', 'UserController', 'store');
$router->get('/admin/users/{id}/edit', 'UserController', 'edit');
$router->post('/admin/users/{id}/update', 'UserController', 'update');
$router->post('/admin/users/{id}/delete', 'UserController', 'delete');

// School management routes
$router->get('/admin/schools', 'SchoolController', 'index');
$router->get('/admin/schools/create', 'SchoolController', 'create');
$router->post('/admin/schools/store', 'SchoolController', 'store');
$router->get('/admin/schools/{id}/edit', 'SchoolController', 'edit');
$router->post('/admin/schools/{id}/update', 'SchoolController', 'update');
$router->post('/admin/schools/{id}/delete', 'SchoolController', 'delete');
$router->post('/admin/schools/{id}/toggle-status', 'SchoolController', 'toggleStatus');

// Subscription routes
$router->get('/subscriptions/plans', 'SubscriptionController', 'plans');
$router->post('/subscriptions/subscribe', 'SubscriptionController', 'subscribe');
$router->get('/subscriptions/payment/{subscriptionId}', 'SubscriptionController', 'payment');
$router->post('/subscriptions/confirm-payment', 'SubscriptionController', 'confirmPayment');
$router->get('/subscriptions/my-subscription', 'SubscriptionController', 'mySubscription');

// Admin subscription routes
$router->get('/admin/subscriptions', 'SubscriptionController', 'adminList');
$router->get('/admin/subscriptions/edit/{id}', 'SubscriptionController', 'adminEdit');
$router->post('/admin/subscriptions/update', 'SubscriptionController', 'adminUpdate');
$router->post('/admin/subscriptions/activate', 'SubscriptionController', 'adminActivate');
$router->post('/admin/subscriptions/cancel', 'SubscriptionController', 'adminCancel');
$router->get('/admin/subscriptions/plans', 'SubscriptionController', 'adminPlans');
$router->get('/admin/subscriptions/plans/create', 'SubscriptionController', 'adminCreatePlan');
$router->post('/admin/subscriptions/plans/store', 'SubscriptionController', 'adminStorePlan');
$router->get('/admin/subscriptions/plans/{planId}/edit', 'SubscriptionController', 'adminEditPlan');
$router->post('/admin/subscriptions/plans/update', 'SubscriptionController', 'adminUpdatePlan');
$router->post('/admin/subscriptions/plans/delete', 'SubscriptionController', 'adminDeletePlan');

// Activity Log routes
$router->get('/admin/activity-logs', 'ActivityLogController', 'index');
$router->get('/admin/activity-logs/export', 'ActivityLogController', 'export');
$router->get('/admin/activity-logs/user/{userId}', 'ActivityLogController', 'userActivity');
$router->get('/admin/activity-logs/entity/{entityType}/{entityId}', 'ActivityLogController', 'entityActivity');

// API Routes v1
$router->get('/api/v1/competitions', 'Api\CompetitionApiController', 'index');
$router->get('/api/v1/competitions/{id}', 'Api\CompetitionApiController', 'show');
$router->post('/api/v1/competitions', 'Api\CompetitionApiController', 'create');
$router->any('/api/v1/competitions/{id}', 'Api\CompetitionApiController', 'update'); // PUT via any()
$router->any('/api/v1/competitions/{id}/delete', 'Api\CompetitionApiController', 'delete'); // DELETE

$router->get('/api/v1/users', 'Api\UserApiController', 'index');
$router->get('/api/v1/users/{id}', 'Api\UserApiController', 'show');
$router->post('/api/v1/auth/register', 'Api\UserApiController', 'register');
$router->post('/api/v1/auth/login', 'Api\UserApiController', 'login');

// Swagger Documentation
$router->get('/api/docs', 'SwaggerController', 'index');

// Admin page management routes
$router->get('/admin/pages', 'Admin\PageController', 'index');
$router->get('/admin/pages/edit', 'Admin\PageController', 'edit');
$router->post('/admin/pages/update-info', 'Admin\PageController', 'updatePageInfo');
$router->post('/admin/pages/update-section', 'Admin\PageController', 'updateSection');
$router->post('/admin/pages/create-section', 'Admin\PageController', 'createSection');
$router->post('/admin/pages/delete-section', 'Admin\PageController', 'deleteSection');
$router->post('/admin/pages/update-stat', 'Admin\PageController', 'updateStat');
$router->post('/admin/pages/create-stat', 'Admin\PageController', 'createStat');
$router->post('/admin/pages/delete-stat', 'Admin\PageController', 'deleteStat');

// Admin Hero Section routes
$router->get('/admin/hero', 'Admin\HeroController', 'index');
$router->post('/admin/hero/update', 'Admin\HeroController', 'update');

// Admin slider management routes
$router->get('/admin/slider', 'Admin\SliderController', 'index');
$router->get('/admin/slider/create', 'Admin\SliderController', 'create');
$router->post('/admin/slider/store', 'Admin\SliderController', 'store');
$router->get('/admin/slider/edit', 'Admin\SliderController', 'edit');
$router->post('/admin/slider/update', 'Admin\SliderController', 'update');
$router->post('/admin/slider/delete', 'Admin\SliderController', 'delete');
$router->post('/admin/slider/toggle', 'Admin\SliderController', 'toggleActive');

// Admin settings routes
$router->get('/admin/settings', 'Admin\SettingsController', 'index');
$router->post('/admin/settings/update', 'Admin\SettingsController', 'update');

// Admin announcements routes
$router->get('/admin/announcements', 'Admin\AnnouncementController', 'index');
$router->get('/admin/announcements/create', 'Admin\AnnouncementController', 'create');
$router->post('/admin/announcements/store', 'Admin\AnnouncementController', 'store');
$router->get('/admin/announcements/edit', 'Admin\AnnouncementController', 'edit');
$router->post('/admin/announcements/update', 'Admin\AnnouncementController', 'update');
$router->post('/admin/announcements/delete', 'Admin\AnnouncementController', 'delete');

// Dispatch the request
try {
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $requestUri = $_SERVER['REQUEST_URI'];
    
    $router->dispatch($requestMethod, $requestUri);
} catch (Throwable $e) {
    // Log the error
    error_log('Application Error: ' . $e->getMessage());
    error_log('Stack trace: ' . $e->getTraceAsString());
    
    // Show error page
    http_response_code(500);
    
    if ($config['app']['debug']) {
        echo '<h1>Application Error</h1>';
        echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    } else {
        echo '<h1>حدث خطأ</h1>';
        echo '<p>نعتذر، حدث خطأ في النظام. يرجى المحاولة لاحقاً.</p>';
    }
}
