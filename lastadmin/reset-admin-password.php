<?php
require_once __DIR__ . '/db.php';

$pdo = db();

$newPassword = 'admin123';

$stmt = $pdo->prepare("
    UPDATE users
    SET password = ?
    WHERE email = 'admin@kavplus.com'
");

$stmt->execute([
    password_hash($newPassword, PASSWORD_DEFAULT)
]);

echo "Admin password reset to: admin123";
