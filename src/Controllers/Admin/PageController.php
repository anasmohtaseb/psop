<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Page;

class PageController extends Controller
{
    private Page $pageModel;
    
    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->requireAuth();
        $this->requireRole('admin');
        $this->pageModel = new Page($this->config);
    }
    
    /**
     * عرض قائمة الصفحات
     */
    public function index(): void
    {
        $pages = $this->pageModel->getAllPages();
        
        $this->render('admin/pages/index', [
            'pages' => $pages,
            'title' => 'إدارة الصفحات'
        ]);
    }
    
    /**
     * عرض صفحة التعديل
     */
    public function edit(): void
    {
        $pageKey = $_GET['key'] ?? 'about';
        
        $pageContent = $this->pageModel->getPageContent($pageKey);
        
        if (!$pageContent) {
            $this->setFlash('error', 'الصفحة غير موجودة');
            $this->redirect('/admin/pages');
            return;
        }
        
        $this->render('admin/pages/edit', [
            'page' => $pageContent,
            'title' => 'تعديل صفحة: ' . $pageContent['page_title_ar']
        ]);
    }
    
    /**
     * تحديث معلومات الصفحة الأساسية
     */
    public function updatePageInfo(): void
    {
        $this->validateCsrfToken();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/pages');
            return;
        }
        
        $pageId = (int)($_POST['page_id'] ?? 0);
        
        if ($pageId <= 0) {
            $this->setFlash('error', 'معرف الصفحة غير صحيح');
            $this->redirect('/admin/pages');
            return;
        }
        
        $data = [
            'page_title_ar' => trim($_POST['page_title_ar'] ?? ''),
            'page_title_en' => trim($_POST['page_title_en'] ?? ''),
            'meta_description' => trim($_POST['meta_description'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
        
        if (empty($data['page_title_ar'])) {
            $this->setFlash('error', 'عنوان الصفحة مطلوب');
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/admin/pages');
            return;
        }
        
        $updated = $this->pageModel->updatePage($pageId, $data);
        
        if ($updated) {
            $this->setFlash('success', 'تم تحديث معلومات الصفحة بنجاح');
        } else {
            $this->setFlash('error', 'فشل تحديث معلومات الصفحة');
        }
        
        $this->redirect($_SERVER['HTTP_REFERER'] ?? '/admin/pages');
    }
    
    /**
     * تحديث قسم
     */
    public function updateSection(): void
    {
        $this->validateCsrfToken();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'طريقة الطلب غير صحيحة'], 400);
            return;
        }
        
        $sectionId = (int)($_POST['section_id'] ?? 0);
        
        if ($sectionId <= 0) {
            $this->json(['success' => false, 'message' => 'معرف القسم غير صحيح'], 400);
            return;
        }
        
        $data = [
            'section_title_ar' => trim($_POST['section_title_ar'] ?? ''),
            'section_title_en' => trim($_POST['section_title_en'] ?? ''),
            'section_content_ar' => trim($_POST['section_content_ar'] ?? ''),
            'section_content_en' => trim($_POST['section_content_en'] ?? ''),
            'section_icon' => trim($_POST['section_icon'] ?? ''),
            'section_order' => (int)($_POST['section_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
        
        $updated = $this->pageModel->updateSection($sectionId, $data);
        
        if ($updated) {
            $this->setFlash('success', 'تم تحديث القسم بنجاح');
            $this->json(['success' => true, 'message' => 'تم التحديث بنجاح']);
        } else {
            $this->json(['success' => false, 'message' => 'فشل تحديث القسم'], 500);
        }
    }
    
    /**
     * إنشاء قسم جديد
     */
    public function createSection(): void
    {
        $this->validateCsrfToken();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/pages');
            return;
        }
        
        $pageId = (int)($_POST['page_id'] ?? 0);
        
        if ($pageId <= 0) {
            $this->setFlash('error', 'معرف الصفحة غير صحيح');
            $this->redirect('/admin/pages');
            return;
        }
        
        $data = [
            'page_id' => $pageId,
            'section_key' => trim($_POST['section_key'] ?? ''),
            'section_title_ar' => trim($_POST['section_title_ar'] ?? ''),
            'section_title_en' => trim($_POST['section_title_en'] ?? ''),
            'section_content_ar' => trim($_POST['section_content_ar'] ?? ''),
            'section_content_en' => trim($_POST['section_content_en'] ?? ''),
            'section_icon' => trim($_POST['section_icon'] ?? ''),
            'section_order' => (int)($_POST['section_order'] ?? 0),
            'section_type' => $_POST['section_type'] ?? 'text',
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
        
        if (empty($data['section_key']) || empty($data['section_title_ar'])) {
            $this->setFlash('error', 'المفتاح والعنوان مطلوبان');
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/admin/pages');
            return;
        }
        
        $sectionId = $this->pageModel->createSection($data);
        
        if ($sectionId) {
            $this->setFlash('success', 'تم إضافة القسم بنجاح');
        } else {
            $this->setFlash('error', 'فشل إضافة القسم');
        }
        
        $this->redirect($_SERVER['HTTP_REFERER'] ?? '/admin/pages');
    }
    
    /**
     * حذف قسم
     */
    public function deleteSection(): void
    {
        $this->validateCsrfToken();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'طريقة الطلب غير صحيحة'], 400);
            return;
        }
        
        $sectionId = (int)($_POST['section_id'] ?? 0);
        
        if ($sectionId <= 0) {
            $this->json(['success' => false, 'message' => 'معرف القسم غير صحيح'], 400);
            return;
        }
        
        $deleted = $this->pageModel->deleteSection($sectionId);
        
        if ($deleted) {
            $this->setFlash('success', 'تم حذف القسم بنجاح');
            $this->json(['success' => true, 'message' => 'تم الحذف بنجاح']);
        } else {
            $this->json(['success' => false, 'message' => 'فشل حذف القسم'], 500);
        }
    }
    
    /**
     * تحديث إحصائية
     */
    public function updateStat(): void
    {
        $this->validateCsrfToken();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'طريقة الطلب غير صحيحة'], 400);
            return;
        }
        
        $statId = (int)($_POST['stat_id'] ?? 0);
        
        if ($statId <= 0) {
            $this->json(['success' => false, 'message' => 'معرف الإحصائية غير صحيح'], 400);
            return;
        }
        
        $data = [
            'stat_label_ar' => trim($_POST['stat_label_ar'] ?? ''),
            'stat_label_en' => trim($_POST['stat_label_en'] ?? ''),
            'stat_value' => trim($_POST['stat_value'] ?? ''),
            'stat_order' => (int)($_POST['stat_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
        
        $updated = $this->pageModel->updateStat($statId, $data);
        
        if ($updated) {
            $this->setFlash('success', 'تم تحديث الإحصائية بنجاح');
            $this->json(['success' => true, 'message' => 'تم التحديث بنجاح']);
        } else {
            $this->json(['success' => false, 'message' => 'فشل تحديث الإحصائية'], 500);
        }
    }
    
    /**
     * إنشاء إحصائية جديدة
     */
    public function createStat(): void
    {
        $this->validateCsrfToken();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/pages');
            return;
        }
        
        $pageId = (int)($_POST['page_id'] ?? 0);
        
        if ($pageId <= 0) {
            $this->setFlash('error', 'معرف الصفحة غير صحيح');
            $this->redirect('/admin/pages');
            return;
        }
        
        $data = [
            'page_id' => $pageId,
            'stat_label_ar' => trim($_POST['stat_label_ar'] ?? ''),
            'stat_label_en' => trim($_POST['stat_label_en'] ?? ''),
            'stat_value' => trim($_POST['stat_value'] ?? ''),
            'stat_order' => (int)($_POST['stat_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
        
        if (empty($data['stat_label_ar']) || empty($data['stat_value'])) {
            $this->setFlash('error', 'النص والقيمة مطلوبان');
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/admin/pages');
            return;
        }
        
        $statId = $this->pageModel->createStat($data);
        
        if ($statId) {
            $this->setFlash('success', 'تم إضافة الإحصائية بنجاح');
        } else {
            $this->setFlash('error', 'فشل إضافة الإحصائية');
        }
        
        $this->redirect($_SERVER['HTTP_REFERER'] ?? '/admin/pages');
    }
    
    /**
     * حذف إحصائية
     */
    public function deleteStat(): void
    {
        $this->validateCsrfToken();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'طريقة الطلب غير صحيحة'], 400);
            return;
        }
        
        $statId = (int)($_POST['stat_id'] ?? 0);
        
        if ($statId <= 0) {
            $this->json(['success' => false, 'message' => 'معرف الإحصائية غير صحيح'], 400);
            return;
        }
        
        $deleted = $this->pageModel->deleteStat($statId);
        
        if ($deleted) {
            $this->setFlash('success', 'تم حذف الإحصائية بنجاح');
            $this->json(['success' => true, 'message' => 'تم الحذف بنجاح']);
        } else {
            $this->json(['success' => false, 'message' => 'فشل حذف الإحصائية'], 500);
        }
    }
}
