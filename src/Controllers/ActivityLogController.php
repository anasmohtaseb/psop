<?php

namespace App\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends \App\Core\Controller
{
    private ActivityLog $activityLogModel;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->activityLogModel = new ActivityLog($this->config);
    }

    /**
     * Admin: List all activity logs
     */
    public function index(): void
    {
        $this->requireRole('admin');

        $filters = [
            'user_id' => $_GET['user_id'] ?? '',
            'action' => $_GET['action'] ?? '',
            'entity_type' => $_GET['entity_type'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
            'search' => $_GET['search'] ?? ''
        ];

        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 50;
        $offset = ($page - 1) * $perPage;

        $logs = $this->activityLogModel->getActivityLogs($filters, $perPage, $offset);
        $statistics = $this->activityLogModel->getStatistics($filters);
        $actionBreakdown = $this->activityLogModel->getActionBreakdown(30);
        $mostActiveUsers = $this->activityLogModel->getMostActiveUsers(5, 30);

        $this->render('admin/activity-logs/index', [
            'logs' => $logs,
            'statistics' => $statistics,
            'actionBreakdown' => $actionBreakdown,
            'mostActiveUsers' => $mostActiveUsers,
            'filters' => $filters,
            'page' => $page,
            'perPage' => $perPage
        ], 'dashboard');
    }

    /**
     * View user's activity history
     */
    public function userActivity($userId): void
    {
        $this->requireAuth();

        $currentUser = $this->auth->user();
        $userId = (int) $userId;

        // Only admin or the user themselves can view activity
        if (!$this->auth->hasRole('admin') && $currentUser['id'] !== $userId) {
            $this->setFlash('error', 'غير مصرح لك بعرض هذه الصفحة');
            $this->redirect('/dashboard');
            return;
        }

        $logs = $this->activityLogModel->getUserActivityLogs($userId, 100);

        $this->render('activity-logs/user', [
            'logs' => $logs,
            'userId' => $userId
        ], 'dashboard');
    }

    /**
     * View entity activity history
     */
    public function entityActivity($entityType, $entityId): void
    {
        $this->requireRole('admin');

        $entityId = (int) $entityId;
        $logs = $this->activityLogModel->getEntityActivityLogs($entityType, $entityId);

        $this->render('activity-logs/entity', [
            'logs' => $logs,
            'entityType' => $entityType,
            'entityId' => $entityId
        ], 'dashboard');
    }

    /**
     * Export activity logs to CSV
     */
    public function export(): void
    {
        $this->requireRole('admin');

        $filters = [
            'user_id' => $_GET['user_id'] ?? '',
            'action' => $_GET['action'] ?? '',
            'entity_type' => $_GET['entity_type'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
            'search' => $_GET['search'] ?? ''
        ];

        $logs = $this->activityLogModel->getActivityLogs($filters, 10000, 0);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="activity_logs_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // BOM for UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Headers
        fputcsv($output, ['ID', 'User', 'User Type', 'Action', 'Entity Type', 'Entity ID', 'Description', 'IP Address', 'Date']);
        
        foreach ($logs as $log) {
            fputcsv($output, [
                $log['id'],
                $log['user_name'] ?? 'Guest',
                $log['user_type'],
                $log['action'],
                $log['entity_type'] ?? '',
                $log['entity_id'] ?? '',
                $log['description'] ?? '',
                $log['ip_address'] ?? '',
                $log['created_at']
            ]);
        }
        
        fclose($output);
        exit;
    }
}
