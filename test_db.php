<?php
$servername = "sql213.infinityfree.com";
$username = "if0_38272929";
$password = "Hibabycool762";
$database = "if0_38272929_spd_hub";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
echo "✅ Database Connection Successful!";

// Fetch a sample record from the users table
$sql = "SELECT * FROM users LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<br>✅ Data fetched successfully!";
    while ($row = $result->fetch_assoc()) {
        echo "<br>User ID: " . $row["user_id"] . " - Name: " . $row["username"];
    }
} else {
    echo "<br>❌ No data found in the users table.";
}
?>
