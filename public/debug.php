<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Debug Info</title>
</head>
<body>
    <h1>Debug Information</h1>
    
    <h2>Session Data:</h2>
    <pre><?php print_r($_SESSION); ?></pre>
    
    <h2>User Logged In:</h2>
    <p><?php echo isset($_SESSION['user_id']) ? 'Yes - User ID: ' . $_SESSION['user_id'] : 'No'; ?></p>
    
    <h2>Links:</h2>
    <ul>
        <li><a href="/psop/public/login">Login</a></li>
        <li><a href="/psop/public/admin/users">Admin Users</a></li>
        <li><a href="/psop/public/admin/schools">Admin Schools</a></li>
    </ul>
</body>
</html>
