session_start();
include('db_connect.php'); // Ensure database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user credentials
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

            // Role-based redirection with correct paths
            switch ($role) {
                case 'admin':
                    header("Location: /SPD_Hub/admin_dashboard.php");
                    break;
                case 'hod':
                    header("Location: /SPD_Hub/hod_dashboard.php");
                    break;
                case 'admin_manager':
                    header("Location: /SPD_Hub/admin_manager_dashboard.php");
                    break;
                case 'brand_manager':
                    header("Location: /SPD_Hub/brand_promotion_dashboard.php");
                    break;
                case 'propagandist':
                    header("Location: /SPD_Hub/propagandist_dashboard.php");
                    break;
                default:
                    header("Location: /SPD_Hub/login.php?error=invalid_role");
                    break;
            }
            exit();
        } else {
            header("Location: /SPD_Hub/login.php?error=invalid_credentials");
            exit();
        }
    } else {
        header("Location: /SPD_Hub/login.php?error=invalid_credentials");
        exit();
    }
}
