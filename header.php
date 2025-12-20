<?php
// ✅ DO NOT start session here.
// Session must be started once in each page (index.php, flights.php...) using session.php
// Example at top of pages:
// <?php require_once __DIR__ . "/session.php"; ?>

require_once __DIR__ . "/currency.php";

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

<!-- EARLY THEME APPLY (NO FLASH) -->
<script>
(function () {
  const theme = localStorage.getItem('theme');
  if (theme === 'dark') {
    document.documentElement.classList.add('dark');
  }
})();
</script>

<style>
.greeting-animate {
  opacity: 0;
  transform: translateY(6px);
  animation: greetingFade .6s ease-out forwards;
}
@keyframes greetingFade {
  to { opacity:1; transform:none; }
}
.wave {
  display:inline-block;
  transform-origin:70% 70%;
  animation: waveHand 1.6s ease-in-out 1;
}
@keyframes waveHand {
  0%{transform:rotate(0)}
  10%{transform:rotate(14deg)}
  20%{transform:rotate(-8deg)}
  30%{transform:rotate(14deg)}
  40%{transform:rotate(-4deg)}
  50%{transform:rotate(10deg)}
  60%,100%{transform:rotate(0)}
}
</style>

<header
  class="fixed top-0 left-0 right-0
         md:left-60
         h-16 md:h-20
         bg-white dark:bg-gray-900
         border-b border-gray-200 dark:border-gray-700
         shadow-sm z-40
         flex items-center justify-between
         px-4 md:px-8">

  <!-- LEFT -->
  <div class="flex items-center gap-3 w-full md:w-auto">

    <!-- MOBILE SIDEBAR TOGGLE -->
    <button id="sidebarToggle"
            type="button"
            class="md:hidden text-gray-700 dark:text-gray-200">
      ☰
    </button>

    <!-- SEARCH -->
    <input type="text"
      placeholder="Destination, attraction, hotel"
      class="hidden md:block w-80 px-4 py-2 rounded-full
             bg-gray-100 dark:bg-gray-800
             text-gray-700 dark:text-gray-200
             focus:ring-2 focus:ring-[#0097D7]">
  </div>

  <!-- RIGHT -->
  <div class="flex items-center gap-4 md:gap-6 text-sm
              text-gray-700 dark:text-gray-200 whitespace-nowrap">

    <?php if ($isLogged): ?>
      <span class="hidden lg:flex items-center gap-1
                   text-gray-600 dark:text-gray-300 greeting-animate">
        <span class="wave">👋</span>
        <?= htmlspecialchars("$greeting, $firstName"); ?>
      </span>

      <a href="my-bookings.php" class="hover:text-[#0097D7]">
        My Bookings
      </a>
    <?php endif; ?>

    <a href="support.php" class="hover:text-[#0097D7]">
      Support
    </a>

    <!-- APP -->
    <button type="button"
      onclick="window.openAppModal && openAppModal()"
      class="hover:text-[#0097D7]">
      📱
    </button>

    <!-- CURRENCY -->
    <form method="POST" action="set-currency.php">
      <select name="currency"
        onchange="this.form.submit()"
        class="bg-transparent cursor-pointer
               text-gray-700 dark:text-gray-200">
        <?php foreach ($CURRENCIES as $code => $c): ?>
          <option value="<?= $code ?>" <?= currency() === $code ? 'selected' : '' ?>>
            <?= $code ?>
          </option>
        <?php endforeach; ?>
      </select>
    </form>

    <?php if ($isLogged): ?>
      <!-- LOGOUT -->
      <a href="logout.php"
        class="px-3 py-2 rounded-lg
               bg-gray-100 dark:bg-gray-800
               hover:bg-gray-200 dark:hover:bg-gray-700">
        Logout
      </a>
    <?php else: ?>
      <!-- SIGN IN + REGISTER -->
      <a href="login.php"
        class="px-4 py-2 bg-[#0097D7] text-white rounded-lg">
        Sign in
      </a>

      <a href="register.php"
        class="px-4 py-2 rounded-lg border
               border-[#0097D7] text-[#0097D7]
               hover:bg-[#0097D7] hover:text-white transition">
        Register
      </a>
    <?php endif; ?>

  </div>
</header>

<!-- MOBILE SIDEBAR SCRIPT -->
<script>
(function () {
  const toggle = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');

  if (toggle && sidebar) {
    toggle.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });
  }
})();
</script>
