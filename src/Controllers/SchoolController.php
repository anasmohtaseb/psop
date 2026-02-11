<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\School;

class SchoolController extends Controller
{
    private School $schoolModel;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->schoolModel = new School($config);
    }

    /**
     * Display list of all schools (admin only)
     */
    public function index(): void
    {
        $this->requireRole('admin');

        // Get filter parameters
        $filters = [
            'type' => $_GET['type'] ?? '',
            'status' => $_GET['status'] ?? '',
            'governorate' => $_GET['governorate'] ?? '',
            'search' => $_GET['search'] ?? ''
        ];

        // Get schools with filters
        $schools = $this->schoolModel->searchSchools($filters);

        // Get statistics
        $stats = $this->schoolModel->getStatistics();

        $this->render('admin/schools/index', [
            'schools' => $schools,
            'totalSchools' => $stats['total'],
            'activeSchools' => $stats['active'],
            'pendingSchools' => $stats['pending'],
            'filters' => $filters
        ], 'dashboard');
    }

    /**
     * Show create school form
     */
    public function create(): void
    {
        $this->requireRole('admin');

        $this->render('admin/schools/create', [
            'csrf_token' => $this->generateCsrfToken()
        ], 'dashboard');
    }

    /**
     * Store new school
     */
    public function store(): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();

        // Validate input
        $errors = [];

        if (empty($_POST['name'])) {
            $errors['name'] = 'اسم المدرسة مطلوب';
        }

        if (empty($_POST['type'])) {
            $errors['type'] = 'نوع المدرسة مطلوب';
        } elseif (!in_array($_POST['type'], ['government', 'private', 'unrwa'])) {
            $errors['type'] = 'نوع المدرسة غير صحيح';
        }

        if (empty($_POST['governorate'])) {
            $errors['governorate'] = 'المحافظة مطلوبة';
        }

        if (empty($_POST['city'])) {
            $errors['city'] = 'المدينة مطلوبة';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            $this->redirect('/admin/schools/create');
            return;
        }

        // Create school
        $this->schoolModel->create([
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'governorate' => $_POST['governorate'],
            'city' => $_POST['city'],
            'address' => $_POST['address'] ?? null,
            'contact_phone' => $_POST['contact_phone'] ?? null,
            'contact_email' => $_POST['contact_email'] ?? null,
            'status' => $_POST['status'] ?? 'active'
        ]);

        $this->setFlash('success', 'تم إضافة المدرسة بنجاح');
        $this->redirect('/admin/schools');
    }

    /**
     * Show edit school form
     */
    public function edit(string $id): void
    {
        $this->requireRole('admin');

        $school = $this->schoolModel->findById((int)$id);

        if (!$school) {
            $this->setFlash('error', 'المدرسة غير موجودة');
            $this->redirect('/admin/schools');
            return;
        }

        $this->render('admin/schools/edit', [
            'school' => $school,
            'csrf_token' => $this->generateCsrfToken()
        ], 'dashboard');
    }

    /**
     * Update school
     */
    public function update(string $id): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();

        $school = $this->schoolModel->findById((int)$id);

        if (!$school) {
            $this->setFlash('error', 'المدرسة غير موجودة');
            $this->redirect('/admin/schools');
            return;
        }

        // Validate input
        $errors = [];

        if (empty($_POST['name'])) {
            $errors['name'] = 'اسم المدرسة مطلوب';
        }

        if (empty($_POST['type'])) {
            $errors['type'] = 'نوع المدرسة مطلوب';
        } elseif (!in_array($_POST['type'], ['government', 'private', 'unrwa'])) {
            $errors['type'] = 'نوع المدرسة غير صحيح';
        }

        if (empty($_POST['governorate'])) {
            $errors['governorate'] = 'المحافظة مطلوبة';
        }

        if (empty($_POST['city'])) {
            $errors['city'] = 'المدينة مطلوبة';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            $this->redirect('/admin/schools/' . $id . '/edit');
            return;
        }

        // Update school
        $this->schoolModel->update((int)$id, [
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'governorate' => $_POST['governorate'],
            'city' => $_POST['city'],
            'address' => $_POST['address'] ?? null,
            'contact_phone' => $_POST['contact_phone'] ?? null,
            'contact_email' => $_POST['contact_email'] ?? null,
            'status' => $_POST['status'] ?? 'active'
        ]);

        $this->setFlash('success', 'تم تحديث المدرسة بنجاح');
        $this->redirect('/admin/schools');
    }

    /**
     * Delete school
     */
    public function delete(string $id): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();

        $school = $this->schoolModel->findById((int)$id);

        if (!$school) {
            $this->setFlash('error', 'المدرسة غير موجودة');
            $this->redirect('/admin/schools');
            return;
        }

        $this->schoolModel->delete((int)$id);
        $this->setFlash('success', 'تم حذف المدرسة بنجاح');
        $this->redirect('/admin/schools');
    }

    /**
     * Toggle school status (active/inactive)
     */
    public function toggleStatus(string $id): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();

        $school = $this->schoolModel->findById((int)$id);

        if (!$school) {
            $this->setFlash('error', 'المدرسة غير موجودة');
            $this->redirect('/admin/schools');
            return;
        }

        // Toggle between active and inactive
        $newStatus = $school['status'] === 'active' ? 'inactive' : 'active';
        
        $this->schoolModel->update((int)$id, [
            'status' => $newStatus
        ]);

        $statusText = $newStatus === 'active' ? 'تفعيل' : 'إلغاء تفعيل';
        $this->setFlash('success', "تم {$statusText} المدرسة بنجاح");
        $this->redirect('/admin/schools');
    }
}
