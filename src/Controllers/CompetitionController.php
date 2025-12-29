<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Competition;
use App\Models\CompetitionEdition;

/**
 * Competition Controller
 * Public and admin pages for competitions
 */
class CompetitionController extends Controller
{
    /**
     * List all competitions (public)
     */
    public function index(): void
    {
        $competitionModel = new Competition($this->config);
        $competitions = $competitionModel->findActive();
        
        $this->render('competitions/index', [
            'competitions' => $competitions,
        ], 'public');
    }

    /**
     * Show competition details (public)
     */
    public function show(string $id): void
    {
        $competitionModel = new Competition($this->config);
        $competition = $competitionModel->findWithLatestEdition((int)$id);
        
        if (!$competition) {
            $this->setFlash('error', 'المسابقة غير موجودة');
            $this->redirect('/competitions');
        }
        
        $editionModel = new CompetitionEdition($this->config);
        $editions = $editionModel->findByCompetition((int)$id);
        
        $this->render('competitions/show', [
            'competition' => $competition,
            'editions' => $editions,
        ], 'public');
    }

    /**
     * Admin: List all competitions
     */
    public function adminIndex(): void
    {
        $this->requireRole('admin');
        
        $competitionModel = new Competition($this->config);
        $competitions = $competitionModel->findAll();
        
        $this->render('admin/competitions/index', [
            'competitions' => $competitions,
        ]);
    }

    /**
     * Admin: Show create form
     */
    public function create(): void
    {
        $this->requireRole('admin');
        
        $this->render('admin/competitions/create', [
            'csrf_token' => $this->generateCsrfToken(),
        ]);
    }

    /**
     * Admin: Store new competition
     */
    public function store(): void
    {
        $this->requireRole('admin');
        
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'رمز الحماية غير صحيح');
            $this->redirect('/admin/competitions/create');
        }
        
        $competitionModel = new Competition($this->config);
        
        // Handle logo upload
        $logoPath = null;
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $logoPath = $this->uploadLogo($_FILES['logo']);
        }
        
        try {
            $competitionModel->create([
                'name_ar' => $_POST['name_ar'],
                'name_en' => $_POST['name_en'],
                'code' => $_POST['code'],
                'category' => $_POST['category'],
                'description_ar' => $_POST['description_ar'] ?? null,
                'description_en' => $_POST['description_en'] ?? null,
                'long_description_ar' => $_POST['long_description_ar'] ?? null,
                'long_description_en' => $_POST['long_description_en'] ?? null,
                'logo_path' => $logoPath,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $this->setFlash('success', 'تم إضافة المسابقة بنجاح');
            $this->redirect('/admin/competitions');
        } catch (\Exception $e) {
            $this->setFlash('error', 'حدث خطأ أثناء الحفظ');
            $this->redirect('/admin/competitions/create');
        }
    }

    /**
     * Admin: Show edit form
     */
    public function edit(string $id): void
    {
        $this->requireRole('admin');
        
        $competitionModel = new Competition($this->config);
        $competition = $competitionModel->findById((int)$id);
        
        if (!$competition) {
            $this->setFlash('error', 'المسابقة غير موجودة');
            $this->redirect('/admin/competitions');
        }
        
        $this->render('admin/competitions/edit', [
            'competition' => $competition,
            'csrf_token' => $this->generateCsrfToken(),
        ]);
    }

    /**
     * Admin: Update competition
     */
    public function update(string $id): void
    {
        $this->requireRole('admin');
        
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'رمز الحماية غير صحيح');
            $this->redirect('/admin/competitions/' . $id . '/edit');
        }
        
        $competitionModel = new Competition($this->config);
        
        // Handle logo upload
        $updateData = [
            'name_ar' => $_POST['name_ar'],
            'name_en' => $_POST['name_en'],
            'code' => $_POST['code'],
            'category' => $_POST['category'],
            'description_ar' => $_POST['description_ar'] ?? null,
            'description_en' => $_POST['description_en'] ?? null,
            'long_description_ar' => $_POST['long_description_ar'] ?? null,
            'long_description_en' => $_POST['long_description_en'] ?? null,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $logoPath = $this->uploadLogo($_FILES['logo']);
            if ($logoPath) {
                $updateData['logo_path'] = $logoPath;
            }
        }
        
        try {
            $competitionModel->update((int)$id, $updateData);
            
            $this->setFlash('success', 'تم تحديث المسابقة بنجاح');
            $this->redirect('/admin/competitions');
        } catch (\Exception $e) {
            $this->setFlash('error', 'حدث خطأ أثناء التحديث');
            $this->redirect('/admin/competitions/' . $id . '/edit');
        }
    }
    
    /**
     * Upload competition logo
     */
    private function uploadLogo(array $file): ?string
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        
        // Validate file type
        if (!in_array($file['type'], $allowedTypes)) {
            $this->setFlash('error', 'نوع الملف غير مدعوم. يرجى رفع صورة PNG أو JPG');
            return null;
        }
        
        // Validate file size
        if ($file['size'] > $maxSize) {
            $this->setFlash('error', 'حجم الملف كبير جداً. الحد الأقصى 2 ميجابايت');
            return null;
        }
        
        // Create uploads directory if not exists
        $uploadsDir = $this->config['paths']['root'] . '/public/assets/uploads/competitions';
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0755, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('comp_') . '.' . $extension;
        $destination = $uploadsDir . '/' . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return 'uploads/competitions/' . $filename;
        }
        
        $this->setFlash('error', 'فشل رفع الملف');
        return null;
    }
}
