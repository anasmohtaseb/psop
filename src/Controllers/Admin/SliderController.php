<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\HeroSlide;

class SliderController extends Controller
{
    private HeroSlide $slideModel;
    
    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->requireAuth();
        $this->requireRole('admin');
        $this->slideModel = new HeroSlide($this->config);
    }
    
    /**
     * Display all slides
     */
    public function index(): void
    {
        $slides = $this->slideModel->getAllSlides();
        
        $this->render('admin/slider/index', [
            'slides' => $slides,
            'title' => 'إدارة سلايدر الصفحة الرئيسية'
        ]);
    }
    
    /**
     * Show create slide form
     */
    public function create(): void
    {
        $this->render('admin/slider/create', [
            'title' => 'إضافة صورة جديدة للسلايدر'
        ]);
    }
    
    /**
     * Store new slide
     */
    public function store(): void
    {
        $this->validateCsrfToken();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/slider');
            return;
        }
        
        // Validate inputs
        $titleAr = trim($_POST['title_ar'] ?? '');
        $descriptionAr = trim($_POST['description_ar'] ?? '');
        $slideOrder = (int)($_POST['slide_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        if (empty($titleAr)) {
            $this->setFlash('error', 'عنوان الصورة مطلوب');
            $this->redirect('/admin/slider/create');
            return;
        }
        
        // Handle file upload
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $this->setFlash('error', 'يرجى رفع صورة للسلايدر');
            $this->redirect('/admin/slider/create');
            return;
        }
        
        $uploadDir = $this->config['paths']['root'] . '/public/assets/uploads/competitions/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $file = $_FILES['image'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (!in_array($extension, $allowedExtensions)) {
            $this->setFlash('error', 'نوع الملف غير مسموح. يرجى رفع صورة (jpg, jpeg, png, webp)');
            $this->redirect('/admin/slider/create');
            return;
        }
        
        $fileName = 'slide_' . time() . '_' . uniqid() . '.' . $extension;
        $uploadPath = $uploadDir . $fileName;
        
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $this->setFlash('error', 'فشل رفع الصورة');
            $this->redirect('/admin/slider/create');
            return;
        }
        
        // Save to database
        $data = [
            'title_ar' => $titleAr,
            'description_ar' => $descriptionAr,
            'image_path' => 'uploads/competitions/' . $fileName,
            'slide_order' => $slideOrder,
            'is_active' => $isActive
        ];
        
        $id = $this->slideModel->create($data);
        
        if ($id) {
            $this->setFlash('success', 'تم إضافة الصورة بنجاح');
            $this->redirect('/admin/slider');
        } else {
            $this->setFlash('error', 'حدث خطأ أثناء إضافة الصورة');
            $this->redirect('/admin/slider/create');
        }
    }
    
    /**
     * Show edit slide form
     */
    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $slide = $this->slideModel->findById($id);
        
        if (!$slide) {
            $this->setFlash('error', 'الصورة غير موجودة');
            $this->redirect('/admin/slider');
            return;
        }
        
        $this->render('admin/slider/edit', [
            'slide' => $slide,
            'title' => 'تعديل صورة السلايدر'
        ]);
    }
    
    /**
     * Update slide
     */
    public function update(): void
    {
        $this->validateCsrfToken();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/slider');
            return;
        }
        
        $id = (int)($_POST['id'] ?? 0);
        $slide = $this->slideModel->findById($id);
        
        if (!$slide) {
            $this->setFlash('error', 'الصورة غير موجودة');
            $this->redirect('/admin/slider');
            return;
        }
        
        $titleAr = trim($_POST['title_ar'] ?? '');
        $descriptionAr = trim($_POST['description_ar'] ?? '');
        $slideOrder = (int)($_POST['slide_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        if (empty($titleAr)) {
            $this->setFlash('error', 'عنوان الصورة مطلوب');
            $this->redirect('/admin/slider/edit?id=' . $id);
            return;
        }
        
        $data = [
            'title_ar' => $titleAr,
            'description_ar' => $descriptionAr,
            'slide_order' => $slideOrder,
            'is_active' => $isActive
        ];
        
        // Handle new image upload if provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = $this->config['paths']['root'] . '/public/assets/uploads/competitions/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $file = $_FILES['image'];
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            
            if (!in_array($extension, $allowedExtensions)) {
                $this->setFlash('error', 'نوع الملف غير مسموح');
                $this->redirect('/admin/slider/edit?id=' . $id);
                return;
            }
            
            $fileName = 'slide_' . time() . '_' . uniqid() . '.' . $extension;
            $uploadPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                // Delete old image
                $oldImagePath = $this->config['paths']['root'] . '/public/assets/' . $slide['image_path'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                
                $data['image_path'] = 'uploads/competitions/' . $fileName;
            }
        }
        
        if ($this->slideModel->update($id, $data)) {
            $this->setFlash('success', 'تم تحديث الصورة بنجاح');
        } else {
            $this->setFlash('error', 'حدث خطأ أثناء التحديث');
        }
        
        $this->redirect('/admin/slider');
    }
    
    /**
     * Delete slide
     */
    public function delete(): void
    {
        $this->validateCsrfToken();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/slider');
            return;
        }
        
        $id = (int)($_POST['id'] ?? 0);
        $slide = $this->slideModel->findById($id);
        
        if (!$slide) {
            $this->setFlash('error', 'الصورة غير موجودة');
            $this->redirect('/admin/slider');
            return;
        }
        
        // Delete image file
        $imagePath = $this->config['paths']['root'] . '/public/assets/' . $slide['image_path'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        
        if ($this->slideModel->delete($id)) {
            $this->setFlash('success', 'تم حذف الصورة بنجاح');
        } else {
            $this->setFlash('error', 'حدث خطأ أثناء الحذف');
        }
        
        $this->redirect('/admin/slider');
    }
    
    /**
     * Toggle slide active status
     */
    public function toggleActive(): void
    {
        $this->validateCsrfToken();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/slider');
            return;
        }
        
        $id = (int)($_POST['id'] ?? 0);
        
        if ($this->slideModel->toggleActive($id)) {
            $this->setFlash('success', 'تم تحديث حالة الصورة بنجاح');
        } else {
            $this->setFlash('error', 'حدث خطأ أثناء التحديث');
        }
        
        $this->redirect('/admin/slider');
    }
}
