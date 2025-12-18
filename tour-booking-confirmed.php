<?php
session_start();
require_once __DIR__ . '/db.php';

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

// Tour data from previous page
$tourName = $_GET['name'] ?? $_POST['tour_name'] ?? 'Tour';
$city     = $_GET['city'] ?? $_POST['city'] ?? '';
$price    = (float)($_GET['price'] ?? $_POST['price'] ?? 0);

// Handle booking submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pdo = db();

    $confirmation = 'KT-' . random_int(100000, 999999);

    $stmt = $pdo->prepare("
        INSERT INTO tour_bookings
        (user_id, confirmation, tour_name, city, tour_date, guests, total_paid, status, created_at)
        VALUES
        (:uid, :c, :t, :ci, :d, :g, :p, 'PAID', :at)
    ");

    $stmt->execute([
        ':uid' => $user['id'],
        ':c'   => $confirmation,
        ':t'   => $_POST['tour_name'],
        ':ci'  => $_POST['city'],
        ':d'   => $_POST['tour_date'],
        ':g'   => (int)$_POST['guests'],
        ':p'   => (float)$_POST['total'],
        ':at'  => date('Y-m-d H:i:s'),
    ]);

    header("Location: tour-booking-confirmed.php?c=" . urlencode($confirmation));
    exit;
}
?>

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tour Booking – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>

<style>
:root {
    --kav-primary:#0097D7;
    --kav-secondary:#007fb8;
}
.kav-btn{
    background:var(--kav-primary);
    color:#fff;
    border-radius:999px;
    padding:.9rem 1.6rem;
    font-weight:700;
    transition:.2s;
}
.kav-btn:hover{
    background:var(--kav-secondary);
    transform:translateY(-1px);
}
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900">

<main class="ml-60 pt-24 pb-20">

<form method="POST" class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6 px-6">

    <!-- HIDDEN FIELDS -->
    <input type="hidden" name="tour_name" value="<?= htmlspecialchars($tourName) ?>">
    <input type="hidden" name="city" value="<?= htmlspecialchars($city) ?>">
    <input type="hidden" name="price" value="<?= $price ?>">

    <!-- LEFT -->
    <section class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 lg:col-span-2 space-y-6">

        <!-- SUMMARY -->
        <div class="flex items-center gap-4">
            <img src="./banners/home.jpg"
                 onerror="this.src='./banners/tours.jpg'"
                 class="w-32 h-24 object-cover rounded-xl">
            <div>
                <h2 class="text-xl font-bold"><?= htmlspecialchars($tourName) ?></h2>
                <p class="text-gray-500 text-sm"><?= htmlspecialchars($city) ?></p>
            </div>
        </div>

        <!-- TOUR INFO -->
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

        <!-- GUEST INFO -->
        <div>
            <h3 class="font-semibold text-lg mb-3">Guest Information</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <input class="border rounded-xl p-3" placeholder="First Name">
                <input class="border rounded-xl p-3" placeholder="Last Name">
                <input class="border rounded-xl p-3" placeholder="Email">
                <input class="border rounded-xl p-3" placeholder="Phone">
            </div>
        </div>

        <!-- NOTES -->
        <div>
            <label class="text-sm font-medium">Special Requests (optional)</label>
            <textarea class="w-full border rounded-xl p-3 mt-1"
                      placeholder="Add special requests…"></textarea>
        </div>

    </section>

    <!-- RIGHT -->
    <aside class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 space-y-4">

        <h3 class="text-lg font-bold">Price Summary</h3>

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
            <span class="text-[#0097D7]">
                £<span id="totalPrice"><?= number_format($price,2) ?></span>
            </span>
        </div>

        <input type="hidden" name="total" id="totalInput" value="<?= $price ?>">

        <button type="submit" class="kav-btn w-full mt-4">
            Pay & Confirm Booking
        </button>

        <p class="text-xs text-gray-500 text-center">
            Secure payment • Instant confirmation
        </p>

    </aside>

</form>

<?php include "footer.php"; ?>

</main>

<script>
const pricePerGuest = <?= json_encode($price) ?>;

function updateTotal(){
    const guests = document.getElementById('guests').value;
    const total = pricePerGuest * guests;

    document.getElementById('guestCount').innerText = '× ' + guests;
    document.getElementById('totalPrice').innerText = total.toFixed(2);
    document.getElementById('totalInput').value = total.toFixed(2);
}
</script>

</body>
</html>
