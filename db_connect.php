<?php
$servername = "sql213.infinityfree.com"; // Use "localhost" instead of "127.0.0.1"
$username = "if0_38272929";        // MySQL default username
$password = "Hibabycool762";            // Default XAMPP password is empty
$database = "if0_38272929_spd_hub";     // Database name

// Create a connection to MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("❌ Database Connection Failed: " . $conn->connect_error);
}

// Set MySQL character set to UTF-8 (for compatibility)
$conn->set_charset("utf8mb4");

?>
