<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'hod') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HOD Dashboard</title>
</head>
<body>
    <h1>Welcome, HOD!</h1>
    <p>Manage approvals and oversee system activities here.</p>
</body>
</html>
