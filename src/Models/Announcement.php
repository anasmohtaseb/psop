<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Announcement Model
 */
class Announcement extends BaseModel
{
    protected string $table = 'announcements';

    /**
     * Get published announcements
     */
    public function findPublished(?string $targetAudience = null): array
    {
        $sql = "
            SELECT * FROM {$this->table}
            WHERE status = 'published'
            AND (publish_date IS NULL OR publish_date <= CURDATE())
        ";
        
        $params = [];
        
        if ($targetAudience !== null) {
            $sql .= " AND (target_audience = 'all' OR target_audience = ?)";
            $params[] = $targetAudience;
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        return $this->query($sql, $params);
    }
}
