<?php
session_start();

/* ==========================
   GUARD
========================== */
if (!isset($_SESSION['final_total'])) {
  header("Location: flights.php");
  exit;
}

/* ==========================
   READ DATA
========================== */
$flight   = $_SESSION['selected_flight'] ?? [];
$fare     = $_SESSION['fare'] ?? 'standard';
$total    = $_SESSION['final_total'] ?? 0;
$seats    = $_SESSION['seat_assignments'] ?? [];
$currency = "£";

/* Generate PNR */
$pnr = strtoupper(substr(md5(uniqid()), 0, 6));

/* ==========================
   CLEANUP (KEEP BOOKINGS IF NEEDED)
========================== */
// You may later save booking to DB here

unset(
  $_SESSION['seat_assignments'],
  $_SESSION['seat_total'],
  $_SESSION['final_total']
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking confirmed – Kav+</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode:'class' }
</script>

<style>
.kav-bg{ background:#0097D7 }
.kav-bg:hover{ background:#0083BD }
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100
             pt-16 md:pt-20 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<div class="max-w-4xl mx-auto px-6 py-10">

<!-- SUCCESS HEADER -->
<div class="bg-white dark:bg-gray-800 rounded-3xl shadow p-8 text-center mb-6">
  <div class="text-5xl mb-3">✅</div>
  <h1 class="text-2xl font-bold">Booking confirmed</h1>
  <p class="text-gray-500 mt-2">
    Your flight has been successfully booked
  </p>

  <div class="mt-4 inline-block bg-green-100 text-green-700 px-4 py-2 rounded-xl font-semibold">
    Booking reference: <?= $pnr ?>
  </div>
</div>

<!-- DETAILS -->
<div class="bg-white dark:bg-gray-800 rounded-3xl shadow p-6 space-y-6">

<!-- FLIGHT -->
<div>
  <h2 class="font-semibold mb-2">Flight details</h2>
  <div class="text-sm text-gray-600 dark:text-gray-400">
    Airline: <?= htmlspecialchars($flight['airline'] ?? '—') ?><br>
    Fare type: <?= ucfirst($fare) ?>
  </div>
</div>

<!-- SEATS -->
<?php if(!empty($seats)): ?>
<div>
  <h2 class="font-semibold mb-2">Seat selection</h2>
  <ul class="text-sm text-gray-600 dark:text-gray-400 list-disc ml-5">
    <?php foreach($seats as $i=>$s): ?>
      <?php if(is_array($s)): ?>
        <li>Passenger <?= $i+1 ?> – Seat <?= htmlspecialchars($s['seat']) ?></li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</div>
<?php endif; ?>

<!-- PRICE -->
<div class="border-t border-gray-200 dark:border-gray-700 pt-4">
  <div class="flex justify-between text-lg font-semibold">
    <span>Total paid</span>
    <span><?= $currency ?><?= number_format($total,2) ?></span>
  </div>
</div>

</div>

<!-- ACTIONS -->
<div class="mt-6 flex justify-center gap-4">
  <a href="my-bookings.php"
     class="kav-bg text-white px-6 py-3 rounded-xl font-semibold">
    View my bookings
  </a>

  <a href="flights.php"
     class="px-6 py-3 rounded-xl border border-gray-300 dark:border-gray-600">
    Book another flight
  </a>
</div>

</div>

<?php include "footer.php"; ?>

</body>
</html>
