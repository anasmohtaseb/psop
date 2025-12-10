<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Team Model
 */
class Team extends BaseModel
{
    protected string $table = 'teams';

    /**
     * Get team with members
     */
    public function findWithMembers(int $teamId): ?array
    {
        $team = $this->findById($teamId);
        if (!$team) {
            return null;
        }
        
        $team['members'] = $this->query("
            SELECT tm.*, u.name, u.email
            FROM team_members tm
            INNER JOIN users u ON tm.user_id = u.id
            WHERE tm.team_id = ?
            ORDER BY tm.role DESC, u.name
        ", [$teamId]);
        
        return $team;
    }

    /**
     * Add member to team
     */
    public function addMember(int $teamId, int $userId, string $role = 'member'): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO team_members (team_id, user_id, role, created_at)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$teamId, $userId, $role, date('Y-m-d H:i:s')]);
    }

    /**
     * Remove member from team
     */
    public function removeMember(int $teamId, int $userId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM team_members WHERE team_id = ? AND user_id = ?");
        return $stmt->execute([$teamId, $userId]);
    }
}
