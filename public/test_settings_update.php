<?php
/**
 * Debug test for settings update
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Start session
session_start();

// Load config
$config = require __DIR__ . '/../config/config.php';

// Simulate POST data
$_POST = [
    'csrf_token' => $_SESSION['csrf_token'] ?? 'test',
    'site_name_ar' => 'Test Site Name Arabic',
    'site_name_en' => 'Test Site Name English',
    'site_description' => 'This is a test description',
    'site_email' => 'test@example.com',
    'site_phone' => '+970-123-4567',
    'enable_registration' => '1'
];

echo "<h2>Testing Settings Update</h2>";
echo "<h3>POST Data:</h3>";
echo "<pre>" . print_r($_POST, true) . "</pre>";

// Test database connection
try {
    $db = require __DIR__ . '/../config/database.php';
    $db = $db();
    echo "<p style='color:green'>✓ Database connected</p>";
    
    // Test query
    $stmt = $db->query("SELECT * FROM site_settings LIMIT 5");
    $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Current Settings (first 5):</h3>";
    echo "<table border='1' style='border-collapse:collapse'>";
    echo "<tr><th>Key</th><th>Value</th><th>Type</th></tr>";
    foreach ($settings as $setting) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($setting['setting_key']) . "</td>";
        echo "<td>" . htmlspecialchars($setting['setting_value']) . "</td>";
        echo "<td>" . htmlspecialchars($setting['setting_type']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Test update
    echo "<h3>Testing Update...</h3>";
    $updateStmt = $db->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
    $result = $updateStmt->execute(['Test Value Updated', 'site_name_ar']);
    
    if ($result) {
        echo "<p style='color:green'>✓ Update successful</p>";
        
        // Verify update
        $verifyStmt = $db->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
        $verifyStmt->execute(['site_name_ar']);
        $newValue = $verifyStmt->fetchColumn();
        echo "<p>New value: <strong>" . htmlspecialchars($newValue) . "</strong></p>";
    } else {
        echo "<p style='color:red'>✗ Update failed</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
