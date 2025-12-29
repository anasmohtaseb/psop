<?php

namespace App\Models;

class ActivityLog extends BaseModel
{
    protected string $table = 'activity_logs';

    /**
     * Log an activity
     */
    public function log(array $data): int
    {
        $logData = [
            'user_id' => $data['user_id'] ?? null,
            'user_type' => $data['user_type'] ?? 'guest',
            'action' => $data['action'],
            'entity_type' => $data['entity_type'] ?? null,
            'entity_id' => $data['entity_id'] ?? null,
            'description' => $data['description'] ?? null,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'metadata' => isset($data['metadata']) ? json_encode($data['metadata']) : null
        ];

        return $this->create($logData);
    }

    /**
     * Get activity logs with filters
     */
    public function getActivityLogs(array $filters = [], int $limit = 50, int $offset = 0): array
    {
        $sql = "SELECT al.*, u.name as user_name, u.email as user_email 
                FROM {$this->table} al
                LEFT JOIN users u ON al.user_id = u.id
                WHERE 1=1";
        
        $params = [];

        // Filter by user
        if (!empty($filters['user_id'])) {
            $sql .= " AND al.user_id = ?";
            $params[] = $filters['user_id'];
        }

        // Filter by action
        if (!empty($filters['action'])) {
            $sql .= " AND al.action = ?";
            $params[] = $filters['action'];
        }

        // Filter by entity type
        if (!empty($filters['entity_type'])) {
            $sql .= " AND al.entity_type = ?";
            $params[] = $filters['entity_type'];
        }

        // Filter by date range
        if (!empty($filters['date_from'])) {
            $sql .= " AND DATE(al.created_at) >= ?";
            $params[] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= " AND DATE(al.created_at) <= ?";
            $params[] = $filters['date_to'];
        }

        // Search in description
        if (!empty($filters['search'])) {
            $sql .= " AND (al.description LIKE ? OR u.name LIKE ? OR u.email LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        $sql .= " ORDER BY al.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        return $this->query($sql, $params);
    }

    /**
     * Get activity logs for a specific user
     */
    public function getUserActivityLogs(int $userId, int $limit = 50): array
    {
        return $this->getActivityLogs(['user_id' => $userId], $limit);
    }

    /**
     * Get activity logs for a specific entity
     */
    public function getEntityActivityLogs(string $entityType, int $entityId, int $limit = 50): array
    {
        return $this->getActivityLogs(['entity_type' => $entityType, 'entity_id' => $entityId], $limit);
    }

    /**
     * Get recent activities
     */
    public function getRecentActivities(int $limit = 20): array
    {
        return $this->getActivityLogs([], $limit);
    }

    /**
     * Get activity statistics
     */
    public function getStatistics(array $filters = []): array
    {
        $sql = "SELECT 
                COUNT(*) as total_activities,
                COUNT(DISTINCT user_id) as unique_users,
                COUNT(DISTINCT action) as unique_actions,
                COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN 1 END) as today_count,
                COUNT(CASE WHEN DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 END) as week_count,
                COUNT(CASE WHEN DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) THEN 1 END) as month_count
                FROM {$this->table}
                WHERE 1=1";
        
        $params = [];

        if (!empty($filters['date_from'])) {
            $sql .= " AND DATE(created_at) >= ?";
            $params[] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= " AND DATE(created_at) <= ?";
            $params[] = $filters['date_to'];
        }

        $result = $this->queryOne($sql, $params);
        return $result ?? [
            'total_activities' => 0,
            'unique_users' => 0,
            'unique_actions' => 0,
            'today_count' => 0,
            'week_count' => 0,
            'month_count' => 0
        ];
    }

    /**
     * Get activity breakdown by action
     */
    public function getActionBreakdown(int $days = 30): array
    {
        $sql = "SELECT action, COUNT(*) as count
                FROM {$this->table}
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
                GROUP BY action
                ORDER BY count DESC
                LIMIT 10";
        
        return $this->query($sql, [$days]);
    }

    /**
     * Get most active users
     */
    public function getMostActiveUsers(int $limit = 10, int $days = 30): array
    {
        $sql = "SELECT al.user_id, u.name as user_name, u.email as user_email, 
                       u.type as user_type, COUNT(*) as activity_count
                FROM {$this->table} al
                LEFT JOIN users u ON al.user_id = u.id
                WHERE al.created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
                  AND al.user_id IS NOT NULL
                GROUP BY al.user_id, u.name, u.email, u.type
                ORDER BY activity_count DESC
                LIMIT ?";
        
        return $this->query($sql, [$days, $limit]);
    }

    /**
     * Clean old logs (optional - for maintenance)
     */
    public function cleanOldLogs(int $daysToKeep = 365): int
    {
        $sql = "DELETE FROM {$this->table} 
                WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$daysToKeep]);
        
        return $stmt->rowCount();
    }
}
