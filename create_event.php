<?php
session_start();
if (!isset($_SESSION["user_id"]) || !in_array($_SESSION["role"], ['admin_manager', 'brand_manager', 'hod'])) {
    header("Location: events_list.php"); // Redirect unauthorized users
    exit();
}
require "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $event_name = $_POST["event_name"];
    $event_date = $_POST["event_date"];
    $event_time = $_POST["event_time"];
    $location = $_POST["location"];
    $requested_by = $_SESSION["user_id"];

    $stmt = $conn->prepare("INSERT INTO events (event_name, event_date, event_time, location, requested_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $event_name, $event_date, $event_time, $location, $requested_by);
    if ($stmt->execute()) {
        echo "<script>alert('Event Created Successfully!'); window.location.href='events_list.php';</script>";
    } else {
        echo "<script>alert('Error creating event');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Event</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Create Event</h2>
    <form method="POST">
        <label>Event Name:</label>
        <input type="text" name="event_name" required>
        
        <label>Event Date:</label>
        <input type="date" name="event_date" required>

        <label>Event Time:</label>
        <input type="time" name="event_time" required>

        <label>Location:</label>
        <input type="text" name="location" required>

        <button type="submit">Create Event</button>
    </form>
    <a href="events_list.php">View Events</a>
</body>
</html>
