<?php
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . '/../vendor/autoload.php';

// Load config
$config = require __DIR__ . '/../config/config.php';

try {
    // Get database connection
    $db = require __DIR__ . '/../config/database.php';
    $db = $db();
    
    // Set UTF-8
    $db->exec("SET NAMES utf8mb4");
    
    // Query settings
    $stmt = $db->query("SELECT setting_key, display_name_ar, setting_value FROM site_settings WHERE setting_group='general' ORDER BY display_order");
    $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<!DOCTYPE html><html dir='rtl'><head><meta charset='UTF-8'><title>UTF-8 Test</title>";
    echo "<style>body{font-family:'Cairo',Arial,sans-serif;padding:20px;background:#f5f5f5;}";
    echo "table{border-collapse:collapse;width:100%;background:white;margin-top:20px;}";
    echo "th,td{border:1px solid #ddd;padding:12px;text-align:right;}";
    echo "th{background:#2563eb;color:white;}</style></head><body>";
    
    echo "<h1>اختبار الترميز العربي</h1>";
    echo "<p>إذا ظهرت هذه الجملة بشكل صحيح، فالترميز يعمل</p>";
    
    echo "<table>";
    echo "<tr><th>المفتاح</th><th>العنوان بالعربي</th><th>القيمة</th></tr>";
    foreach ($settings as $setting) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($setting['setting_key']) . "</td>";
        echo "<td>" . htmlspecialchars($setting['display_name_ar']) . "</td>";
        echo "<td>" . htmlspecialchars($setting['setting_value']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "</body></html>";
    
} catch (Exception $e) {
    echo "خطأ: " . $e->getMessage();
}
