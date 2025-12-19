<?php
$current = basename($_SERVER["PHP_SELF"]);
$role = $_SESSION['user']['role'] ?? 'user';

function activeClass($page, $current) {
    return $page === $current
        ? "bg-[#0097D7]/15 text-[#0097D7] font-semibold"
        : "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800";
}
?>

<script src="https://unpkg.com/lucide@latest"></script>

<aside id="sidebar"
  class="fixed top-0 left-0 h-screen w-60
         bg-white dark:bg-gray-900
         flex flex-col z-50
         transition-transform duration-300
         -translate-x-full md:translate-x-0">

  <!-- LOGO -->
  <div class="px-6 pt-4 pb-2">
    <a href="/index.php">
      <img src="/banners/logo.jpg"
           alt="KAV+ Travel"
           class="h-20 w-auto object-contain">
    </a>
  </div>

  <!-- NAV -->
  <nav class="flex-1 px-4 py-4 text-sm space-y-1">

    <a href="flights.php" class="flex gap-3 px-4 py-3 rounded-lg <?= activeClass('flights.php',$current) ?>">
      <i data-lucide="plane"></i> Flights
    </a>

    <a href="hotels.php" class="flex gap-3 px-4 py-3 rounded-lg <?= activeClass('hotels.php',$current) ?>">
      <i data-lucide="hotel"></i> Hotels
    </a>

    <a href="tours.php" class="flex gap-3 px-4 py-3 rounded-lg <?= activeClass('tours.php',$current) ?>">
      <i data-lucide="map"></i> Tours
    </a>

    <a href="deals.php" class="flex gap-3 px-4 py-3 rounded-lg <?= activeClass('deals.php',$current) ?>">
      <i data-lucide="flame"></i> Deals
    </a>

    <a href="rewards.php" class="flex gap-3 px-4 py-3 rounded-lg <?= activeClass('rewards.php',$current) ?>">
      <i data-lucide="star"></i> Rewards
    </a>

    <a href="support.php" class="flex gap-3 px-4 py-3 rounded-lg <?= activeClass('support.php',$current) ?>">
      <i data-lucide="headset"></i> Support
    </a>

    <?php if ($role === 'admin'): ?>
      <div class="mt-4 text-xs uppercase text-gray-400 px-4">Admin</div>

      <a href="admin-dashboard.php" class="flex gap-3 px-4 py-3 rounded-lg">
        <i data-lucide="settings"></i> Dashboard
      </a>
    <?php endif; ?>

  </nav>

  <div class="px-4 py-4 border-t">
    <button id="darkToggle" class="w-full px-4 py-3 rounded-lg bg-gray-100">
      🌙 Dark Mode
    </button>
  </div>
</aside>

<script>
lucide.createIcons();
</script>
