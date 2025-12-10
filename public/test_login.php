<?php
session_start();
$_SESSION['user_id'] = 1;
$_SESSION['user'] = ['id' => 1, 'name' => 'Admin', 'type' => 'admin', 'roles' => ['admin']];

// Redirect to schools page
header('Location: http://localhost/psop/public/admin/schools');
