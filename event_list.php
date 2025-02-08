<?php
session_start();
if (!isset($_SESSION["user_id"]) || !in_array($_SESSION["role"], ['admin_manager', 'brand_manager', 'hod'])) {
    header("Location: index.php");
    exit();
}

require "db_connect.php";

$sql = "SELECT e.event_id, e.event_name, e.event_date, e.event_time, e.location, e.status, u.name AS requested_by 
        FROM events e JOIN users u ON e.requested_by = u.user_id";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["approve"])) {
    $event_id = $_POST["event_id"];
    $approver_id = $_SESSION["user_id"];
    $stmt = $conn->prepare("UPDATE events SET status = 'Approved', approved_by = ? WHERE event_id = ?");
    $stmt->bind_param("ii", $approver_id, $event_id);
    if ($stmt->execute()) {
        echo "<script>alert('Event Approved!'); window.location.href='events_list.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Event List</h2>
    <table>
        <tr><th>ID</th><th>Name</th><th>Date</th><th>Time</th><th>Location</th><th>Requested By</th><th>Status</th><th>Actions</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["event_id"]; ?></td>
                <td><?php echo htmlspecialchars($row["event_name"]); ?></td>
                <td><?php echo $row["event_date"]; ?></td>
                <td><?php echo $row["event_time"]; ?></td>
                <td><?php echo htmlspecialchars($row["location"]); ?></td>
                <td><?php echo htmlspecialchars($row["requested_by"]); ?></td>
                <td><?php echo htmlspecialchars($row["status"]); ?></td>
                <td>
                    <?php if ($row["status"] == "Pending" && $_SESSION["role"] == "hod"): ?>
                        <form method="POST">
                            <input type="hidden" name="event_id" value="<?php echo $row["event_id"]; ?>">
                            <button type="submit" name="approve">Approve</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="create_event.php">Create New Event</a>
</body>
</html>
