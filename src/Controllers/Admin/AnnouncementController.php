<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Announcement;

/**
 * Admin Announcement Controller
 */
class AnnouncementController extends Controller
{
    private Announcement $announcementModel;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->announcementModel = new Announcement($config);
    }

    /**
     * List all announcements
     */
    public function index(): void
    {
        $this->requireRole('admin');

        $announcements = $this->announcementModel->findAll([], 100, 0);

        $this->render('admin/announcements/index', [
            'announcements' => $announcements,
            'title' => 'Announcements Management'
        ], 'dashboard');
    }

    /**
     * Show create form
     */
    public function create(): void
    {
        $this->requireRole('admin');

        $this->render('admin/announcements/create', [
            'title' => 'Create Announcement'
        ], 'dashboard');
    }

    /**
     * Store new announcement
     */
    public function store(): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();

        $data = [
            'title' => $_POST['title'] ?? '',
            'content' => $_POST['content'] ?? '',
            'target_audience' => $_POST['target_audience'] ?? 'all',
            'status' => $_POST['status'] ?? 'draft',
            'publish_date' => !empty($_POST['publish_date']) ? $_POST['publish_date'] : null
        ];

        try {
            $id = $this->announcementModel->create($data);
            $this->setFlash('success', 'Announcement created successfully');
            $this->redirect('/admin/announcements');
        } catch (\Exception $e) {
            error_log('Error creating announcement: ' . $e->getMessage());
            $this->setFlash('error', 'Failed to create announcement');
            $this->redirect('/admin/announcements/create');
        }
    }

    /**
     * Show edit form
     */
    public function edit(): void
    {
        $this->requireRole('admin');

        $id = (int)($_GET['id'] ?? 0);
        $announcement = $this->announcementModel->findById($id);

        if (!$announcement) {
            $this->setFlash('error', 'Announcement not found');
            $this->redirect('/admin/announcements');
            return;
        }

        $this->render('admin/announcements/edit', [
            'announcement' => $announcement,
            'title' => 'Edit Announcement'
        ], 'dashboard');
    }

    /**
     * Update announcement
     */
    public function update(): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();

        $id = (int)($_POST['id'] ?? 0);
        $announcement = $this->announcementModel->findById($id);

        if (!$announcement) {
            $this->setFlash('error', 'Announcement not found');
            $this->redirect('/admin/announcements');
            return;
        }

        $data = [
            'title' => $_POST['title'] ?? '',
            'content' => $_POST['content'] ?? '',
            'target_audience' => $_POST['target_audience'] ?? 'all',
            'status' => $_POST['status'] ?? 'draft',
            'publish_date' => !empty($_POST['publish_date']) ? $_POST['publish_date'] : null
        ];

        try {
            $this->announcementModel->update($id, $data);
            $this->setFlash('success', 'Announcement updated successfully');
            $this->redirect('/admin/announcements');
        } catch (\Exception $e) {
            error_log('Error updating announcement: ' . $e->getMessage());
            $this->setFlash('error', 'Failed to update announcement');
            $this->redirect('/admin/announcements/' . $id . '/edit');
        }
    }

    /**
     * Delete announcement
     */
    public function delete(): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();

        $id = (int)($_POST['id'] ?? 0);

        try {
            $this->announcementModel->delete($id);
            $this->setFlash('success', 'Announcement deleted successfully');
        } catch (\Exception $e) {
            error_log('Error deleting announcement: ' . $e->getMessage());
            $this->setFlash('error', 'Failed to delete announcement');
        }

        $this->redirect('/admin/announcements');
    }
}
