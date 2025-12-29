<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

/**
 * Home Controller
 * Public pages
 */
class HomeController extends Controller
{
    /**
     * Landing page
     */
    public function index(): void
    {
        $competitionModel = new \App\Models\Competition($this->config);
        $editionModel = new \App\Models\CompetitionEdition($this->config);
        $announcementModel = new \App\Models\Announcement($this->config);
        $slideModel = new \App\Models\HeroSlide($this->config);
        $settingModel = new \App\Models\SiteSetting($this->config);
        
        $activeCompetitions = $competitionModel->findActive();
        $openCompetitions = $editionModel->findOpenForRegistration();
        $announcements = $announcementModel->findPublished('all');
        $heroSlides = $slideModel->getActiveSlides();
        $siteSettings = $settingModel->getAllAsArray();
        // featured images for homepage gallery
        $imageModel = new \App\Models\CompetitionImage($this->config);
        $recentImages = $imageModel->findFeatured(8);
        
        $this->render('home/index', [
            'active_competitions' => $activeCompetitions,
            'open_competitions' => $openCompetitions,
            'announcements' => array_slice($announcements, 0, 3),
            'hero_slides' => $heroSlides,
            'site_settings' => $siteSettings,
            'recent_competition_images' => $recentImages,
        ], 'public');
    }

    /**
     * About page
     */
    public function about(): void
    {
        $pageModel = new \App\Models\Page($this->config);
        $pageContent = $pageModel->getPageContent('about');
        
        $settingModel = new \App\Models\SiteSetting($this->config);
        $settings = $settingModel->getAllAsArray();
        
        // إذا لم تكن البيانات موجودة في قاعدة البيانات، عرض الصفحة الثابتة
        if (!$pageContent) {
            $this->render('home/about', ['settings' => $settings], 'public');
            return;
        }
        
        $this->render('home/about_dynamic', [
            'page' => $pageContent
        ], 'public');
    }

    /**
     * Contact page
     */
    public function contact(): void
    {
        $settingModel = new \App\Models\SiteSetting($this->config);
        $settings = $settingModel->getAllAsArray();
        
        $this->render('home/contact', [
            'csrf_token' => $this->generateCsrfToken(),
            'settings' => $settings,
        ], 'public');
    }

    /**
     * Handle contact form submission
     */
    public function sendContact(): void
    {
        // Validate CSRF token
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'حدث خطأ في التحقق من الأمان. يرجى المحاولة مرة أخرى.');
            $this->redirect('/contact');
            return;
        }

        // Validate input
        $validator = new \App\Core\Validator($_POST);
        $validator->required('name', 'الاسم الكامل مطلوب')
                  ->required('email', 'البريد الإلكتروني مطلوب')
                  ->email('email', 'البريد الإلكتروني غير صحيح')
                  ->required('subject', 'الموضوع مطلوب')
                  ->required('message', 'الرسالة مطلوبة')
                  ->min('message', 10, 'الرسالة يجب أن تكون 10 أحرف على الأقل');

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $_POST;
            $this->redirect('/contact');
            return;
        }

        // Save message to database
        $contactModel = new \App\Models\ContactMessage($this->config);
        $messageData = [
            'name' => htmlspecialchars($_POST['name']),
            'email' => htmlspecialchars($_POST['email']),
            'phone' => htmlspecialchars($_POST['phone'] ?? ''),
            'subject' => htmlspecialchars($_POST['subject']),
            'message' => htmlspecialchars($_POST['message']),
            'status' => 'new'
        ];

        $messageId = $contactModel->create($messageData);

        if ($messageId) {
            $this->setFlash('success', 'تم إرسال رسالتك بنجاح! سنتواصل معك في أقرب وقت ممكن.');
        } else {
            $this->setFlash('error', 'حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.');
        }

        $this->redirect('/contact');
    }
}
