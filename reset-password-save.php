<?php
require "db.php";

$token = $_POST["token"];
$pass1 = $_POST["password"];
$pass2 = $_POST["confirm_password"];

if ($pass1 !== $pass2) {
    die("Passwords do not match.");
}

// Hash the password
$hash = password_hash($pass1, PASSWORD_DEFAULT);

// Save new password
$stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expire = NULL WHERE reset_token = ?");
$stmt->bind_param("ss", $hash, $token);
$stmt->execute();

header("Location: reset-password-success.php");
exit;
