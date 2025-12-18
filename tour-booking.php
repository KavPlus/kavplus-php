<?php
session_start();
require_once __DIR__ . '/db.php';

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

/* =========================
   HANDLE BOOKING SUBMIT
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tour_name'])) {

    $pdo = db();
    $confirmation = 'KT-' . random_int(100000, 999999);

    $stmt = $pdo->prepare("
        INSERT INTO tour_bookings
        (user_id, confirmation, tour_name, city, tour_date, guests, total_paid, status, created_at)
        VALUES
        (:uid, :c, :t, :ci, :d, :g, :p, 'PAID', :at)
    ");

    $stmt->execute([
        ':uid' => (int)$user['id'],
        ':c'   => $confirmation,
        ':t'   => $_POST['tour_name'],
        ':ci'  => $_POST['city'],
        ':d'   => $_POST['tour_date'],
        ':g'   => (int)$_POST['guests'],
        ':p'   => (float)$_POST['total'],
        ':at'  => date('Y-m-d H:i:s'),
    ]);

    // ✅ GUARANTEED REDIRECT
    header("Location: tour-booking-details.php?c=" . urlencode($confirmation));
    exit;
}

/* =========================
   READ TOUR DATA (GET)
========================= */
$tourName = $_GET['name'] ?? 'Tour Experience';
$city     = $_GET['city'] ?? '';
$price    = (float)($_GET['price'] ?? 0);
$imgKey   = strtolower($_GET['img'] ?? $city);

/* Image resolver */
$images = [
    'london'    => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e',
    'paris'     => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34',
    'singapore' => 'https://images.unsplash.com/photo-1508964942454-1a56651d54ac',
    'tokyo'     => 'https://images.unsplash.com/photo-1549692520-acc6669e2f0c',
    'rome'      => 'https://images.unsplash.com/photo-1526481280691-906f6cfeaf41',
    'dubai'     => 'https://images.unsplash.com/photo-1508264165352-258859e62245'
];

$tourImage = $images[$imgKey] ?? 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tour Booking – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={darkMode:'class'}</script>

<style>
:root{--kav:#0097D7}
.kav-btn{
  background:var(--kav);
  color:#fff;
  border-radius:999px;
  padding:1rem 1.6rem;
  font-weight:700;
}
.kav-btn:hover{background:#007fb8}
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 pt-24 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="pb-20">

<form method="POST"
      class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6 px-6">

<input type="hidden" name="tour_name" value="<?= htmlspecialchars($tourName) ?>">
<input type="hidden" name="city" value="<?= htmlspecialchars($city) ?>">
<input type="hidden" name="price" value="<?= $price ?>">

<!-- LEFT -->
<section class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 lg:col-span-2 space-y-6">

<div class="flex gap-4 items-center">
    <img src="<?= htmlspecialchars($tourImage) ?>"
         class="w-32 h-24 rounded-xl object-cover shadow">
    <div>
        <h2 class="text-xl font-bold"><?= htmlspecialchars($tourName) ?></h2>
        <p class="text-gray-500 dark:text-gray-400"><?= htmlspecialchars($city) ?></p>
    </div>
</div>

<div>
<h3 class="font-semibold text-lg mb-3">Tour Information</h3>
<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Tour Date</label>
        <input type="date" name="tour_date" required
               class="w-full border rounded-xl p-3 mt-1">
    </div>

    <div>
        <label class="text-sm font-medium">Guests</label>
        <select name="guests" id="guests"
                class="w-full border rounded-xl p-3 mt-1"
                onchange="updateTotal()">
            <?php for($i=1;$i<=6;$i++): ?>
            <option value="<?= $i ?>"><?= $i ?> Guest<?= $i>1?'s':'' ?></option>
            <?php endfor; ?>
        </select>
    </div>
</div>
</div>

<div>
<h3 class="font-semibold text-lg mb-3">Guest Information</h3>
<div class="grid md:grid-cols-2 gap-4">
<input class="border rounded-xl p-3" placeholder="First Name">
<input class="border rounded-xl p-3" placeholder="Last Name">
<input class="border rounded-xl p-3" placeholder="Email">
<input class="border rounded-xl p-3" placeholder="Phone">
</div>
</div>

<textarea class="w-full border rounded-xl p-3"
placeholder="Special requests (optional)"></textarea>

</section>

<!-- RIGHT -->
<aside class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 space-y-4">

<h3 class="font-bold text-lg">Price Summary</h3>

<div class="flex justify-between text-sm">
<span>Price per guest</span>
<span>£<?= number_format($price,2) ?></span>
</div>

<div class="flex justify-between text-sm">
<span>Guests</span>
<span id="guestCount">× 1</span>
</div>

<hr>

<div class="flex justify-between text-xl font-bold">
<span>Total</span>
<span class="text-[#0097D7]">£<span id="totalPrice"><?= number_format($price,2) ?></span></span>
</div>

<input type="hidden" name="total" id="totalInput" value="<?= $price ?>">

<button type="submit" class="kav-btn w-full mt-4">
Pay & Confirm Booking
</button>

<p class="text-xs text-gray-500 dark:text-gray-400 text-center">
Secure payment • Instant confirmation
</p>

</aside>

</form>

<?php include "footer.php"; ?>
</main>

<script>
const pricePerGuest = <?= json_encode($price) ?>;
function updateTotal(){
    const g = document.getElementById('guests').value;
    const t = pricePerGuest * g;
    document.getElementById('guestCount').innerText = '× ' + g;
    document.getElementById('totalPrice').innerText = t.toFixed(2);
    document.getElementById('totalInput').value = t.toFixed(2);
}
</script>

</body>
</html>
