<?php
session_start();

/* =========================
   ADMIN LOGOUT
========================= */

/*
  We only destroy admin session,
  NOT user session (important for shared login systems)
*/

// Unset admin data only
if (isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
}

// Optional: regenerate session ID for security
session_regenerate_id(true);

// Optional flash message (if you want later)
$_SESSION['logout_message'] = 'You have been logged out successfully';

// Redirect to admin login
header("Location: admin-login.php");
exit;
