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
        
        $this->render('home/index', [
            'active_competitions' => $activeCompetitions,
            'open_competitions' => $openCompetitions,
            'announcements' => array_slice($announcements, 0, 3),
            'hero_slides' => $heroSlides,
            'site_settings' => $siteSettings,
        ], 'public');
    }

    /**
     * About page
     */
    public function about(): void
    {
        $pageModel = new \App\Models\Page($this->config);
        $pageContent = $pageModel->getPageContent('about');
        
        // إذا لم تكن البيانات موجودة في قاعدة البيانات، عرض الصفحة الثابتة
        if (!$pageContent) {
            $this->render('home/about', [], 'public');
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
        $this->render('home/contact', [
            'csrf_token' => $this->generateCsrfToken(),
        ], 'public');
    }
}
