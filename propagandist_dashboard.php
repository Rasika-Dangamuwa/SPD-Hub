<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'propagandist') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Propagandist Dashboard</title>
</head>
<body>
    <h1>Welcome, Propagandist!</h1>
    <p>Execute promotional events and manage gift distribution.</p>
</body>
</html>
