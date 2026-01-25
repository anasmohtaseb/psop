<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Registration;
use App\Models\CompetitionEdition;
use App\Models\Announcement;
use App\Models\School;
use App\Models\UserSubscription;
use App\Models\SiteSetting;

/**
 * Dashboard Controller
 * Handles different dashboard views based on user type
 */
class DashboardController extends Controller
{
    /**
     * Main dashboard - routes to appropriate dashboard based on user type
     */
    public function index(): void
    {
        $this->requireAuth();
        
        $user = $this->auth->user();
        
        match ($user['type']) {
            'student' => $this->studentDashboard(),
            'school_coordinator' => $this->schoolDashboard(),
            'admin', 'competition_manager' => $this->adminDashboard(),
            default => $this->render('dashboard/index', ['user' => $user]),
        };
    }

    /**
     * Student dashboard
     */
    private function studentDashboard(): void
    {
        $registrationModel = new Registration($this->config);
        $editionModel = new CompetitionEdition($this->config);
        $announcementModel = new Announcement($this->config);
        
        $myRegistrations = $registrationModel->findByStudent($this->auth->id());
        $openCompetitions = $editionModel->findOpenForRegistration();
        $announcements = $announcementModel->findPublished('student');
        
        // Get subscription status only if subscriptions are enabled
        $subscriptionStatus = null;
        $settingModel = new SiteSetting($this->config);
        
        if ($settingModel->getValue('enable_subscriptions', '1') === '1') {
            $subscriptionModel = new UserSubscription($this->config);
            $activeSubscription = $subscriptionModel->getActiveSubscription($this->auth->id());
            
            if ($activeSubscription) {
                $endDate = new \DateTime($activeSubscription['end_date']);
                $today = new \DateTime();
                $daysRemaining = $today->diff($endDate)->days;
                
                $subscriptionStatus = [
                    'has_active' => true,
                    'plan_name' => $activeSubscription['plan_name'],
                    'end_date' => $activeSubscription['end_date'],
                    'days_remaining' => $daysRemaining
                ];
            } else {
                $subscriptionStatus = [
                    'has_active' => false
                ];
            }
        }
        
        $this->render('dashboard/student', [
            'user' => $this->auth->user(),
            'registrations' => $myRegistrations,
            'open_competitions' => $openCompetitions,
            'announcements' => array_slice($announcements, 0, 5),
            'subscription_status' => $subscriptionStatus,
        ]);
    }

    /**
     * School coordinator dashboard
     */
    private function schoolDashboard(): void
    {
        $user = $this->auth->user();
        
        // Get school ID for this coordinator
        $schoolModel = new School($this->config);
        $schoolData = $this->getCoordinatorSchool();
        
        if (!$schoolData) {
            $this->setFlash('error', 'لم يتم العثور على المدرسة المرتبطة بحسابك');
            $this->render('dashboard/index', ['user' => $user]);
            return;
        }
        
        $students = $schoolModel->getStudents($schoolData['id']);
        
        $registrationModel = new Registration($this->config);
        $registrations = $registrationModel->findBySchool($schoolData['id']);
        
        $editionModel = new CompetitionEdition($this->config);
        $openCompetitions = $editionModel->findOpenForRegistration();
        
        $announcementModel = new Announcement($this->config);
        $announcements = $announcementModel->findPublished('school_coordinator');
        
        $this->render('dashboard/school', [
            'user' => $user,
            'school' => $schoolData,
            'students' => $students,
            'registrations' => $registrations,
            'open_competitions' => $openCompetitions,
            'announcements' => array_slice($announcements, 0, 5),
        ]);
    }

    /**
     * Admin dashboard
     */
    private function adminDashboard(): void
    {
        $userModel = new \App\Models\User($this->config);
        $schoolModel = new School($this->config);
        $registrationModel = new Registration($this->config);
        
        $stats = [
            'total_users' => $userModel->count(['status' => 'active']),
            'total_students' => $userModel->count(['type' => 'student', 'status' => 'active']),
            'total_schools' => $schoolModel->count(['status' => 'active']),
            'pending_registrations' => $registrationModel->count(['status' => 'submitted']),
        ];
        
        $this->render('dashboard/admin', [
            'user' => $this->auth->user(),
            'stats' => $stats,
        ]);
    }

    /**
     * Get school for current coordinator
     */
    private function getCoordinatorSchool(): ?array
    {
        $sql = "
            SELECT s.* FROM schools s
            INNER JOIN school_users su ON s.id = su.school_id
            WHERE su.user_id = ? AND su.role = 'coordinator'
            LIMIT 1
        ";
        
        require_once $this->config['paths']['root'] . '/config/database.php';
        $db = getDatabase($this->config);
        $stmt = $db->prepare($sql);
        $stmt->execute([$this->auth->id()]);
        $result = $stmt->fetch();
        
        return $result ?: null;
    }
}
