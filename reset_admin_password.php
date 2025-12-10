<?php

require_once __DIR__ . '/vendor/autoload.php';
$config = require __DIR__ . '/config/config.php';

// Get database connection
require_once __DIR__ . '/config/database.php';
$db = getDatabase($config);

// New password
$newPassword = 'admin123';
$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

// Update admin password
$stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE email = 'admin@psop.ps'");
$stmt->execute([$hashedPassword]);

if ($stmt->rowCount() > 0) {
    echo "✅ تم تحديث كلمة المرور بنجاح!\n";
    echo "البريد الإلكتروني: admin@psop.ps\n";
    echo "كلمة المرور: admin123\n";
} else {
    echo "❌ فشل التحديث\n";
}

// Verify the password
$stmt = $db->prepare("SELECT password_hash FROM users WHERE email = 'admin@psop.ps'");
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify('admin123', $user['password_hash'])) {
    echo "✅ التحقق من كلمة المرور نجح!\n";
} else {
    echo "❌ التحقق من كلمة المرور فشل!\n";
}
