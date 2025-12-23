<?php
// Test file to verify about.php changes
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>اختبار صفحة من نحن</title>
    <style>
        body { font-family: Arial; padding: 20px; direction: rtl; }
        .success { background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .info { background: #d1ecf1; padding: 15px; border-radius: 5px; margin: 10px 0; }
        code { background: #f8f9fa; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>🔍 فحص ملف about.php</h1>
    
    <?php
    $aboutFile = '../views/home/about.php';
    $content = file_get_contents($aboutFile);
    
    // Check for new classes
    $checks = [
        'vmv-wrapper' => 'التصميم الجديد (vmv-wrapper)',
        'vmv-item' => 'البطاقات الأفقية (vmv-item)',
        'vmv-number' => 'الأرقام الملونة (vmv-number)',
        'vmv-icon-wrapper' => 'غلاف الأيقونة (vmv-icon-wrapper)',
        'أهدافنا' => 'نص "أهدافنا" بدلاً من "قيمنا"'
    ];
    
    echo '<div class="success"><strong>✅ نتائج الفحص:</strong></div>';
    
    foreach ($checks as $search => $label) {
        $found = strpos($content, $search) !== false;
        $status = $found ? '✅' : '❌';
        $class = $found ? 'success' : 'info';
        echo "<div class='$class'>$status $label: " . ($found ? 'موجود' : 'غير موجود') . "</div>";
    }
    
    echo '<hr><div class="info">';
    echo '<strong>📌 التعليمات:</strong><br>';
    echo '1. إذا كانت جميع العلامات ✅ فالملف محدّث<br>';
    echo '2. المشكلة من الـ Browser Cache<br>';
    echo '3. افتح <code>http://localhost:82/psop/public/about</code> في نافذة تصفح خاص (Incognito)<br>';
    echo '4. أو امسح الـ cache: <code>Ctrl + Shift + Delete</code><br>';
    echo '5. أو في Dev Tools: <code>F12</code> ثم كليك يمين على التحديث → Empty Cache and Hard Reload';
    echo '</div>';
    
    echo '<hr><h3>📄 أول 30 سطر من الملف:</h3>';
    echo '<pre style="background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto;">';
    echo htmlspecialchars(implode("\n", array_slice(explode("\n", $content), 0, 30)));
    echo '</pre>';
    ?>
    
    <hr>
    <p><strong>🔗 روابط سريعة:</strong></p>
    <ul>
        <li><a href="/psop/public/about" target="_blank">فتح صفحة من نحن (نافذة جديدة)</a></li>
        <li><a href="/psop/public/about?nocache=<?= time() ?>" target="_blank">فتح صفحة من نحن (مع منع Cache)</a></li>
    </ul>
</body>
</html>
