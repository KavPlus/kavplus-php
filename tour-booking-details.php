<?php
session_start();
require_once __DIR__ . '/db.php';

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$confirmation = $_GET['c'] ?? '';
if (!$confirmation) {
    die('Invalid booking reference');
}

$pdo = db();
$stmt = $pdo->prepare("SELECT * FROM tour_bookings WHERE confirmation = ? LIMIT 1");
$stmt->execute([$confirmation]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die('Booking not found');
}

/* Image resolver */
$images = [
    'london'    => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e',
    'paris'     => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34',
    'singapore' => 'https://images.unsplash.com/photo-1508964942454-1a56651d54ac',
    'tokyo'     => 'https://images.unsplash.com/photo-1549692520-acc6669e2f0c',
    'rome'      => 'https://images.unsplash.com/photo-1526481280691-906f6cfeaf41',
    'dubai'     => 'https://images.unsplash.com/photo-1508264165352-258859e62245'
];

$cityKey = strtolower(trim($booking['city']));
$tourImage = $images[$cityKey] ?? 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tour Booking Details – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode: 'class' }
</script>

<!-- Apply dark mode BEFORE render -->
<script>
(function () {
    const theme = localStorage.getItem('theme');
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    }
})();
</script>

<style>
:root{ --kav:#0097D7; }
.badge{ background:#e6f6ff; color:#0a7cc2; }
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900
             text-gray-900 dark:text-gray-100
             transition-colors duration-300
             pt-24 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="pb-20">

<!-- HEADER -->
<section class="max-w-6xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow p-8 mb-8">
    <div class="flex justify-between items-center flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold">Tour Booking Details</h1>
            <p class="text-gray-600 dark:text-gray-400">Your tour is confirmed 🎉</p>

            <span class="inline-flex items-center gap-2 mt-3 px-4 py-1 rounded-full
                         bg-green-100 dark:bg-green-900/30
                         text-green-700 dark:text-green-400
                         text-sm font-semibold">
                ✔ Confirmed
            </span>
        </div>

        <div class="text-right">
            <p class="text-sm text-gray-500 dark:text-gray-400">Booking Reference</p>
            <p class="text-2xl font-bold text-[#0097D7]">
                <?= htmlspecialchars($booking['confirmation']) ?>
            </p>
        </div>
    </div>
</section>

<!-- MAIN GRID -->
<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

<!-- LEFT -->
<div class="lg:col-span-2 space-y-6">

<!-- TOUR CARD -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex gap-6">
    <img src="<?= htmlspecialchars($tourImage) ?>"
         class="w-40 h-32 rounded-xl object-cover shadow">

    <div>
        <h2 class="text-2xl font-bold">
            <?= htmlspecialchars($booking['tour_name']) ?>
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            <?= htmlspecialchars($booking['city']) ?>
        </p>
        <p class="text-yellow-500 mt-1 font-semibold">★★★★★ 4.8 Rating</p>
    </div>
</div>

<!-- TOUR DETAILS -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
    <h3 class="text-xl font-bold mb-4">Tour Details</h3>

    <div class="grid md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
        <p><strong>Date:</strong> <?= htmlspecialchars($booking['tour_date']) ?></p>
        <p><strong>Guests:</strong> <?= (int)$booking['guests'] ?> Adult(s)</p>
        <p><strong>Duration:</strong> Approx. 4–6 hours</p>
        <p>
            <strong>Status:</strong>
            <span class="text-green-600 dark:text-green-400 font-semibold">
                <?= htmlspecialchars($booking['status']) ?>
            </span>
        </p>

        <p class="md:col-span-2">
            <strong>Includes:</strong> Guided experience, entry tickets, local guide
        </p>
        <p class="md:col-span-2">
            <strong>Not Included:</strong> Personal expenses, optional upgrades
        </p>
    </div>
</div>

<!-- GUEST DETAILS -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
    <h3 class="text-xl font-bold mb-3">Guest Details</h3>
    <p class="font-semibold">
        <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Guest') ?>
    </p>
    <p class="text-gray-600 dark:text-gray-400 text-sm">
        <?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>
    </p>
</div>

</div>

<!-- RIGHT -->
<aside class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 space-y-4 h-fit">

<h3 class="text-xl font-bold">Price Summary</h3>

<div class="flex justify-between text-gray-700 dark:text-gray-300">
    <span>Total Paid</span>
    <span class="font-bold">
        £<?= number_format((float)$booking['total_paid'],2) ?>
    </span>
</div>

<a href="ticket-pdf.php?c=<?= urlencode($booking['confirmation']) ?>"
   class="block bg-[#0097D7] text-white text-center py-3 rounded-xl
          font-semibold hover:bg-[#007fb8]">
   Download Ticket (PDF)
</a>

<button class="w-full bg-gray-200 dark:bg-gray-700 py-3 rounded-xl">
Modify Booking
</button>

<button class="w-full bg-red-500 text-white py-3 rounded-xl hover:bg-red-600">
Cancel Booking
</button>

<a href="support.php"
   class="block bg-green-600 text-white text-center py-3 rounded-xl hover:bg-green-700">
Contact Support
</a>

</aside>

</div>

<?php include "footer.php"; ?>

</main>
</body>
</html>
