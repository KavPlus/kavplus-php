<?php
session_start();
require_once __DIR__ . '/db.php';

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

$type         = strtoupper(trim($_POST['type'] ?? ''));
$confirmation = trim($_POST['confirmation'] ?? '');
$reason       = trim($_POST['reason'] ?? '');

if (!$confirmation || !$type) {
    die("Missing data");
}

$pdo   = db();
$user  = $_SESSION['user'];
$isAdmin = (($user['role'] ?? '') === 'admin');

/* ======================
   LOAD BOOKING
====================== */
switch ($type) {
    case 'FLIGHT':
        $stmt = $pdo->prepare("SELECT * FROM bookings WHERE confirmation = ?");
        break;
    case 'HOTEL':
        $stmt = $pdo->prepare("SELECT * FROM hotel_bookings WHERE confirmation = ?");
        break;
    case 'TOUR':
        $stmt = $pdo->prepare("SELECT * FROM tour_bookings WHERE confirmation = ?");
        break;
    default:
        die("Invalid booking type");
}

$stmt->execute([$confirmation]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die("Booking not found");
}

/* ======================
   OWNERSHIP CHECK
====================== */
if (!$isAdmin) {

    if ($type === 'FLIGHT') {
        if (($booking['email'] ?? '') !== ($user['email'] ?? '')) {
            die("Unauthorized");
        }
    } else {
        if ((int)($booking['user_id'] ?? 0) !== (int)$user['id']) {
            die("Unauthorized");
        }
    }
}

/* ======================
   PREVENT DOUBLE CANCEL
====================== */
if (strtoupper($booking['status'] ?? '') === 'CANCELLED') {
    header("Location: my-bookings.php?cancel=already");
    exit;
}

/* ======================
   CANCELLATION WINDOW
====================== */
$now     = time();
$created = strtotime($booking['created_at'] ?? '');

if (!$isAdmin && $created && ($now - $created > 86400 * 2)) {
    die("Cancellation window expired");
}

/* ======================
   REFUND CALCULATION
====================== */
$total = (float)($booking['total_paid'] ?? 0);

if ($created && ($now - $created < 86400)) {
    $refund = $total;            // Full refund (24h)
} elseif ($created && ($now - $created < 86400 * 2)) {
    $refund = $total * 0.5;      // 50% refund (48h)
} else {
    $refund = 0;
}

/* ======================
   UPDATE DATABASE
====================== */
switch ($type) {
    case 'FLIGHT':
        $q = "UPDATE bookings SET
                status='CANCELLED',
                refund_amount=?,
                cancel_reason=?,
                cancelled_at=?
              WHERE confirmation=?";
        break;

    case 'HOTEL':
        $q = "UPDATE hotel_bookings SET
                status='CANCELLED',
                refund_amount=?,
                cancel_reason=?,
                cancelled_at=?
              WHERE confirmation=?";
        break;

    case 'TOUR':
        $q = "UPDATE tour_bookings SET
                status='CANCELLED',
                refund_amount=?,
                cancel_reason=?,
                cancelled_at=?
              WHERE confirmation=?";
        break;
}

$pdo->prepare($q)->execute([
    $refund,
    $reason ?: 'Cancelled by user',
    date('Y-m-d H:i:s'),
    $confirmation
]);

/* ======================
   EMAIL CONFIRMATION
====================== */
if (!empty($user['email'])) {
    @mail(
        $user['email'],
        "Booking cancelled – KavPlus Travel",
        "Your booking ($confirmation) has been cancelled.\n\nRefund Amount: £" . number_format($refund, 2),
        "From: no-reply@kavplus.com"
    );
}

/* ======================
   REDIRECT
====================== */
header("Location: my-bookings.php?cancel=success");
exit;
