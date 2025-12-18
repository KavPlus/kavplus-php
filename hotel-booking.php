<?php
session_start();
require_once __DIR__ . '/services/hotel-booking-service.php';

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$service = new HotelBookingService();

/**
 * 1) Read incoming data from hotel-details.php
 */
$hotel_name = $_POST['hotel_name'] ?? ($_GET['hotel_name'] ?? 'Grand Palace Hotel');
$city       = $_POST['city'] ?? ($_GET['city'] ?? 'London');
$checkin    = $_POST['checkin'] ?? ($_GET['checkin'] ?? date('Y-m-d'));
$checkout   = $_POST['checkout'] ?? ($_GET['checkout'] ?? date('Y-m-d', strtotime('+3 days')));
$guests     = (int)($_POST['guests'] ?? ($_GET['guests'] ?? 2));
$rooms      = (int)($_POST['rooms'] ?? ($_GET['rooms'] ?? 1));
$price      = (float)($_POST['price'] ?? ($_GET['price'] ?? 670));
$provider   = $_POST['payment_provider'] ?? 'CARD';

/**
 * Safety defaults
 */
if ($guests < 1) $guests = 1;
if ($rooms < 1) $rooms = 1;
if ($price < 0) $price = 0;

/**
 * 2) Handle booking submit
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_payment'])) {

    $bookingId = $service->createHotelBooking([
        'user_id'          => $user['id'],
        'email'            => $user['email'],
        'hotel_name'       => $hotel_name,
        'city'             => $city,
        'checkin'          => $checkin,
        'checkout'         => $checkout,
        'guests'           => $guests,
        'rooms'            => $rooms,
        'price'            => $price,
        'payment_provider' => $provider,
    ]);

    header("Location: hotel-booking-confirmed.php?id=" . urlencode($bookingId));
    exit;
}

/**
 * Format dates for UI
 */
function fmtDate($ymd) {
    $t = strtotime($ymd);
    return $t ? date('d M Y', $t) : htmlspecialchars($ymd);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secure Hotel Payment – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode:'class' }
</script>

<style>
:root{
  --kav:#0097D7;
  --kav2:#007fb8;
}
.card-hover{transition:.25s}
.card-hover:hover{transform:translateY(-2px)}
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors
             text-gray-900 dark:text-gray-100
             pt-16 md:pt-20 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="pb-20 px-6 max-w-7xl mx-auto">

<form method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">

<!-- ================= LEFT ================= -->
<section class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 space-y-8">

<!-- HOTEL SUMMARY -->
<div class="flex gap-5 items-center border-b border-gray-200 dark:border-gray-700 pb-6">
    <img src="images/hotel1.jpg"
         onerror="this.src='banners/hotels.jpg'"
         class="w-32 h-24 rounded-xl object-cover shadow">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <?= htmlspecialchars($hotel_name) ?>
        </h2>
        <p class="text-gray-500 dark:text-gray-300">
            <?= htmlspecialchars($city) ?>
        </p>
        <span class="inline-block mt-2 bg-green-500 text-white text-xs px-3 py-1 rounded-full">
            Free Cancellation
        </span>
    </div>
</div>

<!-- PASS DATA -->
<input type="hidden" name="hotel_name" value="<?= htmlspecialchars($hotel_name) ?>">
<input type="hidden" name="city" value="<?= htmlspecialchars($city) ?>">
<input type="hidden" name="checkin" value="<?= htmlspecialchars($checkin) ?>">
<input type="hidden" name="checkout" value="<?= htmlspecialchars($checkout) ?>">
<input type="hidden" name="guests" value="<?= (int)$guests ?>">
<input type="hidden" name="rooms" value="<?= (int)$rooms ?>">
<input type="hidden" name="price" value="<?= htmlspecialchars((string)$price) ?>">

<!-- PAYMENT METHOD -->
<div>
    <h3 class="text-lg font-semibold mb-4">Select Payment Method</h3>

    <div class="space-y-3">

        <label class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-[#0097D7]">
            <div class="flex items-center gap-3">
                <input type="radio" name="payment_provider" value="CARD" <?= $provider==='CARD'?'checked':'' ?>>
                <span class="font-medium">Credit / Debit Card</span>
            </div>
            <span class="text-gray-400 text-sm">Visa · MasterCard · Amex</span>
        </label>

        <label class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-[#0097D7]">
            <div class="flex items-center gap-3">
                <input type="radio" name="payment_provider" value="PAYPAL" <?= $provider==='PAYPAL'?'checked':'' ?>>
                <span class="font-medium">PayPal</span>
            </div>
        </label>

        <label class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-[#0097D7]">
            <div class="flex items-center gap-3">
                <input type="radio" name="payment_provider" value="WALLET" <?= $provider==='WALLET'?'checked':'' ?>>
                <span class="font-medium">Kav+ Wallet</span>
            </div>
            <span class="text-green-600 text-sm">Balance Available</span>
        </label>

    </div>
</div>

<!-- CARD DETAILS (UI ONLY) -->
<div>
    <h3 class="text-lg font-semibold mb-4">Card Details</h3>
    <div class="grid md:grid-cols-2 gap-4">
        <input class="p-4 bg-gray-100 dark:bg-gray-700 rounded-xl"
               placeholder="Card Number">
        <input class="p-4 bg-gray-100 dark:bg-gray-700 rounded-xl"
               placeholder="Name on Card">
        <input class="p-4 bg-gray-100 dark:bg-gray-700 rounded-xl"
               placeholder="MM / YY">
        <input class="p-4 bg-gray-100 dark:bg-gray-700 rounded-xl"
               placeholder="CVC">
    </div>
</div>

<!-- CONFIRM -->
<button type="submit"
        name="confirm_payment"
        value="1"
        class="w-full mt-6 bg-[#0097D7] hover:bg-[#007fb8]
               text-white font-bold py-4 rounded-2xl text-lg shadow">
    Pay & Confirm Booking
</button>

<p class="text-xs text-gray-500 dark:text-gray-400 text-center">
    Secure payment · Instant confirmation · 24/7 support
</p>

</section>

<!-- ================= RIGHT ================= -->
<aside class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 h-fit sticky top-28 card-hover">

<h3 class="text-lg font-semibold mb-4">Booking Summary</h3>

<div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
    <div class="flex justify-between"><span>Check-in</span><span><?= fmtDate($checkin) ?></span></div>
    <div class="flex justify-between"><span>Check-out</span><span><?= fmtDate($checkout) ?></span></div>
    <div class="flex justify-between"><span>Guests</span><span><?= (int)$guests ?></span></div>
    <div class="flex justify-between"><span>Rooms</span><span><?= (int)$rooms ?></span></div>
</div>

<hr class="my-4 border-gray-200 dark:border-gray-700">

<div class="flex justify-between text-xl font-extrabold text-[#0097D7]">
    <span>Total</span>
    <span>£<?= number_format($price, 2) ?></span>
</div>

<p class="text-xs text-gray-500 dark:text-gray-400 mt-3">
    Includes taxes & fees
</p>

</aside>

</form>

</main>

<?php include "footer.php"; ?>
</body>
</html>
