<?php
session_start();
require_once __DIR__ . '/services/hotel-booking-service.php';

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$service = new HotelBookingService();
$booking = $service->getBookingById($id);

if (!$booking) {
    die("Booking not found");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Hotel Booking Confirmed – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode: 'class' }
</script>

<!-- Apply dark mode early -->
<script>
(function () {
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }
})();
</script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300
             text-gray-900 dark:text-gray-100
             pt-16 md:pt-20 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="pb-20 px-6">

<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800
            rounded-3xl shadow-xl p-10 text-center">

    <!-- SUCCESS ICON -->
    <div class="mx-auto w-20 h-20 rounded-full
                bg-green-100 dark:bg-green-900/30
                flex items-center justify-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-10 h-10 text-green-600 dark:text-green-400"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="3" d="M5 13l4 4L19 7"/>
        </svg>
    </div>

    <!-- TITLE -->
    <h1 class="text-3xl font-bold mb-2">
        Booking Confirmed!
    </h1>
    <p class="text-gray-500 dark:text-gray-400 mb-8">
        Your hotel stay has been successfully booked with KavPlus Travel
    </p>

    <!-- CONFIRMATION -->
    <div class="bg-blue-50 dark:bg-blue-900/30
                rounded-2xl p-6 mb-8">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Confirmation Number
        </p>
        <p class="text-2xl font-bold tracking-wider
                  text-blue-600 dark:text-blue-400">
            <?= htmlspecialchars($booking['confirmation']) ?>
        </p>
    </div>

    <!-- BOOKING DETAILS -->
    <div class="grid md:grid-cols-2 gap-6 text-left mb-10">

        <div class="space-y-2">
            <p class="text-lg font-semibold">
                <?= htmlspecialchars($booking['hotel_name']) ?>
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                <?= htmlspecialchars($booking['city']) ?>
            </p>
            <p class="text-sm text-gray-700 dark:text-gray-300">
                <strong>Check-in:</strong> <?= htmlspecialchars($booking['checkin']) ?><br>
                <strong>Check-out:</strong> <?= htmlspecialchars($booking['checkout']) ?>
            </p>
        </div>

        <div class="space-y-2 text-gray-700 dark:text-gray-300">
            <p><strong>Guests:</strong> <?= (int)$booking['guests'] ?></p>

            <?php if (!empty($booking['rooms'])): ?>
            <p><strong>Rooms:</strong> <?= (int)$booking['rooms'] ?></p>
            <?php endif; ?>

            <p>
                <strong>Status:</strong>
                <span class="text-green-600 dark:text-green-400 font-semibold">
                    <?= htmlspecialchars($booking['status']) ?>
                </span>
            </p>

            <p class="text-xl font-bold text-blue-600 dark:text-blue-400">
                £<?= number_format($booking['total_paid'], 2) ?>
            </p>
        </div>

    </div>

    <!-- ACTIONS -->
    <div class="flex flex-col sm:flex-row justify-center gap-4">

        <a href="my-bookings.php"
           class="px-8 py-3 rounded-xl bg-[#0097D7]
                  text-white font-semibold hover:bg-[#007fb8] transition">
            My Bookings
        </a>

        <a href="hotels.php"
           class="px-8 py-3 rounded-xl
                  bg-gray-200 dark:bg-gray-700
                  text-gray-800 dark:text-gray-200
                  hover:bg-gray-300 dark:hover:bg-gray-600 transition">
            Book Another Hotel
        </a>

    </div>

</div>

</main>

<?php include "footer.php"; ?>
</body>
</html>
