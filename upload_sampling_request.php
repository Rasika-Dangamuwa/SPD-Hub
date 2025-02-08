<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin_manager') {
    header("Location: index.php");
    exit();
}

$error = "";

// Handle File Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['sampling_letter']) && $_FILES['sampling_letter']['error'] === UPLOAD_ERR_OK) {
        
        $upload_dir = "uploads/";

        // Check if the uploads folder exists, if not, create it
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_path = $upload_dir . basename($_FILES["sampling_letter"]["name"]);
        
        if (move_uploaded_file($_FILES["sampling_letter"]["tmp_name"], $file_path)) {
            // Call AI Processing Script
            header("Location: process_sampling_request.php?file=" . urlencode($file_path));
            exit();
        } else {
            $error = "File upload failed. Please check folder permissions.";
        }
    } else {
        $error = "Please upload a valid file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Sampling Request Letter</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Upload Sampling Request Letter</h1>
    <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
    <form method="POST" action="upload_sampling_request.php" enctype="multipart/form-data">
        <label>Select Letter (PDF or Image):</label>
        <input type="file" name="sampling_letter" accept=".pdf,.jpg,.jpeg,.png" required>
        <button type="submit">Upload Letter</button>
    </form>
</body>
</html>
