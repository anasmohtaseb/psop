<?php

namespace App\Controllers;

class SwaggerController extends \App\Core\Controller
{
    /**
     * Display Swagger UI
     */
    public function index(): void
    {
        require __DIR__ . '/../../views/api/swagger-ui.php';
    }
}
