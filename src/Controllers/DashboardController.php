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

    /**
     * Show user profile
     */
    public function profile(): void
    {
        $this->requireAuth();
        $user = $this->auth->user();
        $data = ['user' => $user];

        if ($this->auth->isStudent()) {
             $profileModel = new \App\Models\StudentProfile($this->config);
             $data['profile'] = $profileModel->findWithUser($user['id']);
             
             // Get schools list for dropdown
             $schoolModel = new \App\Models\School($this->config);
             $data['schools'] = $schoolModel->findAll(['status' => 'active'], 1000, 0);
        }

        $this->render('dashboard/profile', $data);
    }

    /**
     * Update user profile
     */
    public function updateProfile(): void
    {
        $this->requireAuth();
        
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'رمز الحماية غير صحيح');
            $this->redirect('/dashboard/profile');
        }

        $userId = $this->auth->id();
        $userModel = new \App\Models\User($this->config);
        
        // Update basic user info
        $userData = [
            'name' => $_POST['name'] ?? '',
            'phone' => $_POST['phone'] ?? '',
        ];
        
        // Handle password change if provided
        if (!empty($_POST['password'])) {
            if (strlen($_POST['password']) < 8) {
                $this->setFlash('error', 'كلمة المرور يجب أن تكون 8 أحرف على الأقل');
                $this->redirect('/dashboard/profile');
            }
            $userData['password_hash'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        try {
            $userModel->update($userId, $userData);
            
            // Update session user data
            $user = $userModel->findById($userId);
            $_SESSION['user'] = $user;

            // Update student profile if student
            if ($this->auth->isStudent()) {
                if (empty($_POST['school_id'])) {
                    throw new \Exception('يجب اختيار المدرسة');
                }

                $profileModel = new \App\Models\StudentProfile($this->config);
                $profileData = [
                    'gender' => $_POST['gender'] ?? 'male',
                    'date_of_birth' => !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : date('Y-m-d'),
                    'grade' => !empty($_POST['grade']) ? (int)$_POST['grade'] : 10,
                    'school_id' => (int)$_POST['school_id'],
                    'guardian_name' => $_POST['guardian_name'] ?? '',
                    'guardian_phone' => $_POST['guardian_phone'] ?? '',
                    'guardian_email' => $_POST['guardian_email'] ?? '',
                ];
                
                // Check if profile exists, if not create it
                if ($profileModel->findById($userId)) {
                    $profileModel->update($userId, $profileData);
                } else {
                    $profileData['user_id'] = $userId;
                    $profileModel->create($profileData);
                }
            }

            $this->setFlash('success', 'تم تحديث الملف الشخصي بنجاح');
        } catch (\Exception $e) {
            $this->setFlash('error', 'حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }

        $this->redirect('/dashboard/profile');
    }
}
