<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['passenger'], $data['seat'], $data['price'])) {
  echo json_encode(['success'=>false]);
  exit;
}

if (!isset($_SESSION['seat_assignments'])) {
  $_SESSION['seat_assignments'] = [];
}

$_SESSION['seat_assignments'][$data['passenger']] = [
  'seat'  => $data['seat'],
  'price' => (float)$data['price']
];

$_SESSION['seat_total'] =
  array_sum(array_column($_SESSION['seat_assignments'], 'price'));

echo json_encode([
  'success' => true,
  'seats'   => $_SESSION['seat_assignments'],
  'total'   => $_SESSION['seat_total']
]);
