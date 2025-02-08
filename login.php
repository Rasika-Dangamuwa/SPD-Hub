<?php
session_start();
header("Content-Type: application/json");
require "db_connect.php";

$data = json_decode(file_get_contents("php://input"), true);
$email = $data["email"];
$password = $data["password"];

$sql = $conn->prepare("SELECT user_id, name, password_hash, role FROM users WHERE email = ?");
$sql->bind_param("s", $email);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user["password_hash"])) {
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["role"] = $user["role"];

        $redirect_url = match($user["role"]) {
            "admin" => "admin_dashboard.php",
            "hod" => "hod_dashboard.php",
            "admin_manager" => "admin_manager_dashboard.php",
            "brand_manager" => "brand_manager_dashboard.php",
            "propagandist" => "propagandist_dashboard.php",
            default => "index.php"
        };
        echo json_encode(["success" => true, "redirect" => $redirect_url]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid password"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "User not found"]);
}
$conn->close();
?>
