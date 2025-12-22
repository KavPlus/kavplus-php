<?php
require_once __DIR__ . '/session.php';

/* =========================
   PAGE STATE
========================= */
$current = basename($_SERVER["PHP_SELF"]);
$role = $_SESSION['user']['role'] ?? 'user';

/* =========================
   ACTIVE LINK HELPER
========================= */
function activeClass($page, $current) {
    return $page === $current
        ? "bg-[#0097D7]/15 text-[#0097D7] font-semibold"
        : "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800";
}

/* =========================
   BASE PATH (for PHP pages)
========================= */
$BASE = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($BASE === '/' || $BASE === '\\') {
    $BASE = '';
}

/* =========================
   LOGO PATH (RELATIVE – REQUIRED FOR RENDER)
========================= */
$logoPath = 'banners/logo.jpg';
?>

<!-- LUCIDE ICONS -->
<script src="https://unpkg.com/lucide@latest"></script>

<aside id="sidebar"
       class="fixed top-0 left-0 h-screen w-60
              bg-white dark:bg-gray-900
              flex flex-col z-50
              transition-transform duration-300
              -translate-x-full md:translate-x-0">

    <!-- LOGO -->
    <div class="px-6 pt-4 pb-2">
        <a href="<?= $BASE ?>/index.php">
            <img src="<?= $logoPath ?>"
                 alt="KAV+ Travel"
                 class="h-24 w-auto object-contain"
                 onerror="this.style.display='none'">
        </a>
    </div>

    <!-- NAV -->
    <nav class="flex-1 px-4 py-4 text-sm space-y-1 overflow-y-auto">

        <a href="<?= $BASE ?>/flights.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= activeClass('flights.php',$current) ?>">
            <i data-lucide="plane"></i> Flights
        </a>

        <a href="<?= $BASE ?>/hotels.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= activeClass('hotels.php',$current) ?>">
            <i data-lucide="hotel"></i> Hotels
        </a>

        <a href="<?= $BASE ?>/tours.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= activeClass('tours.php',$current) ?>">
            <i data-lucide="map"></i> Tours
        </a>

        <a href="<?= $BASE ?>/deals.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= activeClass('deals.php',$current) ?>">
            <i data-lucide="flame"></i> Deals
        </a>

        <a href="<?= $BASE ?>/rewards.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= activeClass('rewards.php',$current) ?>">
            <i data-lucide="star"></i> Rewards
        </a>

        <a href="<?= $BASE ?>/support.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= activeClass('support.php',$current) ?>">
            <i data-lucide="headset"></i> Support
        </a>

        <?php if ($role === 'admin'): ?>
            <div class="mt-6 px-4 text-xs text-gray-400 uppercase">Admin</div>
            <a href="<?= $BASE ?>/admin-dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-lg">
                <i data-lucide="settings"></i> Dashboard
            </a>
        <?php endif; ?>
    </nav>

    <!-- DARK MODE -->
    <div class="px-4 py-4 border-t">
        <button id="darkToggle" class="w-full flex justify-between px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-800">
            <span>Dark Mode</span>
            <i id="themeIcon" data-lucide="moon"></i>
        </button>
    </div>
</aside>

<script>
(function () {
    const toggle = document.getElementById('darkToggle');
    toggle.onclick = () => {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem(
            'theme',
            document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        );
        lucide.createIcons();
    };
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }
    lucide.createIcons();
})();
</script>
