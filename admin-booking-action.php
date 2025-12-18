<?php
session_start();
require_once __DIR__ . '/db.php';

/* =========================
   ADMIN GUARD
========================= */
if (empty($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit;
}

/* =========================
   CSRF CHECK
========================= */
if (
    empty($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    die('Invalid CSRF token');
}

$pdo = db();

$id     = (int)($_POST['id'] ?? 0);
$action = $_POST['action'] ?? '';

if ($id <= 0) {
    header("Location: admin-bookings.php");
    exit;
}

/* =========================
   ACTION HANDLER
========================= */
switch ($action) {

    case 'confirm':
        $stmt = $pdo->prepare("
            UPDATE bookings
            SET booking_status = 'CONFIRMED'
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        break;

    case 'cancel':
        $stmt = $pdo->prepare("
            UPDATE bookings
            SET booking_status = 'CANCELLED'
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        break;

    case 'paid':
        $stmt = $pdo->prepare("
            UPDATE bookings
            SET payment_status = 'PAID'
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        break;

    case 'refund':
        $stmt = $pdo->prepare("
            UPDATE bookings
            SET payment_status = 'REFUNDED'
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        break;
}

/* =========================
   REDIRECT BACK
========================= */
header("Location: admin-booking-view.php?id=".$id);
exit;
