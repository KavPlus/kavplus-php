<?php
session_start();
require_once __DIR__ . '/db.php';

/* =========================
   ADMIN GUARD
========================= */
if (empty($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit;
}

$pdo = db();

/* =========================
   FETCH FLIGHT BOOKINGS
========================= */
$fStmt = $pdo->query("
    SELECT
        id,
        confirmation,
        email,
        total_paid AS price,
        status,
        created_at,
        'FLIGHT' AS type
    FROM bookings
    ORDER BY created_at DESC
");
$flights = $fStmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   FETCH HOTEL BOOKINGS
========================= */
$hStmt = $pdo->query("
    SELECT
        id,
        confirmation,
        hotel_name AS title,
        city,
        total_paid AS price,
        status,
        created_at,
        'HOTEL' AS type
    FROM hotel_bookings
    ORDER BY created_at DESC
");
$hotels = $hStmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   FETCH TOUR BOOKINGS
========================= */
$tStmt = $pdo->query("
    SELECT
        id,
        confirmation,
        tour_name AS title,
        city,
        total_paid AS price,
        status,
        created_at,
        'TOUR' AS type
    FROM tour_bookings
    ORDER BY created_at DESC
");
$tours = $tStmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   MERGE + SORT
========================= */
$all = array_merge($flights, $hotels, $tours);

usort($all, function ($a, $b) {
    return strtotime($b['created_at']) <=> strtotime($a['created_at']);
});

/* =========================
   HELPERS
========================= */
function h($v){
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function typeBadge($type){
    return match($type){
        'FLIGHT' => 'bg-blue-100 text-blue-700',
        'HOTEL'  => 'bg-green-100 text-green-700',
        'TOUR'   => 'bg-purple-100 text-purple-700',
        default  => 'bg-gray-100 text-gray-700',
    };
}

function statusBadge($status){
    $s = strtoupper((string)$status);
    return match($s){
        'PAID','CONFIRMED','COMPLETED' => 'bg-emerald-100 text-emerald-700',
        'PENDING' => 'bg-amber-100 text-amber-700',
        'CANCELLED','FAILED' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-700',
    };
}

include "admin-header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin – Bookings</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">

<main class="ml-64 p-6">

<!-- PAGE HEADER -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold">All Bookings</h1>
        <p class="text-sm text-gray-500">
            Flights, Hotels & Tours (Global View)
        </p>
    </div>

    <a href="admin-dashboard.php"
       class="px-4 py-2 rounded-xl bg-gray-200">
        Dashboard
    </a>
</div>

<!-- BOOKINGS TABLE -->
<div class="bg-white rounded-2xl shadow overflow-hidden">

<table class="w-full text-sm">
<thead class="bg-gray-50">
<tr>
    <th class="p-4 text-left">Type</th>
    <th class="p-4 text-left">Confirmation</th>
    <th class="p-4 text-left">Details</th>
    <th class="p-4 text-center">Amount</th>
    <th class="p-4 text-center">Status</th>
    <th class="p-4 text-center">Created</th>
    <th class="p-4 text-center">Actions</th>
</tr>
</thead>
<tbody>

<?php if (empty($all)): ?>
<tr>
    <td colspan="7" class="p-6 text-center text-gray-500">
        No bookings found
    </td>
</tr>
<?php endif; ?>

<?php foreach ($all as $b): ?>
<tr class="border-t hover:bg-gray-50">

    <!-- TYPE -->
    <td class="p-4">
        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= typeBadge($b['type']) ?>">
            <?= h($b['type']) ?>
        </span>
    </td>

    <!-- CONFIRMATION -->
    <td class="p-4 font-mono text-sm">
        <?= h($b['confirmation']) ?>
    </td>

    <!-- DETAILS -->
    <td class="p-4">
        <?php if ($b['type'] === 'FLIGHT'): ?>
            <div class="font-semibold">Flight Booking</div>
            <div class="text-xs text-gray-500"><?= h($b['email'] ?? '') ?></div>
        <?php else: ?>
            <div class="font-semibold"><?= h($b['title'] ?? '') ?></div>
            <div class="text-xs text-gray-500"><?= h($b['city'] ?? '') ?></div>
        <?php endif; ?>
    </td>

    <!-- AMOUNT -->
    <td class="p-4 text-center font-semibold">
        £<?= number_format((float)$b['price'], 2) ?>
    </td>

    <!-- STATUS -->
    <td class="p-4 text-center">
        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= statusBadge($b['status']) ?>">
            <?= h($b['status']) ?>
        </span>
    </td>

    <!-- DATE -->
    <td class="p-4 text-center text-xs text-gray-500">
        <?= h($b['created_at']) ?>
    </td>

    <!-- ACTIONS -->
    <td class="p-4 text-center">
        <div class="flex justify-center gap-2">
            <a href="invoice-pdf.php?c=<?= urlencode($b['confirmation']) ?>"
               class="text-blue-600 hover:underline text-xs">
               Invoice
            </a>

            <form method="POST" action="cancel-booking.php"
                  onsubmit="return confirm('Cancel this booking?');">
                <input type="hidden" name="confirmation" value="<?= h($b['confirmation']) ?>">
                <input type="hidden" name="type" value="<?= h($b['type']) ?>">
                <button class="text-red-600 hover:underline text-xs">
                    Cancel
                </button>
            </form>
        </div>
    </td>

</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

</main>

</body>
</html>
