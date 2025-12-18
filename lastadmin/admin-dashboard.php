<?php
session_start();
require_once __DIR__ . '/../db.php';

/* =========================
   ADMIN GUARD
========================= */
if (empty($_SESSION['admin']) || ($_SESSION['admin']['role'] ?? '') !== 'admin') {
    header("Location: ../admin-login.php");
    exit;
}

$pdo = db();

/* =========================
   STATS
========================= */

/* USERS */
$users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

/* FLIGHTS */
$flightCount = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$flightRevenue = $pdo->query("SELECT COALESCE(SUM(total_paid),0) FROM bookings WHERE status='PAID'")->fetchColumn();

/* HOTELS */
$hotelCount = $pdo->query("SELECT COUNT(*) FROM hotel_bookings")->fetchColumn();
$hotelRevenue = $pdo->query("SELECT COALESCE(SUM(total_paid),0) FROM hotel_bookings WHERE status='PAID'")->fetchColumn();

/* TOURS */
$tourCount = $pdo->query("SELECT COUNT(*) FROM tour_bookings")->fetchColumn();
$tourRevenue = $pdo->query("SELECT COALESCE(SUM(total_paid),0) FROM tour_bookings WHERE status='PAID'")->fetchColumn();

/* TOTAL */
$totalRevenue = $flightRevenue + $hotelRevenue + $tourRevenue;

/* HELPERS */
function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard – KavPlus</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<!-- HEADER -->
<div class="bg-white shadow px-6 py-4 flex justify-between items-center">
  <div>
    <h1 class="text-xl font-bold">Admin Dashboard</h1>
    <p class="text-sm text-gray-500">Overview of platform activity</p>
  </div>
  <div class="flex items-center gap-3">
    <span class="text-sm text-gray-600">
      <?= h($_SESSION['admin']['name']) ?>
    </span>
    <a href="../admin-logout.php"
       class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
      Logout
    </a>
  </div>
</div>

<main class="p-6 space-y-6">

<!-- STATS GRID -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

  <div class="bg-white rounded-xl shadow p-6">
    <p class="text-sm text-gray-500">Total Users</p>
    <p class="text-3xl font-bold mt-2"><?= (int)$users ?></p>
  </div>

  <div class="bg-white rounded-xl shadow p-6">
    <p class="text-sm text-gray-500">Flights Booked</p>
    <p class="text-3xl font-bold mt-2"><?= (int)$flightCount ?></p>
    <p class="text-xs text-gray-400 mt-1">
      £<?= number_format($flightRevenue,2) ?> revenue
    </p>
  </div>

  <div class="bg-white rounded-xl shadow p-6">
    <p class="text-sm text-gray-500">Hotels Booked</p>
    <p class="text-3xl font-bold mt-2"><?= (int)$hotelCount ?></p>
    <p class="text-xs text-gray-400 mt-1">
      £<?= number_format($hotelRevenue,2) ?> revenue
    </p>
  </div>

  <div class="bg-white rounded-xl shadow p-6">
    <p class="text-sm text-gray-500">Tours Booked</p>
    <p class="text-3xl font-bold mt-2"><?= (int)$tourCount ?></p>
    <p class="text-xs text-gray-400 mt-1">
      £<?= number_format($tourRevenue,2) ?> revenue
    </p>
  </div>

</div>

<!-- TOTAL REVENUE -->
<div class="bg-white rounded-xl shadow p-6">
  <h2 class="text-lg font-bold mb-2">Total Revenue</h2>
  <p class="text-4xl font-extrabold text-green-600">
    £<?= number_format($totalRevenue,2) ?>
  </p>
</div>

<!-- QUICK LINKS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

  <a href="admin-bookings.php"
     class="bg-white rounded-xl shadow p-6 hover:bg-gray-50">
    <h3 class="font-bold">Manage Bookings</h3>
    <p class="text-sm text-gray-500 mt-1">View & cancel bookings</p>
  </a>

  <a href="../my-bookings.php"
     class="bg-white rounded-xl shadow p-6 hover:bg-gray-50">
    <h3 class="font-bold">Customer View</h3>
    <p class="text-sm text-gray-500 mt-1">See booking list UI</p>
  </a>

  <a href="../admin-logout.php"
     class="bg-white rounded-xl shadow p-6 hover:bg-gray-50">
    <h3 class="font-bold text-red-600">Logout</h3>
    <p class="text-sm text-gray-500 mt-1">End admin session</p>
  </a>

</div>

</main>
</body>
</html>
