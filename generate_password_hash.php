<?php
$password = "admin123"; // Change this to generate hashes for different passwords
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed Password: " . $hashed_password;
?>
