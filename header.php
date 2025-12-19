<?php
$user     = $_SESSION['user'] ?? null;
$isLogged = !empty($_SESSION['user_id']);
$name     = $user['name'] ?? '';
$role     = $user['role'] ?? 'user';

/* Time greeting */
$hour = (int) date('H');
if ($hour >= 5 && $hour < 12)      $greeting = "Good morning";
elseif ($hour < 17)               $greeting = "Good afternoon";
elseif ($hour < 22)               $greeting = "Good evening";
else                              $greeting = "Good night";

$firstName = trim(explode(" ", $name)[0] ?? '');
?>

<!-- EARLY THEME APPLY -->
<script>
(function () {
  const theme = localStorage.getItem('theme');
  if (theme === 'dark') {
    document.documentElement.classList.add('dark');
  }
})();
</script>

<header
  class="fixed top-0 left-0 right-0 md:left-60
         h-16 md:h-20 bg-white dark:bg-gray-900
         border-b border-gray-200 dark:border-gray-700
         shadow-sm z-40 flex items-center justify-between
         px-4 md:px-8">

  <!-- LEFT -->
  <div class="flex items-center gap-3">

    <button id="sidebarToggle"
            type="button"
            class="md:hidden text-gray-700 dark:text-gray-200">
      ☰
    </button>

    <input type="text"
      placeholder="Destination, attraction, hotel"
      class="hidden md:block w-80 px-4 py-2 rounded-full
             bg-gray-100 dark:bg-gray-800
             text-gray-700 dark:text-gray-200
             focus:ring-2 focus:ring-[#0097D7]">
  </div>

  <!-- RIGHT -->
  <div class="flex items-center gap-4 text-sm text-gray-700 dark:text-gray-200">

    <?php if ($isLogged): ?>
      <span class="hidden lg:flex items-center gap-1">
        👋 <?= htmlspecialchars("$greeting, $firstName"); ?>
      </span>
      <a href="/my-bookings.php">My Bookings</a>
    <?php endif; ?>

    <a href="/support.php">Support</a>

    <?php include_once __DIR__ . "/currency.php"; ?>

    <?php if ($isLogged): ?>
      <a href="/logout.php"
         class="px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-800">
        Logout
      </a>
    <?php else: ?>
      <a href="/login.php"
         class="px-4 py-2 bg-[#0097D7] text-white rounded-lg">
        Sign in
      </a>
      <a href="/register.php"
         class="px-4 py-2 border border-[#0097D7] text-[#0097D7] rounded-lg">
        Register
      </a>
    <?php endif; ?>
  </div>
</header>
