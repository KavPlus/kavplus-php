<?php
require_once __DIR__ . "/session.php";

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
    <div class="px-6 pt-4 pb-2 border-b border-gray-200 dark:border-gray-800">
        <a href="/index.php" class="block">
            <img src="/banners/logo.jpg"
                 alt="KAV+ Travel"
                 class="h-16 w-auto object-contain">
        </a>
    </div>

    <!-- NAV -->
    <nav class="flex-1 px-4 py-4 text-sm space-y-1 overflow-y-auto">

        <a href="/flights.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= activeClass('flights.php',$current) ?>">
            <i data-lucide="plane"></i><span>Flights</span>
        </a>

        <a href="/hotels.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= activeClass('hotels.php',$current) ?>">
            <i data-lucide="hotel"></i><span>Hotels</span>
        </a>

        <a href="/tours.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= activeClass('tours.php',$current) ?>">
            <i data-lucide="map"></i><span>Tours</span>
        </a>

        <a href="/deals.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= activeClass('deals.php',$current) ?>">
            <i data-lucide="flame"></i><span>Deals</span>
        </a>

        <a href="/rewards.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= activeClass('rewards.php',$current) ?>">
            <i data-lucide="star"></i><span>Rewards</span>
        </a>

        <a href="/support.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= activeClass('support.php',$current) ?>">
            <i data-lucide="headset"></i><span>Support</span>
        </a>

        <?php if ($role === 'admin'): ?>
            <div class="mt-6 text-xs text-gray-400 uppercase px-4">Admin</div>

            <a href="/admin-dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-lg">
                <i data-lucide="settings"></i><span>Dashboard</span>
            </a>
        <?php endif; ?>
    </nav>

    <!-- DARK MODE -->
    <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-800">
        <button id="darkToggle" class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-800">
            Dark Mode
        </button>
    </div>
</aside>

<script>
lucide.createIcons();
</script>
