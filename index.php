<?php
session_start();
if (isset($_SESSION['user_role'])) {
    switch ($_SESSION['user_role']) {
        case 'admin':
            header("Location: /SPD-Hub/admin_dashboard.php");
            break;
        case 'hod':
            header("Location: /SPD-Hub/hod_dashboard.php");
            break;
        case 'admin_manager':
            header("Location: /SPD-Hub/admin_manager_dashboard.php");
            break;
        case 'brand_manager':
            header("Location: /SPD-Hub/brand_promotion_dashboard.php");
            break;
        case 'propagandist':
            header("Location: /SPD-Hub/propagandist_dashboard.php");
            break;
        default:
            header("Location: /SPD-Hub/login.php");
            break;
    }
    exit();
} else {
    header("Location: /SPD-Hub/login.php");
    exit();
}
?>
