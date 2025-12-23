<?php
/**
 * Check PHP upload configuration
 */
header('Content-Type: text/html; charset=utf-8');

echo "<h2>PHP Upload Configuration</h2>";
echo "<table border='1' style='border-collapse:collapse; padding:10px;'>";
echo "<tr><th style='padding:10px; text-align:left;'>Setting</th><th style='padding:10px; text-align:left;'>Value</th></tr>";

$settings = [
    'file_uploads' => ini_get('file_uploads'),
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'max_file_uploads' => ini_get('max_file_uploads'),
    'upload_tmp_dir' => ini_get('upload_tmp_dir') ?: sys_get_temp_dir(),
    'max_execution_time' => ini_get('max_execution_time'),
];

foreach ($settings as $key => $value) {
    $color = 'white';
    if ($key === 'file_uploads' && !$value) {
        $color = '#ffcccc';
    }
    echo "<tr style='background:{$color}'>";
    echo "<td style='padding:10px;'><strong>{$key}</strong></td>";
    echo "<td style='padding:10px;'>" . htmlspecialchars($value) . "</td>";
    echo "</tr>";
}

echo "</table>";

// Check temp directory
$tmpDir = ini_get('upload_tmp_dir') ?: sys_get_temp_dir();
echo "<h3>Upload Temp Directory</h3>";
echo "<p><strong>Path:</strong> " . htmlspecialchars($tmpDir) . "</p>";

if (is_dir($tmpDir)) {
    echo "<p style='color:green;'>✓ Directory exists</p>";
    if (is_writable($tmpDir)) {
        echo "<p style='color:green;'>✓ Directory is writable</p>";
    } else {
        echo "<p style='color:red;'>✗ Directory is NOT writable</p>";
    }
} else {
    echo "<p style='color:red;'>✗ Directory does NOT exist</p>";
}

// Check destination directory
$destDir = __DIR__ . '/../public/assets/images/';
echo "<h3>Destination Directory</h3>";
echo "<p><strong>Path:</strong> " . htmlspecialchars($destDir) . "</p>";

if (is_dir($destDir)) {
    echo "<p style='color:green;'>✓ Directory exists</p>";
    if (is_writable($destDir)) {
        echo "<p style='color:green;'>✓ Directory is writable</p>";
    } else {
        echo "<p style='color:red;'>✗ Directory is NOT writable</p>";
    }
} else {
    echo "<p style='color:red;'>✗ Directory does NOT exist</p>";
}

// Test upload form
?>
<h3>Test Upload Form</h3>
<form method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF'] ?>">
    <input type="file" name="test_file" accept="image/*">
    <button type="submit">Test Upload</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_file'])) {
    echo "<h3>Upload Test Results</h3>";
    echo "<pre>";
    print_r($_FILES['test_file']);
    echo "</pre>";
    
    if ($_FILES['test_file']['error'] === UPLOAD_ERR_OK) {
        $testPath = $destDir . 'test_upload_' . time() . '.tmp';
        if (move_uploaded_file($_FILES['test_file']['tmp_name'], $testPath)) {
            echo "<p style='color:green;'>✓ File uploaded successfully to: " . htmlspecialchars($testPath) . "</p>";
            if (file_exists($testPath)) {
                unlink($testPath);
                echo "<p style='color:green;'>✓ Test file cleaned up</p>";
            }
        } else {
            echo "<p style='color:red;'>✗ Failed to move uploaded file</p>";
        }
    } else {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL => 'File only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension',
        ];
        $errorCode = $_FILES['test_file']['error'];
        echo "<p style='color:red;'>✗ Upload error: " . ($errors[$errorCode] ?? "Unknown error {$errorCode}") . "</p>";
    }
}
