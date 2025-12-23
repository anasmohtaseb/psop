<?php
/**
 * Script CLI لاستيراد جداول إدارة الصفحات
 * تشغيل من سطر الأوامر: php database/import_pages_cli.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/config.php';

echo "\n===========================================\n";
echo "   استيراد جداول إدارة الصفحات\n";
echo "===========================================\n\n";

try {
    // الاتصال بقاعدة البيانات
    $dsn = "mysql:host={$config['database']['host']};dbname={$config['database']['database']};charset=utf8mb4";
    
    echo "🔌 الاتصال بقاعدة البيانات...\n";
    echo "   المضيف: {$config['database']['host']}\n";
    echo "   قاعدة البيانات: {$config['database']['database']}\n\n";
    
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
    
    echo "✅ تم الاتصال بنجاح!\n\n";
    
    // قراءة ملف SQL
    $sqlFile = __DIR__ . '/pages.sql';
    
    if (!file_exists($sqlFile)) {
        die("❌ ملف SQL غير موجود: {$sqlFile}\n");
    }
    
    echo "📁 قراءة ملف SQL: {$sqlFile}\n\n";
    
    $sql = file_get_contents($sqlFile);
    
    // إزالة التعليقات
    $sql = preg_replace('/^--.*$/m', '', $sql);
    
    // تنفيذ الملف بالكامل كمجموعة واحدة
    // تقسيم عند SET @ لتنفيذ المتغيرات بشكل منفصل
    $statements = [];
    
    // تقسيم بناءً على الفاصلة المنقوطة مع تجاهل الفاصلة المنقوطة داخل الأقواس
    $currentStatement = '';
    $inString = false;
    $stringChar = '';
    
    for ($i = 0; $i < strlen($sql); $i++) {
        $char = $sql[$i];
        
        // التحقق من بداية/نهاية النص
        if (($char === '"' || $char === "'") && ($i === 0 || $sql[$i-1] !== '\\')) {
            if (!$inString) {
                $inString = true;
                $stringChar = $char;
            } elseif ($char === $stringChar) {
                $inString = false;
            }
        }
        
        // إضافة الحرف
        $currentStatement .= $char;
        
        // إذا وصلنا للفاصلة المنقوطة خارج النصوص
        if ($char === ';' && !$inString) {
            $stmt = trim($currentStatement);
            if (!empty($stmt) && strlen($stmt) > 5) {
                $statements[] = $stmt;
            }
            $currentStatement = '';
        }
    }
    
    // إضافة آخر استعلام إن وجد
    if (!empty(trim($currentStatement))) {
        $statements[] = trim($currentStatement);
    }
    
    echo "📊 عدد الاستعلامات: " . count($statements) . "\n";
    echo "===========================================\n\n";
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($statements as $index => $statement) {
        $statement = trim($statement);
        if (empty($statement)) continue;
        
        $num = $index + 1;
        echo "[{$num}/" . count($statements) . "] ";
        
        try {
            $pdo->exec($statement);
            $successCount++;
            
            // عرض ملخص للاستعلام
            if (stripos($statement, 'CREATE TABLE') !== false) {
                preg_match('/CREATE TABLE.*?`(\w+)`/i', $statement, $matches);
                $tableName = $matches[1] ?? 'unknown';
                echo "✅ تم إنشاء جدول: {$tableName}\n";
            } elseif (stripos($statement, 'INSERT INTO') !== false) {
                preg_match('/INSERT INTO\s+`?(\w+)`?/i', $statement, $matches);
                $tableName = $matches[1] ?? 'unknown';
                echo "✅ تم إدراج بيانات في: {$tableName}\n";
            } elseif (stripos($statement, 'SET @') !== false) {
                echo "✅ تم تعيين متغير\n";
            } else {
                echo "✅ تم تنفيذ الاستعلام\n";
            }
            
        } catch (PDOException $e) {
            $errorCount++;
            echo "❌ خطأ: " . $e->getMessage() . "\n";
            
            // عرض جزء من الاستعلام الذي فشل
            $preview = substr($statement, 0, 100);
            if (strlen($statement) > 100) {
                $preview .= '...';
            }
            echo "   الاستعلام: {$preview}\n";
        }
    }
    
    echo "\n===========================================\n";
    echo "   ملخص العملية\n";
    echo "===========================================\n";
    echo "✅ نجح: {$successCount} استعلام\n";
    echo "❌ فشل: {$errorCount} استعلام\n";
    
    if ($errorCount == 0) {
        echo "\n🎉 تم استيراد جميع الجداول بنجاح!\n";
        echo "\n📌 الخطوات التالية:\n";
        echo "   1. افتح لوحة التحكم → إدارة الصفحات\n";
        echo "   2. عدّل محتوى صفحة 'عن البوابة'\n";
        echo "   3. عاين الصفحة على: http://localhost/psop/public/about\n";
    }
    
    echo "\n";
    
} catch (PDOException $e) {
    echo "\n❌ خطأ في الاتصال بقاعدة البيانات:\n";
    echo "   " . $e->getMessage() . "\n\n";
    echo "📌 تأكد من:\n";
    echo "   - تشغيل خادم MySQL (XAMPP)\n";
    echo "   - صحة بيانات الاتصال في ملف .env\n";
    echo "   - وجود قاعدة البيانات: {$config['database']['database']}\n\n";
    exit(1);
}
