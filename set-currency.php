<?php
session_start();

if (isset($_POST['currency'])) {
  $_SESSION['currency'] = $_POST['currency'];
}

/* Redirect back */
header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
exit;
