<?php
session_start();

// Define admin credentials
define('ADMIN_USERNAME', 'ocvet');
// Generate a new hash using password_hash('your_password', PASSWORD_DEFAULT)
define('ADMIN_PASSWORD_HASH', '$2y$10$Eo1klLMihWJwrsVX.52G2.PW2TS3s6caRfagQNYycEeUmUwi6Kb7m'); // Update this after rehashing your password

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? '');
    $password = $_POST["password"] ?? '';

    // Validate credentials
    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        header("Location: OCVETadmindb.php");
        exit;
    } else {
        header("Location: OCVETadmin.html?error=invalid");
        exit;
    }
} else {
    // Redirect to login page if accessed directly
    header("Location: OCVETadmin.html");
    exit;
}
?>
