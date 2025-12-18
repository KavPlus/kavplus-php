<?php
session_start();
require_once __DIR__ . '/config.php';

/* ==========================
   GUARD
========================== */
$data = $_SESSION['completed_booking'] ?? null;
if (!$data || empty($data['confirmation'])) {
    header("Location: flights.php");
    exit;
}

/* ==========================
   SAFE DATA
========================== */
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
$provider = $data['payment_provider'] ?? 'N/A';

$confirmation = $data['confirmation'];
$pnr          = $data['pnr'] ?? '—';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking Confirmation – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- APPLY DARK MODE BEFORE PAINT -->
<script>
(function () {
  try {
    if (localStorage.getItem('theme') === 'dark') {
      document.documentElement.classList.add('dark');
    }
  } catch(e){}
})();
</script>

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode: "class" }
</script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="md:ml-60 pt-20 md:pt-24 pb-20">

<!-- ================= SUCCESS ================= -->
<section class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow p-10 text-center">
  <div class="text-green-600 text-5xl mb-4">✔</div>

  <h1 class="text-3xl font-bold">Booking Confirmed!</h1>
  <p class="text-gray-600 dark:text-gray-300 mt-2">
    Thank you for booking with <b><?= APP_NAME ?></b>
  </p>

  <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl">
    <p class="text-sm text-gray-500 dark:text-gray-400">Confirmation Number</p>
    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
      <?= htmlspecialchars($confirmation) ?>
    </p>
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
      PNR: <?= htmlspecialchars($pnr) ?>
    </p>
  </div>
</section>

<!-- ================= DETAILS ================= -->
<div class="max-w-6xl mx-auto mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 px-4 md:px-0">

<!-- FLIGHT -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
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
    Dates: <?= htmlspecialchars($flight['dates'] ?? '—') ?>
  </p>
  <p class="text-sm text-gray-500 dark:text-gray-400">
    Seat: <?= htmlspecialchars($seat) ?>
  </p>
</div>

<!-- PASSENGER -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
  <h3 class="font-bold mb-3">Passenger Details</h3>
  <p class="font-semibold"><?= htmlspecialchars($leadName) ?></p>
  <p class="text-sm text-gray-500 dark:text-gray-400">
    Email: <?= htmlspecialchars($email) ?>
  </p>
  <p class="text-sm text-gray-500 dark:text-gray-400">
    Phone: <?= htmlspecialchars($phone) ?>
  </p>
  <p class="text-sm text-gray-500 dark:text-gray-400">
    Passengers: <?= count($passengers) ?>
  </p>
</div>

<!-- PAYMENT -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
  <h3 class="font-bold mb-3">Payment Summary</h3>

  <div class="flex justify-between text-sm">
    <span>Base Fare</span>
    <span><?= CURRENCY_SYMBOL ?><?= number_format($baseFare,2) ?></span>
  </div>

  <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400">
    <span>Taxes</span>
    <span><?= CURRENCY_SYMBOL ?><?= number_format($taxes,2) ?></span>
  </div>

  <hr class="my-3 border-gray-200 dark:border-gray-700">

  <div class="flex justify-between font-bold text-lg text-blue-600 dark:text-blue-400">
    <span>Total Paid</span>
    <span><?= CURRENCY_SYMBOL ?><?= number_format($total,2) ?></span>
  </div>

  <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
    Payment method: <?= htmlspecialchars($provider) ?>
  </p>
</div>

</div>

<!-- ================= ACTIONS ================= -->
<div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-gray-800 shadow p-6 rounded-2xl text-center space-x-2">

  <a href="ticket-pdf.php?c=<?= urlencode($confirmation) ?>"
     class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl inline-block">
    Download Ticket
  </a>

  <a href="my-bookings.php"
     class="border border-gray-300 dark:border-gray-600 px-6 py-3 rounded-xl inline-block">
    My Bookings
  </a>

  <a href="flights.php"
     class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl inline-block">
    Home
  </a>

</div>

<?php include "footer.php"; ?>
</main>
</body>
</html>
