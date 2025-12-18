<?php
require_once 'db.php';

$pdo = db();
$pdo->prepare("
  INSERT INTO users (name,email,password,created_at)
  VALUES (?,?,?,?)
")->execute([
  'Test User',
  'test@kavplus.com',
  password_hash('123456', PASSWORD_DEFAULT),
  date('Y-m-d H:i:s')
]);

echo "User created";
