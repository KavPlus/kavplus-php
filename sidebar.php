<?php


$current = basename($_SERVER["PHP_SELF"]);
$role = $_SESSION['user']['role'] ?? 'user';

function activeClass($page, $current) {
    return $page === $current
        ? "bg-[#0097D7]/15 text-[#0097D7] font-semibold"
        : "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800";
}
?>

<!-- LUCIDE ICONS -->
<script src="https://unpkg.com/lucide@latest"></script>

<!-- SIDEBAR -->
<aside id="sidebar"
       class="fixed top-0 left-0 h-screen w-60
              bg-white dark:bg-gray-900
              flex flex-col z-50
              transition-transform duration-300
              -translate-x-full md:translate-x-0">

    <!-- LOGO -->
    <div class="px-6 pt-4 pb-2">
        <a href="/index.php" class="block">
            <img src="/banners/logo.jpg"
                 alt="KAV+ Travel"
                 class="h-24 w-auto object-contain"
                 onerror="this.style.display='none'">
        </a>
    </div>

    <!-- NAV -->
    <nav class="flex-1 px-4 py-4 text-sm space-y-1 overflow-y-auto">

        <a href="/flights.php" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition <?= activeClass('flights.php',$current) ?>">
            <i data-lucide="plane" class="w-5 h-5"></i>
            <span>Flights</span>
        </a>

        <a href="/hotels.php" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition <?= activeClass('hotels.php',$current) ?>">
            <i data-lucide="hotel" class="w-5 h-5"></i>
            <span>Hotels</span>
        </a>

        <a href="/tours.php" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition <?= activeClass('tours.php',$current) ?>">
            <i data-lucide="map" class="w-5 h-5"></i>
            <span>Tours</span>
        </a>

        <a href="/deals.php" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition <?= activeClass('deals.php',$current) ?>">
            <i data-lucide="flame" class="w-5 h-5"></i>
            <span>Deals</span>
        </a>

        <a href="/rewards.php" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition <?= activeClass('rewards.php',$current) ?>">
            <i data-lucide="star" class="w-5 h-5"></i>
            <span>Rewards</span>
        </a>

        <a href="/support.php" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition <?= activeClass('support.php',$current) ?>">
            <i data-lucide="headset" class="w-5 h-5"></i>
            <span>Support</span>
        </a>

        <?php if ($role === 'admin'): ?>
            <div class="mt-6 mb-2 text-xs text-gray-400 dark:text-gray-500 px-4 uppercase tracking-wider">
                Admin
            </div>

            <a href="/admin-dashboard.php" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition hover:bg-gray-100 dark:hover:bg-gray-800">
                <i data-lucide="settings" class="w-5 h-5"></i>
                <span>Dashboard</span>
            </a>

            <a href="/admin-bookings.php" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition hover:bg-gray-100 dark:hover:bg-gray-800">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                <span>All Bookings</span>
            </a>
        <?php endif; ?>
    </nav>

    <!-- DARK MODE TOGGLE -->
    <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-800">
        <button id="darkToggle"
                type="button"
                class="w-full flex items-center justify-between px-4 py-3
                       rounded-lg bg-gray-100 dark:bg-gray-800
                       text-gray-700 dark:text-gray-200
                       hover:bg-gray-200 dark:hover:bg-gray-700 transition">
            <div class="flex items-center gap-2">
                <i id="themeIcon" data-lucide="moon" class="w-4 h-4"></i>
                <span id="themeText">Dark Mode</span>
            </div>
        </button>
    </div>
</aside>

<script>
(function () {
    const toggle = document.getElementById('darkToggle');
    const icon = document.getElementById('themeIcon');
    const text = document.getElementById('themeText');

    function applyTheme(theme) {
        document.documentElement.classList.toggle('dark', theme === 'dark');
        icon.setAttribute('data-lucide', theme === 'dark' ? 'sun' : 'moon');
        text.textContent = theme === 'dark' ? 'Light Mode' : 'Dark Mode';
        lucide.createIcons();
        localStorage.setItem('theme', theme);
    }

    if (toggle) {
        toggle.addEventListener('click', () => {
            applyTheme(document.documentElement.classList.contains('dark') ? 'light' : 'dark');
        });
    }

    lucide.createIcons();
})();
</script>
