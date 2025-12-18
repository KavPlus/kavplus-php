<?php
require_once "auth.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================
   TEMP DATA SOURCE
   - Later replace with DB fetch using booking reference
========================= */
$booking = $_SESSION['booking'] ?? [
    'reference' => 'KP-8439201',
    'route'     => 'London → Dubai',
    'airline'   => 'Emirates',
    'flight_no' => 'EK004',
    'date'      => '12 Dec 2025',
    'time'      => '08:30 → 18:00 · 7h 30m (Nonstop)',
    'passenger' => [
        'name' => 'John Doe',
        'passport' => '123456789',
        'dob' => '05 May 1990',
        'nationality' => 'United Kingdom'
    ],
    'addons' => [
        '20kg Extra Baggage',
        'Preferred Seat Selected',
        'Travel Insurance Included'
    ],
    'currency' => '£',
    'base_fare' => 390,
    'taxes' => 30,
    'status' => 'CONFIRMED'
];

$total = $booking['base_fare'] + $booking['taxes'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking Details – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- APPLY DARK MODE EARLY -->
<script>
(function () {
  try {
    if (localStorage.getItem('theme') === 'dark') {
      document.documentElement.classList.add('dark');
    }
  } catch(e){}
})();
</script>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config = { darkMode:'class' }</script>

<link rel="stylesheet" href="styles.css">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="md:ml-60 pt-20 md:pt-24 pb-20">

<!-- BOOKING HEADER -->
<section class="max-w-6xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-2xl shadow">

    <div class="flex justify-between items-center flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold">Booking Details</h1>
            <p class="text-gray-600 dark:text-gray-300">
                Review your full itinerary and ticket info below.
            </p>
        </div>

        <div class="text-right">
            <p class="text-sm text-gray-500">Booking Reference</p>
            <p class="text-2xl font-bold tracking-wide text-[#0097D7]">
                <?= htmlspecialchars($booking['reference']) ?>
            </p>
        </div>
    </div>

    <div class="mt-6">
        <span class="bg-green-100 dark:bg-green-900/30
                     text-green-700 dark:text-green-400
                     px-4 py-1 rounded-lg text-sm font-semibold">
            ✔ <?= htmlspecialchars($booking['status']) ?>
        </span>
    </div>
</section>

<!-- MAIN DETAILS GRID -->
<div class="max-w-6xl mx-auto mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 px-4 md:px-0">

    <!-- LEFT -->
    <div class="md:col-span-2 space-y-6">

        <!-- FLIGHT ITINERARY -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <h2 class="text-xl font-bold mb-4">Flight Itinerary</h2>

            <div class="flex justify-between items-center gap-4 flex-wrap">
                <div>
                    <p class="text-lg font-bold"><?= htmlspecialchars($booking['route']) ?></p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">
                        <?= htmlspecialchars($booking['airline']) ?> · <?= htmlspecialchars($booking['flight_no']) ?>
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm"><?= htmlspecialchars($booking['date']) ?></p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm"><?= htmlspecialchars($booking['time']) ?></p>
                </div>

                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d6/Emirates_logo.svg"
                     class="h-10 opacity-70">
            </div>
        </div>

        <!-- PASSENGER DETAILS -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <h2 class="text-xl font-bold mb-4">Passenger Information</h2>

            <div class="space-y-2 text-gray-700 dark:text-gray-300">
                <p class="font-semibold"><?= htmlspecialchars($booking['passenger']['name']) ?></p>
                <p class="text-sm">Passport: <?= htmlspecialchars($booking['passenger']['passport']) ?></p>
                <p class="text-sm">Date of Birth: <?= htmlspecialchars($booking['passenger']['dob']) ?></p>
                <p class="text-sm">Nationality: <?= htmlspecialchars($booking['passenger']['nationality']) ?></p>
            </div>
        </div>

        <!-- ADDITIONAL SERVICES -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <h2 class="text-xl font-bold mb-4">Additional Services</h2>

            <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                <?php foreach ($booking['addons'] as $a): ?>
                    <li>✔ <?= htmlspecialchars($a) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>

    <!-- RIGHT -->
    <aside class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 h-fit">

        <h2 class="text-xl font-bold mb-4">Fare Summary</h2>

        <div class="flex justify-between text-gray-700 dark:text-gray-300">
            <span>Base Fare</span>
            <span><?= $booking['currency'] ?><?= number_format($booking['base_fare'],2) ?></span>
        </div>

        <div class="flex justify-between text-gray-700 dark:text-gray-300 mt-2">
            <span>Taxes & Fees</span>
            <span><?= $booking['currency'] ?><?= number_format($booking['taxes'],2) ?></span>
        </div>

        <hr class="my-3 border-gray-200 dark:border-gray-700">

        <div class="flex justify-between font-bold text-2xl text-[#0097D7] mb-4">
            <span>Total Paid</span>
            <span><?= $booking['currency'] ?><?= number_format($total,2) ?></span>
        </div>

        <!-- ACTIONS -->
        <a href="ticket-pdf.php"
           class="block w-full bg-[#0097D7] text-white py-3 rounded-xl text-center font-semibold hover:bg-[#007fb8] mb-3">
            Download Ticket (PDF)
        </a>

        <a href="invoice-pdf.php"
           class="block w-full bg-gray-200 dark:bg-gray-700 text-center py-3 rounded-xl mb-3">
            View Invoice
        </a>

        <a href="cancel-booking.php"
           class="block w-full bg-red-500 text-white py-3 rounded-xl text-center hover:bg-red-600 mb-3">
            Cancel Booking
        </a>

        <a href="support.php"
           class="block w-full bg-green-600 text-white py-3 rounded-xl text-center hover:bg-green-700">
            Need Help?
        </a>

    </aside>

</div>

<?php include "footer.php"; ?>

</main>

<script src="include.js"></script>
</body>
</html>
