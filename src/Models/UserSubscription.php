<?php

declare(strict_types=1);

namespace App\Models;

/**
 * User Subscription Model
 */
class UserSubscription extends BaseModel
{
    protected string $table = 'user_subscriptions';

    /**
     * Get active subscription for user
     */
    public function getActiveSubscription(int $userId): ?array
    {
        $sql = "SELECT us.*, sp.name_ar as plan_name, sp.name_en as plan_name_en 
                FROM {$this->table} us
                INNER JOIN subscription_plans sp ON us.plan_id = sp.id
                WHERE us.user_id = ? 
                AND us.status = 'active'
                AND us.end_date >= CURDATE()
                ORDER BY us.end_date DESC
                LIMIT 1";
        
        return $this->queryOne($sql, [$userId]);
    }

    /**
     * Check if user has active subscription
     */
    public function hasActiveSubscription(int $userId): bool
    {
        $subscription = $this->getActiveSubscription($userId);
        return $subscription !== null;
    }

    /**
     * Get user's subscription history
     */
    public function getUserSubscriptions(int $userId): array
    {
        $sql = "SELECT us.*, sp.name_ar as plan_name, sp.price 
                FROM {$this->table} us
                INNER JOIN subscription_plans sp ON us.plan_id = sp.id
                WHERE us.user_id = ?
                ORDER BY us.created_at DESC";
        
        return $this->query($sql, [$userId]);
    }

    /**
     * Create new subscription
     */
    public function createSubscription(int $userId, int $planId, int $durationMonths): int
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime("+{$durationMonths} months"));
        
        return $this->create([
            'user_id' => $userId,
            'plan_id' => $planId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Activate subscription (after payment)
     */
    public function activateSubscription(int $subscriptionId, array $paymentData): bool
    {
        return $this->update($subscriptionId, [
            'status' => 'active',
            'payment_status' => 'paid',
            'payment_method' => $paymentData['method'] ?? null,
            'payment_reference' => $paymentData['reference'] ?? null,
            'payment_date' => date('Y-m-d H:i:s'),
            'amount_paid' => $paymentData['amount'] ?? null,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Get all subscriptions with filters (for admin)
     */
    public function searchSubscriptions(array $filters = []): array
    {
        $sql = "SELECT us.*, 
                       u.name as user_name, 
                       u.email as user_email,
                       u.type as user_type,
                       sp.name_ar as plan_name,
                       sp.price
                FROM {$this->table} us
                INNER JOIN users u ON us.user_id = u.id
                INNER JOIN subscription_plans sp ON us.plan_id = sp.id
                WHERE 1=1";
        
        $params = [];
        
        if (!empty($filters['status'])) {
            $sql .= " AND us.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['payment_status'])) {
            $sql .= " AND us.payment_status = ?";
            $params[] = $filters['payment_status'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND (u.name LIKE ? OR u.email LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY us.created_at DESC LIMIT 100";
        
        return $this->query($sql, $params);
    }

    /**
     * Get subscription statistics
     */
    public function getStatistics(): array
    {
        $result = $this->queryOne("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'expired' THEN 1 ELSE 0 END) as expired,
                SUM(CASE WHEN payment_status = 'paid' THEN amount_paid ELSE 0 END) as total_revenue
            FROM {$this->table}
        ");
        
        return $result ?: [
            'total' => 0,
            'active' => 0,
            'pending' => 0,
            'expired' => 0,
            'total_revenue' => 0
        ];
    }

    /**
     * Update expired subscriptions
     */
    public function updateExpiredSubscriptions(): int
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table} 
            SET status = 'expired', updated_at = NOW()
            WHERE status = 'active' 
            AND end_date < CURDATE()
        ");
        
        $stmt->execute();
        return $stmt->rowCount();
    }
}
