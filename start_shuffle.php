<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "propagandist") {
    header("Location: index.php");
    exit();
}
require "db_connect.php";

// Fetch Available Events
$event_query = "SELECT * FROM events WHERE status = 'Approved'";
$events = $conn->query($event_query);

// Fetch Available Premium Breakdowns
$breakdown_query = "SELECT * FROM premium_breakdowns WHERE is_locked = FALSE";
$breakdowns = $conn->query($breakdown_query);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $event_id = $_POST["event_id"];
    $breakdown_id = $_POST["breakdown_id"];
    $flaps_count = $_POST["flaps_count"];

    // Lock the Breakdown
    $conn->query("UPDATE premium_breakdowns SET is_locked = TRUE WHERE breakdown_id = $breakdown_id");

    // Insert into Shuffle
    $stmt = $conn->prepare("INSERT INTO premium_shuffles (event_id, breakdown_id, flaps_count) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $event_id, $breakdown_id, $flaps_count);

    if ($stmt->execute()) {
        echo "<script>alert('Premium Shuffle Started Successfully!'); window.location.href='shuffle_draw.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Start Premium Shuffle</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Start Premium Shuffle</h2>
    <form method="POST">
        <label>Select Event:</label>
        <select name="event_id" required>
            <?php while ($event = $events->fetch_assoc()): ?>
                <option value="<?php echo $event["event_id"]; ?>">
                    <?php echo htmlspecialchars($event["event_name"]) . " - " . $event["event_date"]; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Select Breakdown:</label>
        <select name="breakdown_id" required>
            <?php while ($breakdown = $breakdowns->fetch_assoc()): ?>
                <option value="<?php echo $breakdown["breakdown_id"]; ?>">
                    <?php echo htmlspecialchars($breakdown["breakdown_name"]) . " - " . $breakdown["flap_count"] . " Flaps"; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Flaps Achieved:</label>
        <input type="number" name="flaps_count" required>

        <button type="submit">Start Shuffle</button>
    </form>
</body>
</html>
