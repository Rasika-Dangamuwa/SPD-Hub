<?php
session_start();
include('db_connect.php'); // Ensure database connection

// Check if user is already logged in
if (isset($_SESSION['user_role'])) {
    // Redirect based on role
    switch ($_SESSION['user_role']) {
        case 'admin':
            header("Location: admin_dashboard.php");
            break;
        case 'hod':
            header("Location: hod_dashboard.php");
            break;
        case 'admin_manager':
            header("Location: admin_manager_dashboard.php");
            break;
        case 'brand_manager':
            header("Location: brand_promotion_dashboard.php");
            break;
        case 'propagandist':
            header("Location: propagandist_dashboard.php");
            break;
        default:
            header("Location: index.php?error=invalid_role");
            break;
    }
    exit();
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user from database
    $stmt = $conn->prepare("SELECT user_id, password_hash, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $password_hash, $role);
        $stmt->fetch();

        if (password_verify($password, $password_hash)) {
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_role'] = $role;

            // Redirect based on role
            switch ($role) {
                case 'admin':
                    header("Location: admin_dashboard.php");
                    break;
                case 'hod':
                    header("Location: hod_dashboard.php");
                    break;
                case 'admin_manager':
                    header("Location: admin_manager_dashboard.php");
                    break;
                case 'brand_manager':
                    header("Location: brand_promotion_dashboard.php");
                    break;
                case 'propagandist':
                    header("Location: propagandist_dashboard.php");
                    break;
                default:
                    header("Location: index.php?error=invalid_role");
                    break;
            }
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPD-Hub Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>SPD-Hub Login</h2>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST" action="index.php">
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
