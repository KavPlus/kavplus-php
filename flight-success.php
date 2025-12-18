<?php
require_once __DIR__ . "/flight-data.php";

$flight_id = booking_get("flight_id");
$f = $flight_id ? find_flight_by_id($flight_id) : null;
if (!$f) { header("Location: flight.php"); exit; }

$ref = booking_get("booking_ref","KAV-UNKNOWN");
$total = (int)booking_get("computed_total",0);
$search = booking_get("search", []);
?>
<!doctype html>
<html lang="en" class="h-full">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Receipt - KavPlus</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    (function(){
      const t = localStorage.getItem('theme');
      if (t === 'dark') document.documentElement.classList.add('dark');
    })();
  </script>
</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">
  <?php include __DIR__ . "/sidebar.php"; ?>
  <?php include __DIR__ . "/header.php"; ?>

  <main class="ml-60 pt-24 px-6 pb-10">
    <div class="max-w-4xl mx-auto space-y-6">

      <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-8">
        <div class="flex items-center justify-between">
          <div>
            <div class="text-2xl font-extrabold">Receipt (UI)</div>
            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">Reference: <span class="font-semibold"><?= h($ref) ?></span></div>
          </div>
          <button onclick="window.print()"
                  class="px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800 font-semibold">
            Print
          </button>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
          <div class="rounded-2xl border border-gray-200 dark:border-gray-800 p-5">
            <div class="font-semibold">Trip</div>
            <div class="mt-2 text-gray-600 dark:text-gray-300">
              <?= h($search["from"] ?? "") ?> → <?= h($search["to"] ?? "") ?><br>
              Depart: <?= h($search["depart"] ?? "") ?>
            </div>
          </div>

          <div class="rounded-2xl border border-gray-200 dark:border-gray-800 p-5">
            <div class="font-semibold">Total</div>
            <div class="mt-2 text-3xl font-extrabold"><?= money_gbp($total) ?></div>
            <div class="text-gray-500 dark:text-gray-400">Paid (UI)</div>
          </div>
        </div>

        <div class="mt-6 rounded-2xl bg-[#0097D7]/10 border border-[#0097D7]/20 p-5 text-sm text-gray-700 dark:text-gray-200">
          This is a UI-only receipt. Connect real booking engine + payment gateway later.
        </div>

        <div class="mt-6">
          <a href="flight-booking.php" class="text-[#0097D7] font-semibold hover:underline">Back to booking</a>
        </div>
      </div>

      <?php include __DIR__ . "/footer.php"; ?>
    </div>
  </main>

  <script> if (window.lucide) lucide.createIcons(); </script>
</body>
</html>
