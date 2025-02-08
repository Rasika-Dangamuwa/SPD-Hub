<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'hod') {
    header("Location: index.php");
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
    <p>This is the Head of Department dashboard.</p>
</body>
</html>
