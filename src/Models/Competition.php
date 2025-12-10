<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Competition Model
 */
class Competition extends BaseModel
{
    protected string $table = 'competitions';

    /**
     * Get active competitions
     */
    public function findActive(): array
    {
        // Get active competitions with their latest open edition
        $sql = "SELECT c.*, 
                       ce.id as latest_edition_id,
                       ce.year as latest_edition_year,
                       ce.status as latest_edition_status
                FROM {$this->table} c
                LEFT JOIN competition_editions ce ON c.id = ce.competition_id 
                    AND ce.status = 'open'
                    AND ce.year = (
                        SELECT MAX(year) 
                        FROM competition_editions 
                        WHERE competition_id = c.id AND status = 'open'
                    )
                WHERE c.is_active = 1
                ORDER BY c.created_at DESC";
        
        return $this->query($sql);
    }

    /**
     * Get competition with latest edition
     */
    public function findWithLatestEdition(int $competitionId): ?array
    {
        $competition = $this->findById($competitionId);
        if (!$competition) {
            return null;
        }
        
        $competition['latest_edition'] = $this->queryOne("
            SELECT * FROM competition_editions
            WHERE competition_id = ?
            ORDER BY year DESC
            LIMIT 1
        ", [$competitionId]);
        
        return $competition;
    }

    /**
     * Get competition by code
     */
    public function findByCode(string $code): ?array
    {
        return $this->findOne(['code' => $code]);
    }
}
