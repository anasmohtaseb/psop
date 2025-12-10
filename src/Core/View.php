<?php

declare(strict_types=1);

namespace App\Core;

/**
 * View Renderer
 * Loads PHP templates with layout support
 */
class View
{
    private array $config;
    private string $viewsPath;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->viewsPath = $config['paths']['views'];
    }

    /**
     * Render a view with optional layout
     */
    public function render(string $viewPath, array $data = [], ?string $layout = null): void
    {
        // Start session if needed
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Add current user to data if authenticated
        if (!isset($data['user']) && isset($_SESSION['user'])) {
            $data['user'] = $_SESSION['user'];
        }
        
        // Add CSRF token to data
        if (!isset($data['csrf_token'])) {
            $data['csrf_token'] = $this->getCsrfToken();
        }
        
        // Start output buffering
        ob_start();
        
        // Extract data to variables
        extract($data);
        
        // Include the view file with $this bound to View instance
        $viewFile = $this->viewsPath . '/' . $viewPath . '.php';
        
        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View not found: {$viewPath}");
        }
        
        // Use anonymous function to bind $this context
        $renderView = function() use ($viewFile, $data) {
            extract($data);
            require $viewFile;
        };
        $renderView = $renderView->bindTo($this, $this);
        $renderView();
        
        // Get the view content
        $content = ob_get_clean();
        
        // If layout is specified, wrap content in layout
        if ($layout !== null) {
            $layoutFile = $this->viewsPath . '/layouts/' . $layout . '.php';
            
            if (!file_exists($layoutFile)) {
                throw new \RuntimeException("Layout not found: {$layout}");
            }
            
            // Start output buffering for layout
            ob_start();
            
            // Make content available to layout as $viewContent
            $viewContent = $content;
            
            // Include layout with $this context and merged data
            $renderLayout = function() use ($layoutFile, $data, $viewContent) {
                extract($data);
                // $viewContent is already in scope
                require $layoutFile;
            };
            $renderLayout = $renderLayout->bindTo($this, $this);
            $renderLayout();
            
            $content = ob_get_clean();
        }
        
        echo $content;
    }

    /**
     * Escape HTML output
     */
    public function e(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Generate URL
     */
    public function url(string $path = ''): string
    {
        $baseUrl = rtrim($this->config['app']['base_url'], '/');
        $path = ltrim($path, '/');
        return $baseUrl . '/' . $path;
    }

    /**
     * Generate asset URL
     */
    public function asset(string $path): string
    {
        $baseUrl = rtrim($this->config['app']['base_url'], '/');
        $path = ltrim($path, '/');
        return $baseUrl . '/assets/' . $path;
    }

    /**
     * Generate or get CSRF token
     */
    public function generateCsrfToken(): string
    {
        return $this->getCsrfToken();
    }

    /**
     * Get CSRF token from session
     */
    private function getCsrfToken(): string
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
