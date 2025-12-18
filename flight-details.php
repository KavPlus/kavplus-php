<?php
session_start();
include_once "currency.php";

/* ==========================
   MOCK SELECTED FLIGHT
========================== */
$selectedFlight = [
  'airline' => 'Norse Atlantic Airways',
  'flight_no' => 'N0 701',
  'from' => 'London (LGW)',
  'to' => 'Bangkok (BKK)',
  'depart' => '16:00',
  'arrive' => '10:25 +1',
  'duration' => '11h 25m',
  'aircraft' => 'Boeing 787-9',
  'price_basic' => 765,
  'price_standard' => 927,
  'price_flex' => 1333
];

/* SAVE TO SESSION (CRITICAL) */
$_SESSION['selected_flight'] = [
  'airline' => $selectedFlight['airline'],
  'price'   => $selectedFlight['price_standard']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Flight details – Kav+</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={darkMode:'class'}</script>

<style>
.kav-bg{ background:#0097D7 }
.kav-bg:hover{ background:#0083BD }
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100
             pt-16 md:pt-20 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<div class="max-w-7xl mx-auto px-6 py-6 grid grid-cols-1 lg:grid-cols-12 gap-6">

<!-- LEFT -->
<section class="lg:col-span-8 space-y-6">

<!-- ITINERARY -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
  <h2 class="text-lg font-semibold mb-4">Outbound flight</h2>

  <div class="flex items-center justify-between">
    <div>
      <div class="text-xl font-bold"><?= $selectedFlight['depart'] ?></div>
      <div class="text-sm text-gray-500"><?= $selectedFlight['from'] ?></div>
    </div>

    <div class="text-center">
      <div class="text-sm text-gray-500"><?= $selectedFlight['duration'] ?> · Direct</div>
      <div class="border-t border-dashed my-2"></div>
      <div class="text-xs text-gray-500"><?= $selectedFlight['aircraft'] ?></div>
    </div>

    <div>
      <div class="text-xl font-bold"><?= $selectedFlight['arrive'] ?></div>
      <div class="text-sm text-gray-500"><?= $selectedFlight['to'] ?></div>
    </div>
  </div>

  <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
    <?= $selectedFlight['airline'] ?> · <?= $selectedFlight['flight_no'] ?>
  </div>
</div>

<!-- FARES -->
<h2 class="text-lg font-semibold">Choose your fare</h2>

<!-- BASIC -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex justify-between items-center">
  <div>
    <h3 class="font-semibold">Basic</h3>
    <p class="text-sm text-gray-500 mt-2">No baggage · No refund</p>
  </div>
  <a href="flight-fare.php?fare=basic"
     class="kav-bg text-white px-5 py-2 rounded-xl font-semibold">
    £<?= $selectedFlight['price_basic'] ?> Select
  </a>
</div>

<!-- STANDARD -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex justify-between items-center border-2 border-[#0097D7]">
  <div>
    <h3 class="font-semibold">
      Standard <span class="text-xs text-[#0097D7]">Recommended</span>
    </h3>
    <p class="text-sm text-gray-500 mt-2">1 bag · Seat selection</p>
  </div>
  <a href="flight-fare.php?fare=standard"
     class="kav-bg text-white px-5 py-2 rounded-xl font-semibold">
    £<?= $selectedFlight['price_standard'] ?> Select
  </a>
</div>

<!-- FLEX -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex justify-between items-center">
  <div>
    <h3 class="font-semibold">Flex</h3>
    <p class="text-sm text-gray-500 mt-2">Refundable · 2 bags</p>
  </div>
  <a href="flight-fare.php?fare=flex"
     class="kav-bg text-white px-5 py-2 rounded-xl font-semibold">
    £<?= $selectedFlight['price_flex'] ?> Select
  </a>
</div>

</section>

</div>

<?php include "footer.php"; ?>
</body>
</html>
