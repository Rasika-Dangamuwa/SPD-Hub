<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'brand_manager') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Brand Promotion Manager Dashboard</title>
</head>
<body>
    <h1>Welcome, Brand Promotion Manager!</h1>
    <p>This is the Brand Promotion Manager dashboard.</p>
</body>
</html>
