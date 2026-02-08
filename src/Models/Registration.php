<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Registration Model
 */
class Registration extends BaseModel
{
    protected string $table = 'registrations';

    /**
     * Get registrations by student
     */
    public function findByStudent(int $studentUserId): array
    {
        return $this->query("
            SELECT r.*, ce.year, c.name_ar as competition_name, c.code as competition_code
            FROM {$this->table} r
            INNER JOIN competition_editions ce ON r.competition_edition_id = ce.id
            INNER JOIN competitions c ON ce.competition_id = c.id
            WHERE r.student_user_id = ?
            ORDER BY r.created_at DESC
        ", [$studentUserId]);
    }

    /**
     * Get registrations by school
     */
    public function findBySchool(int $schoolId): array
    {
        return $this->query("
            SELECT r.*, ce.year, c.name_ar as competition_name, c.code,
                   u.name as student_name
            FROM {$this->table} r
            INNER JOIN competition_editions ce ON r.competition_edition_id = ce.id
            INNER JOIN competitions c ON ce.competition_id = c.id
            LEFT JOIN users u ON r.student_user_id = u.id
            WHERE r.school_id = ?
            ORDER BY r.created_at DESC
        ", [$schoolId]);
    }

    /**
     * Get registrations by edition
     */
    public function findByEdition(int $editionId, ?string $status = null): array
    {
        $sql = "
            SELECT r.*, u.name as student_name, s.name as school_name
            FROM {$this->table} r
            LEFT JOIN users u ON r.student_user_id = u.id
            LEFT JOIN schools s ON r.school_id = s.id
            WHERE r.competition_edition_id = ?
        ";
        
        $params = [$editionId];
        
        if ($status !== null) {
            $sql .= " AND r.status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY r.created_at DESC";
        
        return $this->query($sql, $params);
    }

    /**
     * Get registration details by ID
     */
    public function findWithDetails(int $id): ?array
    {
        return $this->queryOne("
            SELECT r.*, 
                   ce.year, ce.competition_start_date, ce.competition_end_date,
                   c.name_ar as competition_name, c.code as competition_code, c.description_ar as competition_description,
                   ct.name_ar as track_name,
                   u.name as student_name, u.email as student_email,
                   s.name as school_name
            FROM {$this->table} r
            INNER JOIN competition_editions ce ON r.competition_edition_id = ce.id
            INNER JOIN competitions c ON ce.competition_id = c.id
            LEFT JOIN competition_tracks ct ON r.track_id = ct.id
            LEFT JOIN users u ON r.student_user_id = u.id
            LEFT JOIN schools s ON r.school_id = s.id
            WHERE r.id = ?
        ", [$id]);
    }

    /**
     * Check if student already registered for edition
     */
    public function isStudentRegistered(int $studentUserId, int $editionId): bool
    {
        $result = $this->queryOne("
            SELECT COUNT(*) as count FROM {$this->table}
            WHERE student_user_id = ? AND competition_edition_id = ?
            AND status NOT IN ('cancelled', 'rejected')
        ", [$studentUserId, $editionId]);
        
        return $result && $result['count'] > 0;
    }

    /**
     * Update registration status
     */
    public function updateStatus(int $registrationId, string $status, ?string $notes = null): bool
    {
        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if ($notes !== null) {
            $data['notes'] = $notes;
        }
        
        return $this->update($registrationId, $data);
    }

    /**
     * Search registrations with filters
     */
    public function searchRegistrations(array $filters = []): array
    {
        $sql = "
            SELECT r.*, 
                   u.name as student_name, 
                   u.email as student_email,
                   s.name as school_name,
                   c.name_ar as competition_name,
                   ce.year as edition_year
            FROM {$this->table} r
            LEFT JOIN users u ON r.student_user_id = u.id
            LEFT JOIN schools s ON r.school_id = s.id
            INNER JOIN competition_editions ce ON r.competition_edition_id = ce.id
            INNER JOIN competitions c ON ce.competition_id = c.id
            WHERE 1=1
        ";
        
        $params = [];
        
        if (!empty($filters['status'])) {
            $sql .= " AND r.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['competition'])) {
            $sql .= " AND ce.id = ?";
            $params[] = $filters['competition'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND (u.name LIKE ? OR s.name LIKE ? OR u.email LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY r.created_at DESC LIMIT 100";
        
        return $this->query($sql, $params);
    }

    /**
     * Get registration statistics
     */
    public function getStatistics(): array
    {
        $result = $this->queryOne("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'submitted' THEN 1 ELSE 0 END) as submitted,
                SUM(CASE WHEN status = 'under_review' THEN 1 ELSE 0 END) as under_review,
                SUM(CASE WHEN status = 'accepted_training' THEN 1 ELSE 0 END) as accepted_training,
                SUM(CASE WHEN status = 'accepted_final' THEN 1 ELSE 0 END) as accepted_final,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
            FROM {$this->table}
        ");
        
        return $result ?: [
            'total' => 0,
            'submitted' => 0,
            'under_review' => 0,
            'accepted_training' => 0,
            'accepted_final' => 0,
            'rejected' => 0
        ];
    }
}

