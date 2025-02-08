<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'brand_promotion_manager') {
    header("Location: login.php");
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
    <p>Manage brand promotions and track events here.</p>
</body>
</html>
