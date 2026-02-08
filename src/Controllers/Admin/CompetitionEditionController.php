<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Competition;
use App\Models\CompetitionEdition;

/**
 * Competition Edition Controller
 * Manage competition editions (years)
 */
class CompetitionEditionController extends Controller
{
    /**
     * List editions for a competition
     */
    public function index(string $competitionId): void
    {
        $this->requireRole('admin');
        
        $competitionModel = new Competition($this->config);
        $competition = $competitionModel->findById((int)$competitionId);
        
        if (!$competition) {
            $this->setFlash('error', 'المسابقة غير موجودة');
            $this->redirect('/admin/competitions');
        }
        
        $editionModel = new CompetitionEdition($this->config);
        $editions = $editionModel->findByCompetition((int)$competitionId);
        
        $this->render('admin/competitions/editions/index', [
            'competition' => $competition,
            'editions' => $editions,
        ]);
    }

    /**
     * Show create form
     */
    public function create(string $competitionId): void
    {
        $this->requireRole('admin');
        
        $competitionModel = new Competition($this->config);
        $competition = $competitionModel->findById((int)$competitionId);
        
        if (!$competition) {
            $this->setFlash('error', 'المسابقة غير موجودة');
            $this->redirect('/admin/competitions');
        }
        
        $this->render('admin/competitions/editions/create', [
            'competition' => $competition,
            'csrf_token' => $this->generateCsrfToken(),
        ]);
    }

    /**
     * Store new edition
     */
    public function store(string $competitionId): void
    {
        $this->requireRole('admin');
        
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'رمز الحماية غير صحيح');
            $this->redirect('/admin/competitions/' . $competitionId . '/editions/create');
        }
        
        // Basic validation
        if (empty($_POST['year'])) {
            $this->setFlash('error', 'السنة مطلوبة');
            $_SESSION['old'] = $_POST;
            $this->redirect('/admin/competitions/' . $competitionId . '/editions/create');
        }

        $editionModel = new CompetitionEdition($this->config);
        
        try {
            $editionModel->create([
                'competition_id' => (int)$competitionId,
                'year' => (int)$_POST['year'],
                'host_country' => $_POST['host_country'] ?? null,
                'status' => $_POST['status'] ?? 'draft',
                'registration_start_date' => !empty($_POST['registration_start_date']) ? $_POST['registration_start_date'] : null,
                'registration_end_date' => !empty($_POST['registration_end_date']) ? $_POST['registration_end_date'] : null,
                'competition_start_date' => !empty($_POST['competition_start_date']) ? $_POST['competition_start_date'] : null,
                'competition_end_date' => !empty($_POST['competition_end_date']) ? $_POST['competition_end_date'] : null,
                'notes' => $_POST['notes'] ?? null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            
            $this->setFlash('success', 'تم إضافة النسخة بنجاح');
            $this->redirect('/admin/competitions/' . $competitionId . '/editions');
        } catch (\Exception $e) {
            $this->setFlash('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage());
            $_SESSION['old'] = $_POST;
            $this->redirect('/admin/competitions/' . $competitionId . '/editions/create');
        }
    }

    /**
     * Show edit form
     */
    public function edit(string $competitionId, string $id): void
    {
        $this->requireRole('admin');
        
        $editionModel = new CompetitionEdition($this->config);
        $edition = $editionModel->findById((int)$id);
        
        if (!$edition || $edition['competition_id'] != $competitionId) {
            $this->setFlash('error', 'النسخة غير موجودة');
            $this->redirect('/admin/competitions/' . $competitionId . '/editions');
        }
        
        $competitionModel = new Competition($this->config);
        $competition = $competitionModel->findById((int)$competitionId);
        
        $this->render('admin/competitions/editions/edit', [
            'competition' => $competition,
            'edition' => $edition,
            'csrf_token' => $this->generateCsrfToken(),
        ]);
    }

    /**
     * Update edition
     */
    public function update(string $competitionId, string $id): void
    {
        $this->requireRole('admin');
        
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'رمز الحماية غير صحيح');
            $this->redirect('/admin/competitions/' . $competitionId . '/editions/' . $id . '/edit');
        }
        
        $editionModel = new CompetitionEdition($this->config);
        
        try {
            $editionModel->update((int)$id, [
                'year' => (int)$_POST['year'],
                'host_country' => $_POST['host_country'] ?? null,
                'status' => $_POST['status'] ?? 'draft',
                'registration_start_date' => !empty($_POST['registration_start_date']) ? $_POST['registration_start_date'] : null,
                'registration_end_date' => !empty($_POST['registration_end_date']) ? $_POST['registration_end_date'] : null,
                'competition_start_date' => !empty($_POST['competition_start_date']) ? $_POST['competition_start_date'] : null,
                'competition_end_date' => !empty($_POST['competition_end_date']) ? $_POST['competition_end_date'] : null,
                'notes' => $_POST['notes'] ?? null,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            
            $this->setFlash('success', 'تم تحديث النسخة بنجاح');
            $this->redirect('/admin/competitions/' . $competitionId . '/editions');
        } catch (\Exception $e) {
            $this->setFlash('error', 'حدث خطأ أثناء التحديث: ' . $e->getMessage());
            $this->redirect('/admin/competitions/' . $competitionId . '/editions/' . $id . '/edit');
        }
    }

    /**
     * Delete edition
     */
    public function delete(string $competitionId, string $id): void
    {
        $this->requireRole('admin');
        
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'رمز الحماية غير صحيح');
            $this->redirect('/admin/competitions/' . $competitionId . '/editions');
        }
        
        $editionModel = new CompetitionEdition($this->config);
        $editionModel->delete((int)$id);
        
        $this->setFlash('success', 'تم حذف النسخة بنجاح');
        $this->redirect('/admin/competitions/' . $competitionId . '/editions');
    }
}
