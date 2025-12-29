<?php

namespace App\Models;

use App\Models\BaseModel;

class CompetitionImage extends BaseModel
{
    protected string $table = 'competition_images';
    protected string $primaryKey = 'id';

    public function findByCompetition(int $competitionId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE competition_id = ? ORDER BY sort_order, created_at";
        return $this->query($sql, [$competitionId]);
    }

    /**
     * Find recent images across competitions
     */
    public function findRecent(int $limit = 8): array
    {
        $limit = (int)$limit;
        $sql = "SELECT ci.*, c.name_ar AS competition_name, c.id AS competition_id
                FROM {$this->table} ci
                LEFT JOIN competitions c ON ci.competition_id = c.id
                ORDER BY ci.created_at DESC
                LIMIT {$limit}";
        return $this->query($sql);
    }

    /**
     * Find featured images across competitions for homepage
     */
    public function findFeatured(int $limit = 8): array
    {
        $limit = (int)$limit;
        $sql = "SELECT ci.*, c.name_ar AS competition_name, c.id AS competition_id
                FROM {$this->table} ci
                LEFT JOIN competitions c ON ci.competition_id = c.id
                WHERE ci.is_featured = 1
                ORDER BY ci.sort_order ASC, ci.created_at DESC
                LIMIT {$limit}";
        return $this->query($sql);
    }

    /**
     * Set featured flag for an image
     */
    public function setFeatured(int $id, bool $flag): bool
    {
        $sql = "UPDATE {$this->table} SET is_featured = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$flag ? 1 : 0, $id]);
    }
}
