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
   FETCH REFUNDS (ALL TYPES)
========================= */

/* FLIGHTS */
$fStmt = $pdo->query("
    SELECT
        confirmation,
        email,
        refund_amount,
        cancel_reason,
        cancelled_at,
        status,
        'FLIGHT' AS type
    FROM bookings
    WHERE status = 'CANCELLED'
    ORDER BY cancelled_at DESC
");
$flights = $fStmt->fetchAll(PDO::FETCH_ASSOC);

/* HOTELS */
$hStmt = $pdo->query("
    SELECT
        confirmation,
        user_id,
        refund_amount,
        cancel_reason,
        cancelled_at,
        status,
        'HOTEL' AS type
    FROM hotel_bookings
    WHERE status = 'CANCELLED'
    ORDER BY cancelled_at DESC
");
$hotels = $hStmt->fetchAll(PDO::FETCH_ASSOC);

/* TOURS */
$tStmt = $pdo->query("
    SELECT
        confirmation,
        user_id,
        refund_amount,
        cancel_reason,
        cancelled_at,
        status,
        'TOUR' AS type
    FROM tour_bookings
    WHERE status = 'CANCELLED'
    ORDER BY cancelled_at DESC
");
$tours = $tStmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   MERGE + SORT
========================= */
$all = array_merge($flights, $hotels, $tours);

usort($all, function($a, $b){
    return strtotime($b['cancelled_at'] ?? '') <=> strtotime($a['cancelled_at'] ?? '');
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin – Refunds</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">

<?php include "admin-header.php"; ?>

<main class="ml-64 p-6">

<!-- PAGE HEADER -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold">Refund Management</h1>
        <p class="text-sm text-gray-500">
            Cancelled bookings & refund amounts
        </p>
    </div>

    <a href="admin-dashboard.php"
       class="px-4 py-2 rounded-xl bg-gray-200">
        Dashboard
    </a>
</div>

<!-- REFUNDS TABLE -->
<div class="bg-white rounded-2xl shadow overflow-hidden">

<table class="w-full text-sm">
<thead class="bg-gray-50">
<tr>
    <th class="p-4 text-left">Type</th>
    <th class="p-4 text-left">Confirmation</th>
    <th class="p-4 text-center">Refund</th>
    <th class="p-4 text-left">Reason</th>
    <th class="p-4 text-center">Cancelled At</th>
    <th class="p-4 text-center">Action</th>
</tr>
</thead>
<tbody>

<?php if (empty($all)): ?>
<tr>
    <td colspan="6" class="p-6 text-center text-gray-500">
        No refunds found
    </td>
</tr>
<?php endif; ?>

<?php foreach ($all as $r): ?>
<tr class="border-t hover:bg-gray-50">

    <!-- TYPE -->
    <td class="p-4">
        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= typeBadge($r['type']) ?>">
            <?= h($r['type']) ?>
        </span>
    </td>

    <!-- CONFIRMATION -->
    <td class="p-4 font-mono">
        <?= h($r['confirmation']) ?>
    </td>

    <!-- REFUND -->
    <td class="p-4 text-center font-bold text-green-600">
        £<?= number_format((float)($r['refund_amount'] ?? 0), 2) ?>
    </td>

    <!-- REASON -->
    <td class="p-4 text-gray-600">
        <?= h($r['cancel_reason'] ?: '—') ?>
    </td>

    <!-- DATE -->
    <td class="p-4 text-center text-xs text-gray-500">
        <?= h($r['cancelled_at']) ?>
    </td>

    <!-- ACTION -->
    <td class="p-4 text-center">
        <button
            class="px-3 py-1 text-xs rounded-lg bg-emerald-100 text-emerald-700"
            onclick="alert('Refund is processed automatically in current system');">
            Processed
        </button>
    </td>

</tr>
<?php endforeach; ?>

</tbody>
</table>

</div>

</main>

</body>
</html>
