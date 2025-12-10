<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Base Controller
 * Provides common functionality for all controllers
 */
abstract class Controller
{
    protected array $config;
    protected View $view;
    protected Auth $auth;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->view = new View($config);
        $this->auth = new Auth($config);
    }

    /**
     * Render a view
     */
    protected function render(string $viewPath, array $data = [], ?string $layout = 'dashboard'): void
    {
        $this->view->render($viewPath, $data, $layout);
    }

    /**
     * Redirect to a URL
     */
    protected function redirect(string $path, int $statusCode = 302): void
    {
        $url = $this->url($path);
        header("Location: {$url}", true, $statusCode);
        exit;
    }

    /**
     * Generate URL from path
     */
    protected function url(string $path = ''): string
    {
        $baseUrl = rtrim($this->config['app']['base_url'], '/');
        $path = ltrim($path, '/');
        return $baseUrl . '/' . $path;
    }

    /**
     * Set a flash message
     */
    protected function setFlash(string $type, string $message): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['flash'][$type] = $message;
    }

    /**
     * Get and clear flash messages
     */
    protected function getFlash(string $type): ?string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $message = $_SESSION['flash'][$type] ?? null;
        unset($_SESSION['flash'][$type]);
        return $message;
    }

    /**
     * Return JSON response
     */
    protected function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Check if user is authenticated, redirect if not
     */
    protected function requireAuth(): void
    {
        if (!$this->auth->check()) {
            $this->setFlash('error', 'يجب تسجيل الدخول للوصول إلى هذه الصفحة');
            $this->redirect('/login');
        }
    }

    /**
     * Check if user has a specific role, redirect if not
     */
    protected function requireRole(string $role): void
    {
        $this->requireAuth();
        
        if (!$this->auth->hasRole($role)) {
            $this->setFlash('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
            $this->redirect('/dashboard');
        }
    }

    /**
     * Validate CSRF token
     */
    protected function validateCsrfToken(): bool
    {
        $tokenName = $this->config['security']['csrf_token_name'];
        $submittedToken = $_POST[$tokenName] ?? '';
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $sessionToken = $_SESSION['csrf_token'] ?? '';
        
        return hash_equals($sessionToken, $submittedToken);
    }

    /**
     * Generate CSRF token
     */
    protected function generateCsrfToken(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['csrf_token'];
    }
}
