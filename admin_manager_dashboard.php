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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome, Admin Manager!</h1>

    <a href="logout.php"><button>Logout</button></a>
    <a href="upload_sampling_request.php"><button>Upload Sampling Request Letter</button></a>
</body>
</html>
