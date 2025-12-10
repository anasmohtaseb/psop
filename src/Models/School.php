<?php

declare(strict_types=1);

namespace App\Models;

/**
 * School Model
 */
class School extends BaseModel
{
    protected string $table = 'schools';

    /**
     * Get schools by governorate
     */
    public function findByGovernorate(string $governorate): array
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE governorate = ? AND status = 'active' ORDER BY name",
            [$governorate]
        );
    }

    /**
     * Get school with coordinators
     */
    public function findWithCoordinators(int $schoolId): ?array
    {
        $school = $this->findById($schoolId);
        if (!$school) {
            return null;
        }
        
        $school['coordinators'] = $this->query("
            SELECT u.* FROM users u
            INNER JOIN school_users su ON u.id = su.user_id
            WHERE su.school_id = ? AND su.role = 'coordinator' AND u.status = 'active'
        ", [$schoolId]);
        
        return $school;
    }

    /**
     * Link coordinator to school
     */
    public function addCoordinator(int $schoolId, int $userId): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO school_users (school_id, user_id, role, created_at)
            VALUES (?, ?, 'coordinator', ?)
        ");
        return $stmt->execute([$schoolId, $userId, date('Y-m-d H:i:s')]);
    }

    /**
     * Get students of a school
     */
    public function getStudents(int $schoolId): array
    {
        return $this->query("
            SELECT u.*, sp.grade, sp.date_of_birth
            FROM users u
            INNER JOIN students_profile sp ON u.id = sp.user_id
            WHERE sp.school_id = ? AND u.status = 'active'
            ORDER BY sp.grade DESC, u.name
        ", [$schoolId]);
    }

    /**
     * Search schools with filters
     */
    public function searchSchools(array $filters = []): array
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

        if (!empty($filters['governorate'])) {
            $where[] = 'governorate = ?';
            $params[] = $filters['governorate'];
        }

        if (!empty($filters['search'])) {
            $where[] = '(name LIKE ? OR city LIKE ?)';
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $sql .= ' ORDER BY name ASC';

        return $this->queryPublic($sql, $params);
    }

    /**
     * Get school statistics
     */
    public function getStatistics(): array
    {
        $stats = [];
        
        $stats['total'] = $this->countSchools();
        $stats['active'] = $this->countSchools(['status' => 'active']);
        $stats['pending'] = $this->countSchools(['status' => 'pending']);
        
        return $stats;
    }

    /**
     * Count schools with filters
     */
    public function countSchools(array $filters = []): int
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
