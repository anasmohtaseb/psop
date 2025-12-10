<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Subscription Plan Model
 */
class SubscriptionPlan extends BaseModel
{
    protected string $table = 'subscription_plans';

    /**
     * Get active plans by user type
     */
    public function findActiveByType(string $userType): array
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE user_type = ? AND is_active = 1 
                ORDER BY price ASC";
        return $this->query($sql, [$userType]);
    }

    /**
     * Get plan features as array
     */
    public function getFeaturesArray(array $plan): array
    {
        if (empty($plan['features'])) {
            return [];
        }
        
        $features = json_decode($plan['features'], true);
        return is_array($features) ? $features : [];
    }
}
