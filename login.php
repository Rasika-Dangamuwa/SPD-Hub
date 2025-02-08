<?php
session_start();
if (password_verify($password, $password_hash)) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_role'] = $role;

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

?>
