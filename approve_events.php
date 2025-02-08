<?php
session_start();
if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] !== "hod" && $_SESSION["role"] !== "admin_manager")) {
    header("Location: index.php");
    exit();
}

require "db_connect.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["event_id"], $_POST["action"])) {
    $event_id = $_POST["event_id"];
    $action = $_POST["action"];
    $approval_note = $_POST["approval_note"] ?? "";
    $approved_by = $_SESSION["user_id"];

    $sql = "UPDATE events SET status = ? WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $action, $event_id);
    $stmt->execute();

    $sql = "INSERT INTO event_approvals (event_id, approved_by, approval_status, approval_note) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $event_id, $approved_by, $action, $approval_note);
    $stmt->execute();
}

$sql = "SELECT * FROM events WHERE status = 'pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approve Events</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Approve Events</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div>
            <p><strong>Event Name:</strong> <?php echo htmlspecialchars($row["event_name"]); ?></p>
            <p><strong>Date:</strong> <?php echo $row["event_date"]; ?></p>
            <p><strong>Time:</strong> <?php echo $row["event_time"]; ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($row["event_location"]); ?></p>
            <form method="POST">
                <input type="hidden" name="event_id" value="<?php echo $row["event_id"]; ?>">
                <label>Approval Note:</label>
                <input type="text" name="approval_note">
                <button type="submit" name="action" value="approved">Approve</button>
                <button type="submit" name="action" value="rejected">Reject</button>
            </form>
        </div>
    <?php endwhile; ?>
</body>
</html>
