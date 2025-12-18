<?php
require_once __DIR__ . '/db.php';

$pdo = db();

$email = 'admin@kavplus.com';
$password = 'admin123';

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    INSERT OR IGNORE INTO users
    (name, email, password, role, status, created_at)
    VALUES (?, ?, ?, 'admin', 'ACTIVE', datetime('now'))
");

$stmt->execute([
    'Admin',
    $email,
    $hash
]);

echo "✅ Admin created<br>Email: admin@kavplus.com<br>Password: admin123";
