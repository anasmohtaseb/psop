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
}
