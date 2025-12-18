<?php
session_start();
require_once __DIR__ . '/db.php';

define('CURRENCY_SYMBOL', '£');

/* =========================
   AUTH GUARD
========================= */
if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

/* =========================
   INPUT
========================= */
$id   = (int)($_GET['id'] ?? 0);
$type = strtolower(trim($_GET['type'] ?? ''));

if ($id <= 0 || !in_array($type, ['flight','hotel','tour'], true)) {
    exit("Invalid request");
}

$pdo = db();

/* =========================
   LOAD BOOKING
========================= */
switch ($type) {
    case 'flight':
        $stmt = $pdo->prepare("
            SELECT
                confirmation,
                total_paid,
                status,
                created_at
            FROM bookings
            WHERE id = ? AND email = ?
            LIMIT 1
        ");
        $stmt->execute([$id, $user['email']]);
        break;

    case 'hotel':
        $stmt = $pdo->prepare("
            SELECT
                confirmation,
                total_paid,
                status,
                created_at
            FROM hotel_bookings
            WHERE id = ? AND user_id = ?
            LIMIT 1
        ");
        $stmt->execute([$id, (int)$user['id']]);
        break;

    case 'tour':
        $stmt = $pdo->prepare("
            SELECT
                confirmation,
                total_paid,
                status,
                created_at
            FROM tour_bookings
            WHERE id = ? AND user_id = ?
            LIMIT 1
        ");
        $stmt->execute([$id, (int)$user['id']]);
        break;
}

$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    exit("Booking not found or access denied");
}

/* =========================
   SAFE VALUES
========================= */
$confirmation = $booking['confirmation'] ?? '-';
$status       = $booking['status'] ?? 'PAID';
$totalPaid    = (float)($booking['total_paid'] ?? 0);
$createdAt    = $booking['created_at'] ?? '';
?>

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Ticket – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={darkMode:'class'}</script>

<style>
.kav{color:#0097D7}
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<main class="md:ml-60 pt-24 pb-20 px-6">

<div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-3xl shadow p-8">

    <div class="flex justify-between items-start gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Booking Ticket</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Official booking confirmation
            </p>
        </div>

        <span class="px-3 py-1 rounded-full text-sm font-semibold
            <?= strtoupper($status)==='CANCELLED'
                ? 'bg-red-100 text-red-700'
                : 'bg-green-100 text-green-700' ?>">
            <?= htmlspecialchars($status) ?>
        </span>
    </div>

    <div class="space-y-4 text-sm">

        <div class="flex justify-between">
            <span class="text-gray-500">Booking Reference</span>
            <span class="font-semibold"><?= htmlspecialchars($confirmation) ?></span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Booking Type</span>
            <span class="font-semibold uppercase"><?= htmlspecialchars($type) ?></span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Total Paid</span>
            <span class="font-bold kav">
                <?= CURRENCY_SYMBOL ?><?= number_format($totalPaid,2) ?>
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Booked On</span>
            <span><?= htmlspecialchars($createdAt) ?></span>
        </div>

    </div>

    <div class="mt-8 text-xs text-gray-500 dark:text-gray-400">
        This page is a ticket preview.  
        PDF generation can be added later.
    </div>

    <div class="mt-6 flex gap-3 flex-wrap">
        <a href="my-bookings.php"
           class="px-5 py-2 rounded-xl bg-[#0097D7] text-white font-semibold">
            My Bookings
        </a>

        <button onclick="window.print()"
                class="px-5 py-2 rounded-xl border border-gray-300 dark:border-gray-600">
            Print
        </button>
    </div>

</div>

<?php include "footer.php"; ?>
</main>
</body>
</html>
