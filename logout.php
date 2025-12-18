<?php
session_start();

/* Clear remember-me cookie */
if (isset($_COOKIE['remember_user'])) {
    setcookie('remember_user', '', time() - 3600, '/');
}

/* Clear session */
$_SESSION = [];
session_destroy();

/* Redirect to login */
header("Location: login.php");
exit;
