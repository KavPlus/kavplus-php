<?php
session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

/* =========================
   GUARD
========================= */
$data = $_SESSION['completed_booking'] ?? null;
if (!$data) {
    header("Location: flights.php");
    exit;
}

/* =========================
   PREVENT DOUBLE INSERT
========================= */
if (!empty($_SESSION['booking_saved'])) {
    // already saved in DB
} else {

    $pdo = db();

    /* =========================
       SAVE FLIGHT BOOKING
    ========================= */
    $stmt = $pdo->prepare("
        INSERT INTO bookings
        (confirmation, pnr, email, flight_json, total_paid, status, created_at)
        VALUES
        (:confirmation, :pnr, :email, :flight, :total, 'PAID', :created)
    ");

    $stmt->execute([
        ':confirmation' => $data['confirmation'],
        ':pnr'          => $data['pnr'],
        ':email'        => $data['email'],
        ':flight'       => json_encode($data['flight']),
        ':total'        => $data['total_paid'],
        ':created'      => date('Y-m-d H:i:s'),
    ]);

    /* =========================
       MARK AS SAVED
    ========================= */
    $_SESSION['booking_saved'] = true;
}

/* =========================
   SAFE VALUES
========================= */
$flight     = $data['flight'] ?? [];
$passengers = $data['passengers'] ?? [];

$leadName = 'Passenger';
if (!empty($passengers[0]['first']) || !empty($passengers[0]['last'])) {
    $leadName = trim(($passengers[0]['first'] ?? '') . ' ' . ($passengers[0]['last'] ?? ''));
}

$seat     = $data['seat'] ?? 'Not selected';
$email    = $data['email'] ?? '-';
$phone    = $data['phone'] ?? '-';
$baseFare = (float)($data['base_fare'] ?? 0);
$taxes    = (float)($data['taxes'] ?? 0);
$total    = (float)($data['total_paid'] ?? 0);
$provider = $data['payment_provider'] ?? 'CARD';

include "sidebar.php";
include "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking Confirmed – <?= APP_NAME ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode: "class" }
</script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<main class="md:ml-60 pt-24 pb-20">

<!-- SUCCESS -->
<section class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow p-10 text-center">
  <div class="text-green-600 text-5xl mb-4">✔</div>

  <h1 class="text-3xl font-bold">Booking Confirmed!</h1>
  <p class="text-gray-600 dark:text-gray-300 mt-2">
    You will receive an email confirmation shortly.
  </p>

  <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
    <p class="text-sm text-gray-500 dark:text-gray-400">Confirmation Number</p>
    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
      <?= htmlspecialchars($data['confirmation']) ?>
    </p>
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
      PNR: <?= htmlspecialchars($data['pnr']) ?>
    </p>
  </div>
</section>

<!-- DETAILS -->
<div class="max-w-6xl mx-auto mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">

  <!-- FLIGHT -->
  <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
    <h3 class="font-bold mb-3">Flight Details</h3>
    <p class="font-semibold">
      <?= htmlspecialchars(($flight['from'] ?? '') . ' → ' . ($flight['to'] ?? '')) ?>
    </p>
    <p class="text-sm text-gray-500 dark:text-gray-400">
      <?= htmlspecialchars($flight['airline'] ?? '') ?>
    </p>
    <p class="text-sm text-gray-500 dark:text-gray-400">
      <?= htmlspecialchars(($flight['depart'] ?? '') . ' → ' . ($flight['arrive'] ?? '')) ?>
    </p>
    <p class="text-sm text-gray-500 dark:text-gray-400">
      Seat: <?= htmlspecialchars($seat) ?>
    </p>
  </div>

  <!-- PASSENGER -->
  <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
    <h3 class="font-bold mb-3">Passenger</h3>
    <p class="font-semibold"><?= htmlspecialchars($leadName) ?></p>
    <p class="text-sm text-gray-500 dark:text-gray-400">Email: <?= htmlspecialchars($email) ?></p>
    <p class="text-sm text-gray-500 dark:text-gray-400">Phone: <?= htmlspecialchars($phone) ?></p>
  </div>

  <!-- PAYMENT -->
  <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
    <h3 class="font-bold mb-3">Payment</h3>
    <div class="flex justify-between text-sm">
      <span>Base Fare</span>
      <span><?= CURRENCY_SYMBOL ?><?= number_format($baseFare,2) ?></span>
    </div>
    <div class="flex justify-between text-sm">
      <span>Taxes</span>
      <span><?= CURRENCY_SYMBOL ?><?= number_format($taxes,2) ?></span>
    </div>
    <hr class="my-3">
    <div class="flex justify-between font-bold text-lg text-blue-600 dark:text-blue-400">
      <span>Total Paid</span>
      <span><?= CURRENCY_SYMBOL ?><?= number_format($total,2) ?></span>
    </div>
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
      Paid via <?= htmlspecialchars($provider) ?>
    </p>
  </div>

</div>

<!-- ACTIONS -->
<div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-gray-800 shadow p-6 rounded-xl text-center">
  <a href="ticket-pdf.php?c=<?= urlencode($data['confirmation']) ?>"
     class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-block">
    Download Ticket
  </a>

  <a href="my-bookings.php"
     class="border border-gray-300 dark:border-gray-600 px-6 py-3 rounded-lg ml-2 inline-block">
    My Bookings
  </a>
</div>

<?php include "footer.php"; ?>
</main>
</body>
</html>
