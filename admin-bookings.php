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
   FETCH BOOKINGS (SAFE)
========================= */
try {
    $stmt = $pdo->query("
        SELECT
            id,
            booking_ref,
            user_email,
            origin,
            destination,
            amount,
            payment_status,
            booking_status,
            created_at
        FROM bookings
        ORDER BY created_at DESC
    ");
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Fallback if column names differ
    $stmt = $pdo->query("SELECT * FROM bookings ORDER BY created_at DESC");
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function h($v){ return htmlspecialchars((string)$v); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>KAV+ Admin – Bookings</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B1220] text-gray-100">

<?php include 'admin-header.php'; ?>

<main class="ml-64 p-8">

  <!-- HEADER -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold">Bookings</h1>
    <p class="text-gray-400">
      Flight & travel reservations
    </p>
  </div>

  <!-- TABLE -->
  <div class="bg-[#111827] rounded-2xl shadow overflow-x-auto">

    <table class="w-full text-sm min-w-[1000px]">
      <thead class="bg-white/5 text-gray-300">
        <tr>
          <th class="p-4 text-left">Ref</th>
          <th class="p-4 text-left">Customer</th>
          <th class="p-4 text-center">Route</th>
          <th class="p-4 text-center">Amount</th>
          <th class="p-4 text-center">Payment</th>
          <th class="p-4 text-center">Status</th>
          <th class="p-4 text-center">Booked</th>
        </tr>
      </thead>
      <tbody>

      <?php if (empty($bookings)): ?>
        <tr>
          <td colspan="7" class="p-6 text-center text-gray-400">
            No bookings found
          </td>
        </tr>
      <?php endif; ?>

      <?php foreach ($bookings as $b): ?>
        <tr class="border-t border-white/5 hover:bg-white/5">

          <td class="p-4 font-mono text-sky-300">
  <a href="admin-booking-view.php?id=<?= (int)$b['id'] ?>"
     class="hover:underline">
     <?= h($b['booking_ref'] ?? ('#'.$b['id'])) ?>
  </a>
</td>

            <?= h($b['booking_ref'] ?? ('#'.$b['id'])) ?>
          </td>

          <td class="p-4">
            <?= h($b['user_email'] ?? '—') ?>
          </td>

          <td class="p-4 text-center text-gray-300">
            <?= h(($b['origin'] ?? '—') . ' → ' . ($b['destination'] ?? '—')) ?>
          </td>

          <td class="p-4 text-center font-semibold">
            £<?= number_format((float)($b['amount'] ?? 0), 2) ?>
          </td>

          <td class="p-4 text-center">
            <span class="px-3 py-1 rounded-full text-xs
              <?= ($b['payment_status'] ?? '') === 'PAID'
                ? 'bg-green-500/20 text-green-300'
                : 'bg-amber-500/20 text-amber-300' ?>">
              <?= strtoupper(h($b['payment_status'] ?? 'PENDING')) ?>
            </span>
          </td>

          <td class="p-4 text-center">
            <span class="px-3 py-1 rounded-full text-xs
              <?= ($b['booking_status'] ?? '') === 'CONFIRMED'
                ? 'bg-sky-500/20 text-sky-300'
                : 'bg-gray-500/20 text-gray-300' ?>">
              <?= strtoupper(h($b['booking_status'] ?? 'PROCESSING')) ?>
            </span>
          </td>

          <td class="p-4 text-center text-xs text-gray-400">
            <?= isset($b['created_at'])
                ? date('Y-m-d', strtotime($b['created_at']))
                : '—' ?>
          </td>

        </tr>
      <?php endforeach; ?>

      </tbody>
    </table>

  </div>

</main>

</body>
</html>
