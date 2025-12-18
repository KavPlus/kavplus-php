<?php
require_once __DIR__ . '/db.php';

$pdo = db();

$email = "admin@kavplus.com";
$newPass = "admin123";
$hash = password_hash($newPass, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE users SET password = ?, role='admin' WHERE email = ?");
$stmt->execute([$hash, $email]);

echo "DONE. Admin password reset to admin123 for $email";
