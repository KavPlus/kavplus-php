<?php
// Start session on every protected page
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user NOT logged in → redirect to login page
if (!isset($_SESSION["user_id"])) {
    // Store last page so after login user comes back
    $_SESSION["redirect_after_login"] = $_SERVER["REQUEST_URI"];
    header("Location: login.php");
    exit;
}
?>
