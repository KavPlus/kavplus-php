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
   DASHBOARD STATS (SAFE)
========================= */

// Total users
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

// Active users
$activeUsers = $pdo->query("
    SELECT COUNT(*) FROM users WHERE status='ACTIVE'
")->fetchColumn();

// Total bookings
$totalBookings = $pdo->query("
    SELECT COUNT(*) FROM bookings
")->fetchColumn();

// Revenue (SAFE fallback)
try {
    $stmt = $pdo->query("
        SELECT COALESCE(SUM(amount),0)
        FROM bookings
        WHERE payment_status = 'PAID'
    ");
    $revenue = $stmt->fetchColumn();
} catch (Exception $e) {
    // Column doesn't exist → fallback safely
    $revenue = 0;
}

function h($v){ return htmlspecialchars((string)$v); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>KAV+ Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B1220] text-gray-100">

<?php include 'admin-header.php'; ?>

<main class="ml-64 p-8">

  <!-- HEADER -->
  <div class="mb-10">
    <h1 class="text-3xl font-bold">Dashboard</h1>
    <p class="text-gray-400">
      Welcome back, <?= h($_SESSION['admin']['name'] ?? 'Admin') ?>
    </p>
  </div>

  <!-- STATS -->
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

    <div class="bg-[#111827] p-6 rounded-2xl shadow">
      <p class="text-gray-400 text-sm">Total Users</p>
      <p class="text-3xl font-bold mt-2"><?= (int)$totalUsers ?></p>
    </div>

    <div class="bg-[#111827] p-6 rounded-2xl shadow">
      <p class="text-gray-400 text-sm">Active Users</p>
      <p class="text-3xl font-bold mt-2 text-green-400">
        <?= (int)$activeUsers ?>
      </p>
    </div>

    <div class="bg-[#111827] p-6 rounded-2xl shadow">
      <p class="text-gray-400 text-sm">Bookings</p>
      <p class="text-3xl font-bold mt-2"><?= (int)$totalBookings ?></p>
    </div>

    <div class="bg-gradient-to-r from-sky-500 to-cyan-400 p-6 rounded-2xl shadow text-black">
      <p class="text-sm font-medium">Revenue</p>
      <p class="text-3xl font-bold mt-2">
        £<?= number_format((float)$revenue, 2) ?>
      </p>
    </div>

  </div>

  <!-- QUICK ACTIONS -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <a href="admin-users.php"
       class="bg-[#111827] hover:bg-white/5 p-6 rounded-2xl transition">
      <h2 class="text-xl font-semibold">Manage Users</h2>
      <p class="text-gray-400 text-sm mt-1">
        Enable, disable & control access
      </p>
    </a>

    <a href="admin-bookings.php"
       class="bg-[#111827] hover:bg-white/5 p-6 rounded-2xl transition">
      <h2 class="text-xl font-semibold">View Bookings</h2>
      <p class="text-gray-400 text-sm mt-1">
        Flights & reservations
      </p>
    </a>

    <a href="admin-settings.php"
       class="bg-[#111827] hover:bg-white/5 p-6 rounded-2xl transition">
      <h2 class="text-xl font-semibold">System Settings</h2>
      <p class="text-gray-400 text-sm mt-1">
        Platform configuration
      </p>
    </a>

  </div>

</main>

</body>
</html>
