<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/currency.php';

/* USER STATE */
$user     = $_SESSION['user'] ?? null;
$isLogged = !empty($_SESSION['user_id']);
$name     = $user['name'] ?? '';
$role     = $user['role'] ?? 'user';

/* TIME GREETING */
$hour = (int) date('H');
if ($hour >= 5 && $hour < 12)      $greeting = "Good morning";
elseif ($hour < 17)               $greeting = "Good afternoon";
elseif ($hour < 22)               $greeting = "Good evening";
else                              $greeting = "Good night";

$firstName = trim(explode(' ', $name)[0] ?? '');
?>
<!-- EARLY THEME APPLY (NO FLASH) -->
<script>
(function () {
  if (localStorage.getItem('theme') === 'dark') {
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
@keyframes greetingFade { to { opacity:1; transform:none; } }
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

<header class="fixed top-0 left-0 right-0 md:left-60 h-16 md:h-20
               bg-white dark:bg-gray-900 border-b border-gray-200
               dark:border-gray-700 shadow-sm z-40
               flex items-center justify-between px-4 md:px-8">

  <!-- LEFT -->
  <div class="flex items-center gap-3">
    <button id="sidebarToggle" class="md:hidden">☰</button>

    <input type="text"
      placeholder="Destination, attraction, hotel"
      class="hidden md:block w-80 px-4 py-2 rounded-full
             bg-gray-100 dark:bg-gray-800">
  </div>

  <!-- RIGHT -->
  <div class="flex items-center gap-4 text-sm">

    <?php if ($isLogged): ?>
      <span class="hidden lg:flex items-center gap-1 greeting-animate">
        <span class="wave">👋</span>
        <?= htmlspecialchars("$greeting, $firstName") ?>
      </span>
      <a href="my-bookings.php">My Bookings</a>
    <?php endif; ?>

    <a href="support.php">Support</a>

    <!-- CURRENCY -->
    <form method="POST" action="set-currency.php">
      <select name="currency" onchange="this.form.submit()">
        <?php foreach ($CURRENCIES as $code => $symbol): ?>
          <option value="<?= $code ?>" <?= currency()===$code?'selected':'' ?>>
            <?= $code ?>
          </option>
        <?php endforeach; ?>
      </select>
    </form>

    <?php if ($isLogged): ?>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php" class="px-3 py-2 bg-[#0097D7] text-white rounded">Sign in</a>
      <a href="register.php" class="px-3 py-2 border border-[#0097D7] rounded">Register</a>
    <?php endif; ?>

  </div>
</header>

<script>
(function () {
  const t = document.getElementById('sidebarToggle');
  const s = document.getElementById('sidebar');
  if (t && s) t.onclick = () => s.classList.toggle('-translate-x-full');
})();
</script>
