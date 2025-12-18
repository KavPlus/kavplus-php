<?php
include "auth.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================
   OPTIONAL: READ SESSION BOOKING DATA (SAFE DEFAULTS)
   - So this page can work now, and later you can plug real booking flows in.
========================= */
$booking = $_SESSION['booking'] ?? [
    'type' => 'flight',
    'route' => 'London → Dubai',
    'airline' => 'Emirates',
    'flight_no' => 'EK004',
    'time' => '08:30 → 18:00 · 7h 30m (Nonstop)',
    'currency' => '£',
    'base_fare' => 390,
    'taxes' => 30,
];

$currency = $booking['currency'] ?? '£';
$baseFare = (float)($booking['base_fare'] ?? 0);
$taxes    = (float)($booking['taxes'] ?? 0);
$total    = $baseFare + $taxes;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking - KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- ✅ EARLY THEME APPLY (MUST BE BEFORE TAILWIND LOADS) -->
<script>
(function () {
  try {
    var t = localStorage.getItem('theme');
    if (t === 'dark') document.documentElement.classList.add('dark');
  } catch(e) {}
})();
</script>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode: 'class' }
</script>

<!-- Optional CSS -->
<link rel="stylesheet" href="styles.css">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="md:ml-60 pt-20 md:pt-24 pb-20">

    <!-- PAGE TITLE -->
    <section class="max-w-6xl mx-auto bg-white dark:bg-gray-800 shadow p-6 rounded-2xl">
        <h2 class="text-2xl font-bold">Passenger Information</h2>
        <p class="text-gray-600 dark:text-gray-300">
            Please enter traveler details exactly as per passport.
        </p>
    </section>

    <div class="max-w-7xl mx-auto mt-6 grid grid-cols-1 md:grid-cols-3 gap-6 px-4 md:px-6">

        <!-- LEFT SIDE MAIN FORM -->
        <div class="md:col-span-2 space-y-6">

            <!-- FLIGHT SUMMARY -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5">
                <h3 class="font-bold mb-3 text-lg">Booking Summary</h3>

                <div class="flex justify-between items-center gap-4 flex-wrap">
                    <div>
                        <p class="font-semibold text-gray-800 dark:text-gray-100">
                            <?= htmlspecialchars($booking['route'] ?? '—') ?>
                        </p>
                        <p class="text-gray-500 dark:text-gray-300 text-sm">
                            <?= htmlspecialchars(($booking['airline'] ?? '—') . ' · ' . ($booking['flight_no'] ?? '')) ?>
                        </p>
                        <p class="text-gray-500 dark:text-gray-300 text-sm">
                            <?= htmlspecialchars($booking['time'] ?? '—') ?>
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-2xl font-bold text-[#0097D7]">
                            <?= $currency ?><?= number_format($total, 2) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- PASSENGER FORM -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5">
                <h3 class="font-bold text-lg mb-4">Passenger 1 (Adult)</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold">First Name</label>
                        <input type="text"
                               class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3">
                    </div>

                    <div>
                        <label class="text-sm font-semibold">Last Name</label>
                        <input type="text"
                               class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3">
                    </div>

                    <div>
                        <label class="text-sm font-semibold">Gender</label>
                        <select class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3">
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-semibold">Date of Birth</label>
                        <input type="date"
                               class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3">
                    </div>

                    <div>
                        <label class="text-sm font-semibold">Passport Number</label>
                        <input type="text"
                               class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3">
                    </div>

                    <div>
                        <label class="text-sm font-semibold">Passport Expiry</label>
                        <input type="date"
                               class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3">
                    </div>
                </div>
            </div>

            <!-- CONTACT INFO -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5">
                <h3 class="font-bold text-lg mb-4">Contact Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold">Email</label>
                        <input type="email"
                               class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3">
                    </div>

                    <div>
                        <label class="text-sm font-semibold">Phone Number</label>
                        <input type="text"
                               class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3">
                    </div>
                </div>
            </div>

            <!-- ADD-ONS -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5">
                <h3 class="font-bold text-lg mb-4">Add-ons</h3>

                <label class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 py-3 gap-3">
                    <span>Extra Baggage (20kg)</span>
                    <span class="text-[#0097D7] font-bold">£40</span>
                    <input type="checkbox" class="h-5 w-5">
                </label>

                <label class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 py-3 gap-3">
                    <span>Preferred Seat</span>
                    <span class="text-[#0097D7] font-bold">£15</span>
                    <input type="checkbox" class="h-5 w-5">
                </label>

                <label class="flex justify-between items-center py-3 gap-3">
                    <span>Travel Insurance</span>
                    <span class="text-[#0097D7] font-bold">£20</span>
                    <input type="checkbox" class="h-5 w-5">
                </label>
            </div>
        </div>

        <!-- RIGHT SIDE PRICE SUMMARY -->
        <aside class="bg-white dark:bg-gray-800 shadow rounded-2xl p-5 h-fit">

            <h3 class="font-bold text-lg mb-3">Price Summary</h3>

            <div class="flex justify-between text-gray-700 dark:text-gray-300">
                <span>Base Fare</span>
                <span><?= $currency ?><?= number_format($baseFare, 2) ?></span>
            </div>

            <div class="flex justify-between text-gray-700 dark:text-gray-300 mt-2">
                <span>Taxes & Fees</span>
                <span><?= $currency ?><?= number_format($taxes, 2) ?></span>
            </div>

            <hr class="my-4 border-gray-200 dark:border-gray-700">

            <div class="flex justify-between font-bold text-xl text-[#0097D7]">
                <span>Total</span>
                <span><?= $currency ?><?= number_format($total, 2) ?></span>
            </div>

            <!-- ✅ NO JS REQUIRED -->
            <a href="payment.php"
               class="block w-full bg-[#0097D7] text-white py-3 mt-4 rounded-xl text-lg text-center font-semibold hover:bg-[#007fb8] transition">
                Continue to Payment
            </a>

        </aside>

    </div>

    <?php include "footer.php"; ?>

</main>

<!-- Optional scripts -->
<script src="include.js"></script>
</body>
</html>
