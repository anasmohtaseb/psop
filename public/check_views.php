<?php
/**
 * Diagnostic script to check views directory structure
 * Upload this to public/ on production server and access via browser
 */

// Load config
$config = require __DIR__ . '/../config/config.php';

echo "<h1>Views Directory Diagnostic</h1>";
echo "<pre>";

$viewsPath = $config['paths']['views'];
echo "Views Path: " . $viewsPath . "\n";
echo "Views Path Exists: " . (file_exists($viewsPath) ? 'YES' : 'NO') . "\n";
echo "Views Path Readable: " . (is_readable($viewsPath) ? 'YES' : 'NO') . "\n\n";

// Check admin/schools directory
$schoolsPath = $viewsPath . '/admin/schools';
echo "Schools Views Path: " . $schoolsPath . "\n";
echo "Schools Path Exists: " . (file_exists($schoolsPath) ? 'YES' : 'NO') . "\n";
echo "Schools Path Readable: " . (is_readable($schoolsPath) ? 'YES' : 'NO') . "\n\n";

// Check specific file
$editFile = $schoolsPath . '/edit.php';
echo "Edit File Path: " . $editFile . "\n";
echo "Edit File Exists: " . (file_exists($editFile) ? 'YES' : 'NO') . "\n";
echo "Edit File Readable: " . (is_readable($editFile) ? 'YES' : 'NO') . "\n";

if (file_exists($editFile)) {
    echo "Edit File Size: " . filesize($editFile) . " bytes\n";
    echo "Edit File Permissions: " . substr(sprintf('%o', fileperms($editFile)), -4) . "\n";
}

echo "\n--- Admin Directory Structure ---\n";
if (file_exists($viewsPath . '/admin')) {
    $adminDirs = scandir($viewsPath . '/admin');
    foreach ($adminDirs as $dir) {
        if ($dir !== '.' && $dir !== '..') {
            echo "  " . $dir . "/\n";
            if (is_dir($viewsPath . '/admin/' . $dir)) {
                $files = scandir($viewsPath . '/admin/' . $dir);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        echo "    - " . $file . "\n";
                    }
                }
            }
        }
    }
} else {
    echo "admin directory does NOT exist!\n";
}

echo "\n--- All Views Files in admin/schools ---\n";
if (file_exists($schoolsPath)) {
    $files = scandir($schoolsPath);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $fullPath = $schoolsPath . '/' . $file;
            $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
            $size = filesize($fullPath);
            $readable = is_readable($fullPath) ? 'R' : '-';
            echo "  {$file} [{$perms}] [{$readable}] {$size} bytes\n";
        }
    }
} else {
    echo "schools directory does NOT exist!\n";
}

echo "\n--- PHP Info ---\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "\n";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "\n";
echo "Script Filename: " . __FILE__ . "\n";

echo "</pre>";
