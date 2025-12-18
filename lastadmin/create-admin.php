<?php
require_once __DIR__ . '/db.php';

$pdo = db();

$email = 'admin@kavplus.com';
$password = 'admin123'; // change later

$stmt = $pdo->prepare("SELECT id FROM users WHERE email=?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
    exit("Admin already exists");
}

$stmt = $pdo->prepare("
    INSERT INTO users (name, email, password, role, status, created_at)
    VALUES (?, ?, ?, 'admin', 'ACTIVE', ?)
");

$stmt->execute([
    'Admin',
    $email,
    password_hash($password, PASSWORD_DEFAULT),
    date('Y-m-d H:i:s')
]);

echo "✅ Admin created<br>Email: $email<br>Password: $password";
