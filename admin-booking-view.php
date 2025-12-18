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

$pdo = db();

/* =========================
   VALIDATE ID
========================= */
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: admin-bookings.php");
    exit;
}

/* =========================
   FETCH BOOKING (SAFE)
========================= */
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE id=? LIMIT 1");
$stmt->execute([$id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    header("Location: admin-bookings.php");
    exit;
}

function h($v){ return htmlspecialchars((string)$v); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking Details – KAV+</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B1220] text-gray-100">

<?php include 'admin-header.php'; ?>

<main class="ml-64 p-8 max-w-6xl">

  <!-- HEADER -->
  <div class="mb-8 flex justify-between items-center">
    <div>
      <h1 class="text-3xl font-bold">Booking Details</h1>
      <p class="text-gray-400">
        Ref: <?= h($booking['booking_ref'] ?? '#'.$booking['id']) ?>
      </p>
    </div>

    <a href="admin-bookings.php"
       class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10">
      ← Back
    </a>
  </div>
<!-- ACTIONS -->
<div class="mb-8 bg-[#111827] p-6 rounded-2xl">
  <h2 class="text-lg font-semibold mb-4">Booking Actions</h2>

  <div class="flex flex-wrap gap-3">

    <!-- CONFIRM -->
    <form method="POST" action="admin-booking-action.php">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
      <input type="hidden" name="id" value="<?= $booking['id'] ?>">
      <input type="hidden" name="action" value="confirm">
      <button class="px-4 py-2 rounded-xl bg-sky-500/20 text-sky-300 hover:bg-sky-500/30">
        Confirm Booking
      </button>
    </form>

    <!-- CANCEL -->
    <form method="POST" action="admin-booking-action.php"
          onsubmit="return confirm('Cancel this booking?');">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
      <input type="hidden" name="id" value="<?= $booking['id'] ?>">
      <input type="hidden" name="action" value="cancel">
      <button class="px-4 py-2 rounded-xl bg-red-500/20 text-red-300 hover:bg-red-500/30">
        Cancel Booking
      </button>
    </form>

    <!-- MARK PAID -->
    <form method="POST" action="admin-booking-action.php">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
      <input type="hidden" name="id" value="<?= $booking['id'] ?>">
      <input type="hidden" name="action" value="paid">
      <button class="px-4 py-2 rounded-xl bg-green-500/20 text-green-300 hover:bg-green-500/30">
        Mark as Paid
      </button>
    </form>

    <!-- REFUND -->
    <form method="POST" action="admin-booking-action.php"
          onsubmit="return confirm('Refund this payment?');">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
      <input type="hidden" name="id" value="<?= $booking['id'] ?>">
      <input type="hidden" name="action" value="refund">
      <button class="px-4 py-2 rounded-xl bg-amber-500/20 text-amber-300 hover:bg-amber-500/30">
        Refund
      </button>
    </form>

  </div>
</div>

  <!-- DETAILS GRID -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- CUSTOMER -->
    <div class="bg-[#111827] p-6 rounded-2xl">
      <h2 class="text-lg font-semibold mb-4">Customer</h2>
      <p><span class="text-gray-400">Email:</span>
         <?= h($booking['user_email'] ?? '—') ?></p>
    </div>

    <!-- ROUTE -->
    <div class="bg-[#111827] p-6 rounded-2xl">
      <h2 class="text-lg font-semibold mb-4">Route</h2>
      <p>
        <?= h($booking['origin'] ?? '—') ?>
        →
        <?= h($booking['destination'] ?? '—') ?>
      </p>
    </div>

    <!-- PAYMENT -->
    <div class="bg-[#111827] p-6 rounded-2xl">
      <h2 class="text-lg font-semibold mb-4">Payment</h2>
      <p>
        <span class="text-gray-400">Amount:</span>
        £<?= number_format((float)($booking['amount'] ?? 0), 2) ?>
      </p>
      <p>
        <span class="text-gray-400">Status:</span>
        <?= h($booking['payment_status'] ?? 'PENDING') ?>
      </p>
    </div>

    <!-- STATUS -->
    <div class="bg-[#111827] p-6 rounded-2xl">
      <h2 class="text-lg font-semibold mb-4">Booking Status</h2>
      <p><?= h($booking['booking_status'] ?? 'PROCESSING') ?></p>
    </div>

  </div>

  <!-- RAW DETAILS -->
  <div class="mt-8 bg-[#111827] p-6 rounded-2xl">
    <h2 class="text-lg font-semibold mb-4">Full Record</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">

      <?php foreach ($booking as $key => $value): ?>
        <div class="flex justify-between border-b border-white/5 py-2">
          <span class="text-gray-400"><?= h($key) ?></span>
          <span class="ml-4"><?= h($value) ?></span>
        </div>
      <?php endforeach; ?>

    </div>
  </div>

</main>

</body>
</html>
