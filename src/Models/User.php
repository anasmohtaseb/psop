<?php

declare(strict_types=1);

namespace App\Models;

/**
 * User Model
 */
class User extends BaseModel
{
    protected string $table = 'users';

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?array
    {
        return $this->findOne(['email' => $email]);
    }

    /**
     * Create a new user with password hashing
     */
    public function createUser(array $data): int
    {
        if (isset($data['password'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        }
        
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['status'] = $data['status'] ?? 'active';
        
        return $this->create($data);
    }

    /**
     * Update user password
     */
    public function updatePassword(int $userId, string $newPassword): bool
    {
        return $this->update($userId, [
            'password_hash' => password_hash($newPassword, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get users by type
     */
    public function findByType(string $type, int $limit = 100, int $offset = 0): array
    {
        return $this->findAll(['type' => $type, 'status' => 'active'], $limit, $offset);
    }

    /**
     * Assign role to user
     */
    public function assignRole(int $userId, int $roleId): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO user_roles (user_id, role_id, created_at)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE created_at = created_at
        ");
        return $stmt->execute([$userId, $roleId, date('Y-m-d H:i:s')]);
    }

    /**
     * Remove role from user
     */
    public function removeRole(int $userId, int $roleId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM user_roles WHERE user_id = ? AND role_id = ?");
        return $stmt->execute([$userId, $roleId]);
    }

    /**
     * Search users with filters
     */
    public function searchUsers(array $filters = []): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        $where = [];

        if (!empty($filters['type'])) {
            $where[] = 'type = ?';
            $params[] = $filters['type'];
        }

        if (!empty($filters['status'])) {
            $where[] = 'status = ?';
            $params[] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $where[] = '(name LIKE ? OR email LIKE ? OR phone LIKE ?)';
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $sql .= ' ORDER BY created_at DESC';

        return $this->queryPublic($sql, $params);
    }

    /**
     * Get user statistics
     */
    public function getStatistics(): array
    {
        $stats = [];
        
        $stats['total'] = $this->countUsers();
        $stats['active'] = $this->countUsers(['status' => 'active']);
        $stats['pending'] = $this->countUsers(['status' => 'pending']);
        
        return $stats;
    }

    /**
     * Count users with filters
     */
    public function countUsers(array $filters = []): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $params = [];
        $where = [];

        if (!empty($filters['status'])) {
            $where[] = 'status = ?';
            $params[] = $filters['status'];
        }

        if (!empty($filters['type'])) {
            $where[] = 'type = ?';
            $params[] = $filters['type'];
        }

        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $result = $this->queryOnePublic($sql, $params);
        return (int)($result['count'] ?? 0);
    }

    /**
     * Get role by name
     */
    public function getRoleByName(string $name): ?array
    {
        $sql = "SELECT * FROM roles WHERE role_name = ?";
        return $this->queryOnePublic($sql, [$name]);
    }

    /**
     * Get all students
     */
    public function findAllStudents(): array
    {
        $sql = "SELECT u.*, sp.school_id, s.name as school_name 
                FROM {$this->table} u
                LEFT JOIN students_profile sp ON u.id = sp.user_id
                LEFT JOIN schools s ON sp.school_id = s.id
                WHERE u.type = 'student' AND u.status = 'active'
                ORDER BY u.name ASC";
        return $this->queryPublic($sql);
    }

    /**
     * Remove all roles from user
     */
    public function removeAllRoles(int $userId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM user_roles WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }

    /**
     * Public query method (wrapper for protected query)
     */
    public function queryPublic(string $sql, array $params = []): array
    {
        return $this->query($sql, $params);
    }

    /**
     * Public queryOne method (wrapper for protected queryOne)
     */
    public function queryOnePublic(string $sql, array $params = []): ?array
    {
        return $this->queryOne($sql, $params);
    }
}
