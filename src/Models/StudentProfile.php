<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Student Profile Model
 */
class StudentProfile extends BaseModel
{
    protected string $table = 'students_profile';
    protected string $primaryKey = 'user_id';

    /**
     * Get student with user data
     */
    public function findWithUser(int $userId): ?array
    {
        return $this->queryOne("
            SELECT sp.*, u.name, u.email, u.phone, s.name as school_name
            FROM {$this->table} sp
            INNER JOIN users u ON sp.user_id = u.id
            LEFT JOIN schools s ON sp.school_id = s.id
            WHERE sp.user_id = ?
        ", [$userId]);
    }

    /**
     * Get students by school
     */
    public function findBySchool(int $schoolId): array
    {
        return $this->query("
            SELECT sp.*, u.name, u.email, u.phone
            FROM {$this->table} sp
            INNER JOIN users u ON sp.user_id = u.id
            WHERE sp.school_id = ? AND u.status = 'active'
            ORDER BY sp.grade DESC, u.name
        ", [$schoolId]);
    }
}
