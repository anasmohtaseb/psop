<?php
/**
 * Script لاستيراد جداول إدارة الصفحات
 * تشغيل من المتصفح: http://localhost/psop/public/import_pages.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/config.php';

try {
    // الاتصال بقاعدة البيانات
    $dsn = "mysql:host={$config['database']['host']};dbname={$config['database']['database']};charset=utf8mb4";
    $pdo = new PDO(
        $dsn,
        $config['database']['username'],
        $config['database']['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
    
    // قراءة ملف SQL
    $sqlFile = __DIR__ . '/../database/pages.sql';
    
    if (!file_exists($sqlFile)) {
        die("❌ ملف SQL غير موجود: {$sqlFile}");
    }
    
    $sql = file_get_contents($sqlFile);
    
    // تقسيم الاستعلامات
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        function($stmt) {
            return !empty($stmt) && !preg_match('/^--/', $stmt);
        }
    );
    
    echo "<!DOCTYPE html>
<html dir='rtl' lang='ar'>
<head>
    <meta charset='UTF-8'>
    <title>استيراد جداول الصفحات</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 40px; background: #f0f4f8; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        h1 { color: #e11d48; border-bottom: 3px solid #e11d48; padding-bottom: 15px; }
        .success { background: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 8px; margin: 10px 0; border-right: 4px solid #22c55e; }
        .error { background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin: 10px 0; border-right: 4px solid #ef4444; }
        .info { background: #e0f2fe; color: #075985; padding: 12px 16px; border-radius: 8px; margin: 10px 0; border-right: 4px solid #0ea5e9; }
        .statement { background: #f8fafc; padding: 10px; margin: 8px 0; border-radius: 6px; font-family: monospace; font-size: 13px; }
        .btn { display: inline-block; padding: 12px 24px; background: #e11d48; color: white; text-decoration: none; border-radius: 8px; margin-top: 20px; font-weight: 600; }
        .btn:hover { background: #be123c; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🗄️ استيراد جداول إدارة الصفحات</h1>
        <div class='info'>
            <strong>📁 الملف:</strong> database/pages.sql<br>
            <strong>📊 عدد الاستعلامات:</strong> " . count($statements) . "
        </div>
";
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($statements as $index => $statement) {
        $statement = trim($statement);
        if (empty($statement)) continue;
        
        try {
            $pdo->exec($statement);
            $successCount++;
            
            // عرض ملخص للاستعلام
            $preview = substr($statement, 0, 100);
            if (strlen($statement) > 100) {
                $preview .= '...';
            }
            
            echo "<div class='success'>✅ نجح الاستعلام #" . ($index + 1) . "</div>";
            echo "<div class='statement'>" . htmlspecialchars($preview) . "</div>";
            
        } catch (PDOException $e) {
            $errorCount++;
            echo "<div class='error'>❌ فشل الاستعلام #" . ($index + 1) . ": " . htmlspecialchars($e->getMessage()) . "</div>";
            echo "<div class='statement'>" . htmlspecialchars(substr($statement, 0, 200)) . "</div>";
        }
    }
    
    echo "
        <div style='margin-top: 30px; padding: 20px; background: linear-gradient(135deg, #fdf2f8, #fff5f7); border-radius: 10px;'>
            <h2 style='margin-top: 0; color: #334155;'>📊 ملخص العملية</h2>
            <p><strong>✅ نجح:</strong> {$successCount} استعلام</p>
            <p><strong>❌ فشل:</strong> {$errorCount} استعلام</p>
        </div>
        
        <a href='/psop/public/admin/pages' class='btn'>🎯 الانتقال لإدارة الصفحات</a>
        <a href='/psop/public/about' class='btn' style='background: #64748b; margin-right: 10px;'>👀 معاينة الصفحة</a>
    </div>
</body>
</html>";
    
} catch (PDOException $e) {
    echo "<!DOCTYPE html>
<html dir='rtl' lang='ar'>
<head>
    <meta charset='UTF-8'>
    <title>خطأ في الاتصال</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 40px; background: #fee2e2; }
        .error-box { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; border: 3px solid #ef4444; }
        h1 { color: #991b1b; }
    </style>
</head>
<body>
    <div class='error-box'>
        <h1>❌ خطأ في الاتصال بقاعدة البيانات</h1>
        <p><strong>الرسالة:</strong> " . htmlspecialchars($e->getMessage()) . "</p>
        <p>تأكد من:</p>
        <ul>
            <li>تشغيل خادم MySQL</li>
            <li>صحة بيانات الاتصال في ملف .env</li>
            <li>وجود قاعدة البيانات psop_db</li>
        </ul>
    </div>
</body>
</html>";
}
