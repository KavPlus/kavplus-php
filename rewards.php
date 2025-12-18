<?php include "auth.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>KavPlus Rewards</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { darkMode: 'class' }
</script>

<style>
:root{
  --kav:#0097D7;
  --kav2:#007fb8;
}
.card-hover{transition:.25s}
.card-hover:hover{transform:translateY(-3px);box-shadow:0 18px 45px rgba(0,0,0,.15)}
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="pt-24 md:ml-60 pb-20">

<div class="max-w-7xl mx-auto px-6">

<!-- PAGE HEADER -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
  <div>
    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">
      KavPlus Rewards
    </h1>
    <p class="text-gray-600 dark:text-gray-300 mt-1">
      Earn points on every booking. Redeem for exclusive discounts.
    </p>
  </div>

  <div class="mt-4 md:mt-0">
    <span class="px-4 py-2 rounded-xl bg-yellow-300 text-yellow-900 font-bold shadow">
      GOLD MEMBER
    </span>
  </div>
</div>

<!-- POINTS HERO -->
<div class="bg-gradient-to-r from-[#0097D7] to-[#007fb8]
            rounded-3xl p-8 text-white shadow-xl card-hover
            flex flex-col md:flex-row justify-between gap-6">

  <div>
    <p class="text-sm opacity-90">Your Reward Balance</p>
    <p class="text-5xl font-extrabold mt-1">4,850</p>
    <p class="text-sm opacity-80 mt-1">≈ £48.50 value</p>
  </div>

  <div class="flex items-center">
    <button class="bg-white text-[#0097D7] font-bold px-8 py-4 rounded-xl
                   hover:bg-gray-100 transition shadow">
      Redeem Points
    </button>
  </div>
</div>

<!-- TIER PROGRESS -->
<div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow card-hover">
  <div class="flex justify-between mb-2">
    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Silver</span>
    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Gold</span>
    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Platinum</span>
  </div>

  <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
    <div class="bg-[#0097D7] h-3 rounded-full" style="width:65%"></div>
  </div>

  <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
    1,150 points to reach Platinum
  </p>
</div>

<!-- QUICK STATS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">

  <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow card-hover">
    <p class="text-sm text-gray-500 dark:text-gray-400">Earned This Month</p>
    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">1,250</p>
  </div>

  <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow card-hover">
    <p class="text-sm text-gray-500 dark:text-gray-400">Points Used</p>
    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">920</p>
  </div>

  <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow card-hover">
    <p class="text-sm text-gray-500 dark:text-gray-400">Expiring Soon</p>
    <p class="text-3xl font-bold text-red-500 mt-2">200</p>
  </div>

</div>

<!-- POINTS HISTORY -->
<h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-12 mb-4">
  Points History
</h2>

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden card-hover">

  <!-- ITEM -->
  <div class="flex justify-between items-center p-5 border-b
              border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
    <div>
      <p class="font-semibold text-gray-900 dark:text-white">
        Flight Booking – London → Dubai
      </p>
      <p class="text-sm text-gray-500 dark:text-gray-400">
        12 Jan 2025
      </p>
    </div>
    <span class="text-green-500 font-bold text-lg">+650</span>
  </div>

  <div class="flex justify-between items-center p-5 border-b
              border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
    <div>
      <p class="font-semibold text-gray-900 dark:text-white">
        Hotel Booking – Tokyo
      </p>
      <p class="text-sm text-gray-500 dark:text-gray-400">
        05 Jan 2025
      </p>
    </div>
    <span class="text-green-500 font-bold text-lg">+320</span>
  </div>

  <div class="flex justify-between items-center p-5 border-b
              border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
    <div>
      <p class="font-semibold text-gray-900 dark:text-white">
        Redeemed – Flight Discount
      </p>
      <p class="text-sm text-gray-500 dark:text-gray-400">
        27 Dec 2024
      </p>
    </div>
    <span class="text-red-500 font-bold text-lg">-500</span>
  </div>

  <div class="flex justify-between items-center p-5 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
    <div>
      <p class="font-semibold text-gray-900 dark:text-white">
        Flight Booking – Manchester → NYC
      </p>
      <p class="text-sm text-gray-500 dark:text-gray-400">
        18 Dec 2024
      </p>
    </div>
    <span class="text-green-500 font-bold text-lg">+350</span>
  </div>

</div>

</div>

<?php include "footer.php"; ?>
</main>

<script src="include.js"></script>
</body>
</html>
