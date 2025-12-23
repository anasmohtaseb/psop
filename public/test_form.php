<?php
/**
 * Test settings form submission
 */
header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/../vendor/autoload.php';

// Start session
session_start();
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Load config
$config = require __DIR__ . '/../config/config.php';

// Get settings
$dbFactory = require __DIR__ . '/../config/database.php';
$db = $dbFactory();
$db->exec("SET NAMES utf8mb4");

$stmt = $db->query("SELECT * FROM site_settings ORDER BY setting_group, display_order");
$allSettings = $stmt->fetchAll(PDO::FETCH_ASSOC);

$settingsGrouped = [];
foreach ($allSettings as $setting) {
    $group = $setting['setting_group'];
    if (!isset($settingsGrouped[$group])) {
        $settingsGrouped[$group] = [];
    }
    $settingsGrouped[$group][] = $setting;
}

$groupNames = [
    'general' => '⚙️ General Settings',
    'contact' => '📞 Contact Information',
    'social' => '🌐 Social Media',
    'features' => '🔧 Features'
];
?>

<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Test Settings Form</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
        .section { margin-bottom: 30px; padding: 20px; background: #f9f9f9; border-radius: 8px; }
        .section h2 { margin-top: 0; color: #333; }
        .field { margin-bottom: 15px; }
        .field label { display: block; margin-bottom: 5px; font-weight: bold; }
        .field input[type="text"], .field textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .field textarea { min-height: 80px; }
        button { background: #2563eb; color: white; border: none; padding: 12px 24px; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #1d4ed8; }
        .toggle { display: inline-block; width: 50px; height: 24px; background: #ccc; border-radius: 12px; position: relative; cursor: pointer; }
        .toggle input { display: none; }
        .toggle input:checked + .slider { background: #2563eb; }
        .toggle .slider { position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: white; border-radius: 50%; transition: 0.3s; }
        .toggle input:checked + .slider { transform: translateX(26px); }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test Settings Form</h1>
        
        <form method="POST" action="/psop/public/admin/settings/update" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <?php foreach ($settingsGrouped as $group => $settings): ?>
                <div class="section">
                    <h2><?= $groupNames[$group] ?? $group ?></h2>
                    
                    <?php foreach ($settings as $setting): ?>
                        <div class="field">
                            <label><?= htmlspecialchars($setting['display_name_ar']) ?></label>
                            
                            <?php if ($setting['setting_type'] === 'text'): ?>
                                <input type="text" 
                                       name="<?= $setting['setting_key'] ?>" 
                                       value="<?= htmlspecialchars($setting['setting_value']) ?>">
                            
                            <?php elseif ($setting['setting_type'] === 'textarea'): ?>
                                <textarea name="<?= $setting['setting_key'] ?>"><?= htmlspecialchars($setting['setting_value']) ?></textarea>
                            
                            <?php elseif ($setting['setting_type'] === 'image'): ?>
                                <input type="file" name="<?= $setting['setting_key'] ?>" accept="image/*">
                                <input type="hidden" name="<?= $setting['setting_key'] ?>_current" value="<?= htmlspecialchars($setting['setting_value']) ?>">
                                <?php if ($setting['setting_value']): ?>
                                    <p>Current: <img src="/psop/public/<?= htmlspecialchars($setting['setting_value']) ?>" style="max-height:50px"></p>
                                <?php endif; ?>
                            
                            <?php elseif ($setting['setting_type'] === 'boolean'): ?>
                                <label class="toggle">
                                    <input type="checkbox" 
                                           name="<?= $setting['setting_key'] ?>" 
                                           value="1"
                                           <?= $setting['setting_value'] == '1' ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                </label>
                            
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            
            <button type="submit">💾 Save Settings</button>
        </form>
    </div>
</body>
</html>
