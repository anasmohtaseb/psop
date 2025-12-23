<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Simple Router
 * Maps HTTP method + path to controller actions with parameter support
 */
class Router
{
    private array $routes = [];
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Register a GET route
     */
    public function get(string $path, string $controller, string $action): void
    {
        $this->addRoute('GET', $path, $controller, $action);
    }

    /**
     * Register a POST route
     */
    public function post(string $path, string $controller, string $action): void
    {
        $this->addRoute('POST', $path, $controller, $action);
    }

    /**
     * Register a route for any HTTP method
     */
    public function any(string $path, string $controller, string $action): void
    {
        $this->addRoute('ANY', $path, $controller, $action);
    }

    /**
     * Add a route to the routing table
     */
    private function addRoute(string $method, string $path, string $controller, string $action): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
            'pattern' => $this->convertPathToPattern($path),
        ];
    }

    /**
     * Convert route path to regex pattern
     * Supports {id}, {slug}, etc.
     */
    private function convertPathToPattern(string $path): string
    {
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    /**
     * Dispatch the request to the appropriate controller
     */
    public function dispatch(string $requestMethod, string $requestUri): void
    {
        // Remove query string
        $uri = parse_url($requestUri, PHP_URL_PATH);
        
        // Get base path from config (e.g., /psop or empty for root)
        $basePath = parse_url($this->config['app']['base_url'], PHP_URL_PATH) ?? '';
        $basePath = rtrim($basePath, '/');
        
        // Remove base path from URI if it exists
        if (!empty($basePath) && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        // Ensure leading slash
        if (empty($uri) || $uri[0] !== '/') {
            $uri = '/' . $uri;
        }

        // Find matching route
        foreach ($this->routes as $route) {
            if (($route['method'] === $requestMethod || $route['method'] === 'ANY') 
                && preg_match($route['pattern'], $uri, $matches)) {
                
                // Extract named parameters
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                // Instantiate controller and call action
                $controllerClass = 'App\\Controllers\\' . $route['controller'];
                
                if (!class_exists($controllerClass)) {
                    $this->sendNotFound("Controller not found: {$controllerClass}");
                    return;
                }
                
                $controller = new $controllerClass($this->config);
                $action = $route['action'];
                
                if (!method_exists($controller, $action)) {
                    $this->sendNotFound("Action not found: {$action}");
                    return;
                }
                
                // Call the controller action with parameters
                call_user_func_array([$controller, $action], $params);
                return;
            }
        }
        
        // No route found
        $this->sendNotFound("Route not found: {$requestMethod} {$uri}");
    }

    /**
     * Send 404 Not Found response
     */
    private function sendNotFound(string $message): void
    {
        http_response_code(404);
        
        if ($this->config['app']['debug']) {
            echo "<h1>404 Not Found</h1>";
            echo "<p>{$message}</p>";
        } else {
            // In production, show a nice error page
            require $this->config['paths']['views'] . '/errors/404.php';
        }
    }
}
