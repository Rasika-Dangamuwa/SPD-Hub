<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'propagandist') {
    header("Location: index.php");
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
    <p>This is the Propagandist dashboard.</p>
</body>
</html>
