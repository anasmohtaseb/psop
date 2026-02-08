<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>تحديث الصفحة</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            direction: rtl;
        }
        .container {
            background: white;
            color: #333;
            padding: 40px;
            border-radius: 15px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            text-decoration: none;
            margin: 10px;
            font-weight: bold;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .status {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .disabled { background: #fee; color: #c00; }
        .enabled { background: #efe; color: #0a0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔄 تحديث حالة الاشتراكات</h1>
        
        <?php
        require_once __DIR__ . '/../vendor/autoload.php';
        $config = require __DIR__ . '/../config/config.php';
        
        try {
            $settingModel = new \App\Models\SiteSetting($config);
            $value = $settingModel->getValue('enable_subscriptions', '1');
            
            if ($value === '0') {
                echo '<div class="status disabled">';
                echo '<h2>❌ الاشتراكات معطلة</h2>';
                echo '<p>يجب أن تظهر رسالة "Subscriptions Unavailable"</p>';
                echo '</div>';
            } else {
                echo '<div class="status enabled">';
                echo '<h2>✅ الاشتراكات مفعلة</h2>';
                echo '<p>يجب أن تظهر صفحة الخطط</p>';
                echo '</div>';
            }
        } catch (Exception $e) {
            echo '<div class="status disabled"><p>خطأ: ' . htmlspecialchars($e->getMessage()) . '</p></div>';
        }
        ?>
        
        <p>اضغط على الزر أدناه لفتح صفحة الاشتراكات مع منع التخزين المؤقت:</p>
        
        <a href="/psop/public/subscriptions/plans?nocache=<?= time() ?>" class="btn" target="_blank">
            📋 فتح صفحة الاشتراكات
        </a>
        
        <br><br>
        
        <a href="/psop/public/admin/settings" class="btn" target="_blank">
            ⚙️ إعدادات الموقع
        </a>
        
        <br><br>
        
        <small style="color: #666;">آخر تحديث: <?= date('Y-m-d H:i:s') ?></small>
    </div>
    
    <script>
        // Auto refresh every 3 seconds to show current status
        setTimeout(function() {
            location.reload();
        }, 3000);
    </script>
</body>
</html>
