<?php
require "db_connect.php"; // Include database connection

if ($conn->ping()) {
    echo "✅ Database connection successful!";
} else {
    echo "❌ Database connection failed!";
}

$conn->close();
?>
