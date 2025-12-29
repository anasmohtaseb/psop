<?php

/**
 * Activity Log Helper Functions
 * Use these functions throughout the application to log activities
 */

use App\Models\ActivityLog;

/**
 * Log an activity
 * 
 * @param string $action Action name (e.g., 'login', 'create_user', 'update_competition')
 * @param string|null $description Arabic description of the action
 * @param string|null $entityType Type of entity (e.g., 'user', 'competition', 'registration')
 * @param int|null $entityId ID of the entity
 * @param array $metadata Additional data to store
 * @return int The log ID
 */
function logActivity(
    string $action,
    ?string $description = null,
    ?string $entityType = null,
    ?int $entityId = null,
    array $metadata = []
): int {
    static $activityLog = null;
    
    if ($activityLog === null) {
        $config = require __DIR__ . '/../../config/config.php';
        $activityLog = new ActivityLog($config);
    }
    
    $userId = $_SESSION['user_id'] ?? null;
    $userType = $_SESSION['user']['type'] ?? 'guest';
    
    return $activityLog->log([
        'user_id' => $userId,
        'user_type' => $userType,
        'action' => $action,
        'description' => $description,
        'entity_type' => $entityType,
        'entity_id' => $entityId,
        'metadata' => $metadata
    ]);
}

/**
 * Quick log functions for common actions
 */

function logLogin(int $userId, string $userName): int
{
    return logActivity('login', "تسجيل دخول المستخدم: {$userName}");
}

function logLogout(int $userId, string $userName): int
{
    return logActivity('logout', "تسجيل خروج المستخدم: {$userName}");
}

function logCreate(string $entityType, int $entityId, string $description): int
{
    return logActivity('create', $description, $entityType, $entityId);
}

function logUpdate(string $entityType, int $entityId, string $description): int
{
    return logActivity('update', $description, $entityType, $entityId);
}

function logDelete(string $entityType, int $entityId, string $description): int
{
    return logActivity('delete', $description, $entityType, $entityId);
}
