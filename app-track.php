<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

$log = [
  'time' => date('Y-m-d H:i:s'),
  'platform' => $data['platform'] ?? 'unknown',
  'ip' => $_SERVER['REMOTE_ADDR'],
  'ua' => $_SERVER['HTTP_USER_AGENT']
];

/* SIMPLE LOG (upgrade to DB later) */
file_put_contents(
  __DIR__.'/app-installs.log',
  json_encode($log).PHP_EOL,
  FILE_APPEND
);

echo json_encode(['ok'=>true]);
