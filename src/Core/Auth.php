<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

/**
 * Authentication and Authorization
 * Handles sessions, login/logout, and role-based access control
 */
class Auth
{
    private array $config;
    private PDO $db;
    private ?array $user = null;

    public function __construct(array $config)
    {
        $this->config = $config;
        
        // Load database connection function and get PDO instance
        require_once $config['paths']['root'] . '/config/database.php';
        $this->db = getDatabase($config);
        
        $this->startSession();
        $this->loadUser();
    }

    /**
     * Start session with configured settings
     */
    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $sessionConfig = $this->config['session'];
            
            session_set_cookie_params([
                'lifetime' => $sessionConfig['lifetime'],
                'path' => $sessionConfig['path'],
                'secure' => $sessionConfig['secure'],
                'httponly' => $sessionConfig['httponly'],
                'samesite' => $sessionConfig['samesite'],
            ]);
            
            session_name($sessionConfig['name']);
            session_start();
        }
    }

    /**
     * Load current user from session
     */
    private function loadUser(): void
    {
        if (!empty($_SESSION['user_id'])) {
            $stmt = $this->db->prepare('
                SELECT u.*, GROUP_CONCAT(r.role_name) as roles
                FROM users u
                LEFT JOIN user_roles ur ON u.id = ur.user_id
                LEFT JOIN roles r ON ur.role_id = r.id
                WHERE u.id = ? AND u.status = "active"
                GROUP BY u.id
            ');
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch();
            
            if ($user) {
                $user['roles'] = $user['roles'] ? explode(',', $user['roles']) : [];
                $this->user = $user;
                $_SESSION['user'] = $user;
            } else {
                // User not found or inactive, clear session
                $this->logout();
            }
        }
    }

    /**
     * Attempt to login with phone/email and password
     * @param string $identifier Can be phone number or email
     */
    public function attempt(string $identifier, string $password): bool
    {
        // Check if identifier is email or phone
        $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL);
        
        $stmt = $this->db->prepare('
            SELECT u.*, GROUP_CONCAT(r.role_name) as roles
            FROM users u
            LEFT JOIN user_roles ur ON u.id = ur.user_id
            LEFT JOIN roles r ON ur.role_id = r.id
            WHERE ' . ($isEmail ? 'u.email' : 'u.phone') . ' = ? AND u.status = "active"
            GROUP BY u.id
        ');
        $stmt->execute([$identifier]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            $user['roles'] = $user['roles'] ? explode(',', $user['roles']) : [];
            $this->user = $user;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user;
            
            // Regenerate session ID to prevent fixation
            session_regenerate_id(true);
            
            return true;
        }
        
        return false;
    }

    /**
     * Logout current user
     */
    public function logout(): void
    {
        $this->user = null;
        $_SESSION = [];
        
        // Destroy session cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        
        session_destroy();
    }

    /**
     * Check if user is authenticated
     */
    public function check(): bool
    {
        return $this->user !== null;
    }

    /**
     * Get current user
     */
    public function user(): ?array
    {
        return $this->user;
    }

    /**
     * Get current user ID
     */
    public function id(): ?int
    {
        return $this->user['id'] ?? null;
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        if (!$this->check()) {
            return false;
        }
        
        return in_array($role, $this->user['roles'] ?? []);
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole(array $roles): bool
    {
        if (!$this->check()) {
            return false;
        }
        
        return !empty(array_intersect($roles, $this->user['roles'] ?? []));
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is student
     */
    public function isStudent(): bool
    {
        return $this->user['type'] === 'student';
    }

    /**
     * Check if user is school coordinator
     */
    public function isSchoolCoordinator(): bool
    {
        return $this->user['type'] === 'school_coordinator';
    }
}
