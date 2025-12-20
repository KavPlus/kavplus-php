<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/currency.php';

$user = $_SESSION['user'] ?? null;
$isLogged = !empty($_SESSION['user_id']);
$name = $user['name'] ?? '';
$firstName = explode(' ', trim($name))[0] ?? '';
?>

<script>
if (localStorage.getItem('theme') === 'dark') {
  document.documentElement.classList.add('dark');
}
</script>

<header class="fixed top-0 left-0 right-0 md:left-60 h-16 md:h-20
               bg-white dark:bg-gray-900 border-b shadow z-40
               flex items-center justify-between px-6">

  <!-- LEFT -->
  <div class="flex items-center gap-3">
    <button id="sidebarToggle" class="md:hidden">☰</button>
    <input class="hidden md:block w-80 px-4 py-2 rounded-full bg-gray-100"
           placeholder="Destination, attraction, hotel">
  </div>

  <!-- RIGHT -->
  <div class="flex items-center gap-4 text-sm">

    <a href="support.php">Support</a>

    <!-- APP BUTTON (RESTORED) -->
    <button onclick="window.location.href='app-download.php'" title="Download App">
      📱
    </button>

    <!-- CURRENCY -->
    <form method="POST" action="set-currency.php">
      <select name="currency" onchange="this.form.submit()">
        <?php foreach ($CURRENCIES as $code => $v): ?>
          <option value="<?= $code ?>" <?= currency()===$code?'selected':'' ?>>
            <?= $code ?>
          </option>
        <?php endforeach; ?>
      </select>
    </form>

    <?php if ($isLogged): ?>
      <span>Hello, <?= htmlspecialchars($firstName) ?></span>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php" class="bg-[#0097D7] text-white px-3 py-2 rounded">Sign in</a>
      <a href="register.php" class="border px-3 py-2 rounded">Register</a>
    <?php endif; ?>
  </div>
</header>

<script>
document.getElementById('sidebarToggle')?.addEventListener('click', () => {
  document.getElementById('sidebar').classList.toggle('-translate-x-full');
});
</script>
