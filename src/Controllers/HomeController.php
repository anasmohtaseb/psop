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
        
        $activeCompetitions = $competitionModel->findActive();
        $openCompetitions = $editionModel->findOpenForRegistration();
        $announcements = $announcementModel->findPublished('all');
        
        $this->render('home/index', [
            'active_competitions' => $activeCompetitions,
            'open_competitions' => $openCompetitions,
            'announcements' => array_slice($announcements, 0, 3),
        ], 'public');
    }

    /**
     * About page
     */
    public function about(): void
    {
        $this->render('home/about', [], 'public');
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
