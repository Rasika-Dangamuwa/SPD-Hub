<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin_manager') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Manager Dashboard</title>
</head>
<body>
    <h1>Welcome, Admin Manager!</h1>
    <p>This is the Admin Manager dashboard.</p>
</body>
</html>
