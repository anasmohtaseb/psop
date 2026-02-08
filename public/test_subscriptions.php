<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Test Subscriptions Setting</title>
    <style>
        body { font-family: Arial; padding: 20px; direction: rtl; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h1>🔍 اختبار إعداد الاشتراكات</h1>
    
    <?php
    require_once __DIR__ . '/../vendor/autoload.php';
    $config = require __DIR__ . '/../config/config.php';
    
    echo '<h2>1️⃣ قراءة الإعداد من قاعدة البيانات:</h2>';
    try {
        $settingModel = new \App\Models\SiteSetting($config);
        $value = $settingModel->getValue('enable_subscriptions', '1');
        
        echo '<ul>';
        echo '<li>القيمة المخزنة: <strong>' . htmlspecialchars($value) . '</strong></li>';
        echo '<li>نوع البيانات: <strong>' . gettype($value) . '</strong></li>';
        echo '<li>هل تساوي "0"؟: <strong>' . ($value === '0' ? '✅ نعم' : '❌ لا') . '</strong></li>';
        echo '<li>هل تساوي "1"؟: <strong>' . ($value === '1' ? '✅ نعم' : '❌ لا') . '</strong></li>';
        echo '</ul>';
        
        if ($value === '0') {
            echo '<p class="success">✅ الاشتراكات معطلة - يجب عرض صفحة "Subscriptions Unavailable"</p>';
        } else {
            echo '<p class="error">⚠️ الاشتراكات مفعلة - سيتم عرض صفحة الخطط</p>';
        }
        
    } catch (Exception $e) {
        echo '<p class="error">خطأ: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    
    echo '<hr>';
    echo '<h2>2️⃣ محاكاة كود SubscriptionController::plans():</h2>';
    
    try {
        $settingModel = new \App\Models\SiteSetting($config);
        
        echo '<pre style="background: #f5f5f5; padding: 10px; border-radius: 5px;">';
        echo 'if ($this->settingModel->getValue(\'enable_subscriptions\', \'1\') === \'0\') {' . "\n";
        echo '    // عرض صفحة disabled' . "\n";
        echo '    return;' . "\n";
        echo '}' . "\n";
        echo '</pre>';
        
        $checkValue = $settingModel->getValue('enable_subscriptions', '1');
        $shouldShowDisabled = $checkValue === '0';
        
        if ($shouldShowDisabled) {
            echo '<p class="success">✅ الشرط صحيح - سيتم عرض صفحة "disabled"</p>';
        } else {
            echo '<p class="error">❌ الشرط خاطئ - سيتم عرض صفحة الخطط</p>';
        }
        
    } catch (Exception $e) {
        echo '<p class="error">خطأ: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    
    echo '<hr>';
    echo '<h2>3️⃣ الروابط:</h2>';
    echo '<ul>';
    echo '<li><a href="/psop/public/subscriptions/plans" target="_blank">افتح صفحة الاشتراكات</a></li>';
    echo '<li><a href="/psop/public/admin/settings" target="_blank">إعدادات الموقع (Admin)</a></li>';
    echo '</ul>';
    ?>
</body>
</html>
