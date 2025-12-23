<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\SiteSetting;

class SettingsController extends Controller
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
     * Display settings page
     */
    public function index(): void
    {
        $settingsGrouped = $this->settingModel->getAllGrouped();
        
        $this->render('admin/settings/index', [
            'settings_grouped' => $settingsGrouped,
            'title' => 'إعدادات الموقع'
        ]);
    }
    
    /**
     * Update settings
     */
    public function update(): void
    {
        $this->validateCsrfToken();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/settings');
            return;
        }
        
        $uploadedLogo = null;
        $uploadError = null;
        
        // Handle logo upload if provided
        if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $this->config['paths']['root'] . '/public/assets/images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $file = $_FILES['site_logo'];
                $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
                
                if (in_array($extension, $allowedExtensions)) {
                    // Check file size (max 5MB)
                    if ($file['size'] <= 5 * 1024 * 1024) {
                        $fileName = 'logo_' . time() . '.' . $extension;
                        $uploadPath = $uploadDir . $fileName;
                        
                        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                            $uploadedLogo = 'assets/images/' . $fileName;
                        } else {
                            $uploadError = 'Failed to move uploaded file. Check permissions.';
                        }
                    } else {
                        $uploadError = 'File size exceeds 5MB limit.';
                    }
                } else {
                    $uploadError = 'Invalid file type. Only JPG, PNG, SVG, and WebP are allowed.';
                }
            } else {
                $uploadError = 'File upload error: ' . $_FILES['site_logo']['error'];
            }
        }
        
        // Get all settings
        $allSettings = $this->settingModel->findAll();
        $settingsByKey = [];
        foreach ($allSettings as $setting) {
            $settingsByKey[$setting['setting_key']] = $setting;
        }
        
        // Initialize counter
        $updated = 0;
        
        // Update logo if uploaded
        if ($uploadedLogo) {
            $this->settingModel->updateByKey('site_logo', $uploadedLogo);
            $updated++;
        }
        
        // Process text/textarea fields
        foreach ($_POST as $key => $value) {
            // Skip CSRF and hidden fields
            if ($key === 'csrf_token' || strpos($key, '_current') !== false) {
                continue;
            }
            
            // Skip if not a valid setting
            if (!isset($settingsByKey[$key])) {
                continue;
            }
            
            $setting = $settingsByKey[$key];
            
            // Skip logo field (already handled above)
            if ($key === 'site_logo') {
                continue;
            }
            
            // Skip boolean fields (handled separately)
            if ($setting['setting_type'] === 'boolean') {
                continue;
            }
            
            // Update value
            if ($this->settingModel->updateByKey($key, $value)) {
                $updated++;
            }
        }
        
        // Handle boolean checkboxes
        foreach ($settingsByKey as $key => $setting) {
            if ($setting['setting_type'] === 'boolean') {
                $newValue = isset($_POST[$key]) && $_POST[$key] === '1' ? '1' : '0';
                if ($this->settingModel->updateByKey($key, $newValue)) {
                    $updated++;
                }
            }
        }
        
        if ($updated > 0) {
            $message = 'Settings updated successfully - ' . $updated . ' changes made';
            if ($uploadError) {
                $message .= '. Logo upload failed: ' . $uploadError;
                $this->setFlash('warning', $message);
            } else {
                $this->setFlash('success', $message);
            }
        } else {
            if ($uploadError) {
                $this->setFlash('error', 'Logo upload failed: ' . $uploadError);
            } else {
                $this->setFlash('info', 'No changes were made');
            }
        }
        
        $this->redirect('/admin/settings');
    }
}
