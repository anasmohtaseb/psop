<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Competition Edition Model
 */
class CompetitionEdition extends BaseModel
{
    protected string $table = 'competition_editions';

    /**
     * Get editions by competition
     */
    public function findByCompetition(int $competitionId): array
    {
        return $this->query("
            SELECT ce.*, c.name_ar, c.name_en, c.code
            FROM {$this->table} ce
            INNER JOIN competitions c ON ce.competition_id = c.id
            WHERE ce.competition_id = ?
            ORDER BY ce.year DESC
        ", [$competitionId]);
    }

    /**
     * Get currently open editions (registration period)
     */
    public function findOpenForRegistration(): array
    {
        return $this->query("
            SELECT ce.*, c.name_ar, c.name_en, c.code, c.category
            FROM {$this->table} ce
            INNER JOIN competitions c ON ce.competition_id = c.id
            WHERE ce.status = 'open'
            AND ce.registration_start_date <= CURDATE()
            AND ce.registration_end_date >= CURDATE()
            AND c.is_active = 1
            ORDER BY ce.registration_end_date ASC
        ");
    }

    /**
     * Get edition with tracks
     */
    public function findWithTracks(int $editionId): ?array
    {
        $edition = $this->findById($editionId);
        if (!$edition) {
            return null;
        }
        
        $edition['tracks'] = $this->query("
            SELECT * FROM competition_tracks
            WHERE competition_edition_id = ?
            ORDER BY name_ar
        ", [$editionId]);
        
        return $edition;
    }
}
