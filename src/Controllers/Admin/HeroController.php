<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\SiteSetting;

class HeroController extends Controller
{
    private SiteSetting $settingModel;
    
    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->requireAuth();
        $this->requireRole('admin');
        $this->settingModel = new SiteSetting($this->config);
    }
    
    /**
     * Display Hero Section settings
     */
    public function index(): void
    {
        $settings = $this->settingModel->getAllAsArray();
        
        // Default values if not set
        $heroTitle = $settings['hero_title'] ?? 'اكتشاف ورعاية <span>العقول المبدعة</span> عبر الأوليمبيادات العلمية العالمية';
        $heroSubtitle = $settings['hero_subtitle'] ?? 'الأولمبيادات العلمية هي أكبر تجمع للمواهب الشابة في فلسطين، تهدف إلى اكتشاف العقول اللامعة وتنمية مهاراتها في مجالات متعددة مثل البرمجة، الرياضيات، الفيزياء، والكيمياء. تقدم هذه المسابقات فرصة استثنائية للمشاركين للتعلم، الإبداع، والتألق على المستويين المحلي والدولي.';
        $heroFootnote = $settings['hero_footnote'] ?? 'البوابة موجهة لطلبة المدارس والجامعات، مع إتاحة برامج تدريبية وتأهيلية بإشراف لجنة علمية متخصصة. <strong>إطلاق الدورة الأولى التجريبية قريباً.</strong>';
        
        $this->render('admin/hero/index', [
            'hero_title' => $heroTitle,
            'hero_subtitle' => $heroSubtitle,
            'hero_footnote' => $heroFootnote,
            'title' => 'إدارة محتوى Hero Section'
        ]);
    }
    
    /**
     * Update Hero Section content
     */
    public function update(): void
    {
        $this->validateCsrfToken();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/hero');
            return;
        }
        
        // Get the posted data
        $heroTitle = $_POST['hero_title'] ?? '';
        $heroSubtitle = $_POST['hero_subtitle'] ?? '';
        $heroFootnote = $_POST['hero_footnote'] ?? '';
        
        // Validate
        if (empty($heroTitle) || empty($heroSubtitle)) {
            $this->setFlash('error', 'العنوان والنص الفرعي مطلوبان');
            $this->redirect('/admin/hero');
            return;
        }
        
        // Update or create settings
        $this->settingModel->updateOrCreate('hero_title', $heroTitle, 'textarea', 'hero', 'عنوان Hero Section', 1);
        $this->settingModel->updateOrCreate('hero_subtitle', $heroSubtitle, 'textarea', 'hero', 'النص الفرعي', 2);
        $this->settingModel->updateOrCreate('hero_footnote', $heroFootnote, 'textarea', 'hero', 'الملاحظة السفلية', 3);
        
        // Log activity
        logUpdate('settings', 0, 'تحديث محتوى Hero Section');
        
        $this->setFlash('success', 'تم تحديث محتوى Hero Section بنجاح! ✓');
        $this->redirect('/admin/hero');
    }
}
