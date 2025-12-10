<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Registration;
use App\Models\CompetitionEdition;
use App\Models\StudentProfile;
use App\Models\UserSubscription;

/**
 * Registration Controller
 * Handle student registrations for competitions
 */
class RegistrationController extends Controller
{
    /**
     * Student: View my registrations
     */
    public function myRegistrations(): void
    {
        $this->requireAuth();
        
        if (!$this->auth->isStudent()) {
            $this->setFlash('error', 'هذه الصفحة متاحة للطلاب فقط');
            $this->redirect('/dashboard');
        }
        
        $registrationModel = new Registration($this->config);
        $registrations = $registrationModel->findByStudent($this->auth->id());
        
        $this->render('dashboard/registrations/index', [
            'registrations' => $registrations,
        ]);
    }

    /**
     * Show registration form
     */
    public function create(string $editionId): void
    {
        $this->requireAuth();
        
        $editionModel = new CompetitionEdition($this->config);
        $edition = $editionModel->findWithTracks((int)$editionId);
        
        if (!$edition) {
            $this->setFlash('error', 'النسخة غير موجودة');
            $this->redirect('/dashboard');
            return;
        }
        
        // Check if student
        if (!$this->auth->isStudent()) {
            $this->setFlash('error', 'التسجيل متاح للطلاب فقط');
            $this->redirect('/dashboard');
            return;
        }
        
        // Check if user has active subscription
        $subscriptionModel = new UserSubscription($this->config);
        if (!$subscriptionModel->hasActiveSubscription($this->auth->id())) {
            $this->setFlash('error', 'يجب أن يكون لديك اشتراك نشط للتسجيل في المسابقات');
            $this->redirect('/subscriptions/plans');
            return;
        }
        
        // Check if already registered
        $registrationModel = new Registration($this->config);
        if ($registrationModel->isStudentRegistered($this->auth->id(), (int)$editionId)) {
            $this->setFlash('error', 'أنت مسجل بالفعل في هذه المسابقة');
            $this->redirect('/dashboard');
            return;
        }
        
        $profileModel = new StudentProfile($this->config);
        $profile = $profileModel->findWithUser($this->auth->id());
        
        $this->render('registrations/create', [
            'edition' => $edition,
            'profile' => $profile,
            'csrf_token' => $this->generateCsrfToken(),
        ]);
    }

    /**
     * Store registration
     */
    public function store(): void
    {
        $this->requireAuth();
        
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'رمز الحماية غير صحيح');
            $this->redirect('/dashboard');
        }
        
        if (!$this->auth->isStudent()) {
            $this->setFlash('error', 'التسجيل متاح للطلاب فقط');
            $this->redirect('/dashboard');
        }
        
        $editionId = (int)$_POST['competition_edition_id'];
        
        // Check if already registered
        $registrationModel = new Registration($this->config);
        if ($registrationModel->isStudentRegistered($this->auth->id(), $editionId)) {
            $this->setFlash('error', 'أنت مسجل بالفعل في هذه المسابقة');
            $this->redirect('/dashboard');
        }
        
        // Get student profile to get school_id
        $profileModel = new StudentProfile($this->config);
        $profile = $profileModel->findById($this->auth->id());
        
        try {
            $registrationModel->create([
                'competition_edition_id' => $editionId,
                'student_user_id' => $this->auth->id(),
                'school_id' => $profile['school_id'],
                'registration_type' => 'individual',
                'status' => 'submitted',
                'notes' => $_POST['notes'] ?? null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            
            $this->setFlash('success', 'تم إرسال طلب التسجيل بنجاح');
            $this->redirect('/dashboard');
        } catch (\Exception $e) {
            $this->setFlash('error', 'حدث خطأ أثناء التسجيل');
            $this->redirect('/registrations/create/' . $editionId);
        }
    }

    /**
     * Admin: View all registrations for an edition
     */
    public function adminIndex(string $editionId): void
    {
        $this->requireRole('admin');
        
        $registrationModel = new Registration($this->config);
        $registrations = $registrationModel->findByEdition((int)$editionId);
        
        $editionModel = new CompetitionEdition($this->config);
        $edition = $editionModel->findById((int)$editionId);
        
        $this->render('admin/registrations/index', [
            'edition' => $edition,
            'registrations' => $registrations,
        ]);
    }

    /**
     * Admin: View all registrations across all competitions
     */
    public function adminList(): void
    {
        $this->requireRole('admin');
        
        $registrationModel = new Registration($this->config);
        
        // Get filters
        $filters = [
            'status' => $_GET['status'] ?? '',
            'competition' => $_GET['competition'] ?? '',
            'search' => $_GET['search'] ?? '',
        ];
        
        // Get all registrations with filters
        $registrations = $registrationModel->searchRegistrations($filters);
        
        // Get statistics
        $stats = $registrationModel->getStatistics();
        
        // Get all competitions for filter dropdown
        $competitionModel = new CompetitionEdition($this->config);
        $competitions = $competitionModel->findAll();
        
        $this->render('admin/registrations/list', [
            'registrations' => $registrations,
            'stats' => $stats,
            'competitions' => $competitions,
            'filters' => $filters,
        ]);
    }

    /**
     * Admin: Update registration status
     */
    public function updateStatus(string $id): void
    {
        $this->requireRole('admin');
        
        if (!$this->validateCsrfToken()) {
            $this->json(['success' => false, 'message' => 'رمز الحماية غير صحيح'], 400);
        }
        
        $registrationModel = new Registration($this->config);
        $status = $_POST['status'] ?? '';
        $notes = $_POST['notes'] ?? null;
        
        $validStatuses = ['draft', 'submitted', 'under_review', 'accepted_training', 'accepted_final', 'rejected', 'cancelled'];
        
        if (!in_array($status, $validStatuses)) {
            $this->json(['success' => false, 'message' => 'حالة غير صحيحة'], 400);
        }
        
        try {
            $registrationModel->updateStatus((int)$id, $status, $notes);
            $this->json(['success' => true, 'message' => 'تم تحديث الحالة بنجاح']);
        } catch (\Exception $e) {
            $this->json(['success' => false, 'message' => 'حدث خطأ أثناء التحديث'], 500);
        }
    }

    /**
     * Admin: Show create registration form
     */
    public function adminCreate(): void
    {
        $this->requireRole('admin');
        
        // Get all active competition editions
        $editionModel = new CompetitionEdition($this->config);
        $editions = $editionModel->findAll(['status' => 'active']);
        
        // Get all students
        $userModel = new \App\Models\User($this->config);
        $students = $userModel->findAllStudents();
        
        // Get all schools
        $schoolModel = new \App\Models\School($this->config);
        $schools = $schoolModel->findAll(['status' => 'active']);
        
        $this->render('admin/registrations/create', [
            'editions' => $editions,
            'students' => $students,
            'schools' => $schools,
            'csrf_token' => $this->generateCsrfToken(),
        ]);
    }

    /**
     * Admin: Store new registration
     */
    public function adminStore(): void
    {
        $this->requireRole('admin');
        
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'رمز الحماية غير صحيح');
            $this->redirect('/admin/registrations/create');
        }
        
        $registrationModel = new Registration($this->config);
        
        try {
            $registrationModel->create([
                'competition_edition_id' => $_POST['competition_edition_id'],
                'student_user_id' => $_POST['student_user_id'] ?? null,
                'school_id' => $_POST['school_id'],
                'registration_type' => $_POST['registration_type'] ?? 'individual',
                'status' => $_POST['status'] ?? 'submitted',
                'notes' => $_POST['notes'] ?? null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            
            $this->setFlash('success', 'تم إضافة التسجيل بنجاح');
            $this->redirect('/admin/registrations');
        } catch (\Exception $e) {
            $this->setFlash('error', 'حدث خطأ أثناء إضافة التسجيل');
            $_SESSION['old'] = $_POST;
            $this->redirect('/admin/registrations/create');
        }
    }
}

