<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin_manager') {
    header("Location: login.php");
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
    <p>This is your dashboard where you can manage administrative tasks.</p>
</body>
</html>
