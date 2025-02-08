<?php
session_start();
include('db_connect.php'); // Ensure this file is correctly set up

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from database
    $stmt = $conn->prepare("SELECT id, password_hash, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $password_hash, $role);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $password_hash)) {
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Redirect user based on role
            switch ($role) {
                case 'system_admin':
                    header("Location: system_admin_dashboard.php");
                    break;
                case 'hod':
                    header("Location: hod_dashboard.php");
                    break;
                case 'admin_manager':
                    header("Location: admin_manager_dashboard.php");
                    break;
                case 'brand_promotion_manager':
                    header("Location: brand_promotion_dashboard.php");
                    break;
                case 'propagandist':
                    header("Location: propagandist_dashboard.php");
                    break;
                default:
                    header("Location: login.php?error=invalid_role");
                    break;
            }
            exit();
        } else {
            // Invalid password
            header("Location: login.php?error=invalid_credentials");
            exit();
        }
    } else {
        // User not found
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
}
?>
