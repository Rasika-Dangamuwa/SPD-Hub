<?php
session_start();
include('db_connect.php'); // Ensure this file contains your database connection logic

// Check if the user is already logged in
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
            header("Location: login.php?error=invalid_role");
            break;
    }
    exit();
}

// Initialize error message
$error = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT user_id, password_hash, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if user exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $password_hash, $role);
            $stmt->fetch();

            // Verify password
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
                        $error = 'Invalid role assigned.';
                        break;
                }
                exit();
            } else {
                $error = 'Incorrect password.';
            }
        } else {
            $error = 'No account found with that email.';
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPD-Hub Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Ensure this path is correct -->
</head>
<body>
    <div class="login-container">
        <h2>Login to SPD-Hub</h2>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST" action="login.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
