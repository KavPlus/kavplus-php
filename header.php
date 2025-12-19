<?php
$user = $_SESSION['user'] ?? null;
$isLogged = isset($_SESSION['user_id']);
$name = $user['name'] ?? '';
$firstName = explode(' ', trim($name))[0] ?? '';

$hour = (int) date('H');
$greeting =
  $hour < 12 ? "Good morning" :
  ($hour < 17 ? "Good afternoon" :
  ($hour < 22 ? "Good evening" : "Good night"));
?>

<header class="fixed top-0 left-0 right-0 md:left-60 h-16 bg-white shadow flex items-center justify-between px-6 z-40">

  <div class="flex items-center gap-3">
    <button id="sidebarToggle" class="md:hidden">☰</button>

    <input type="text"
      placeholder="Destination, attraction, hotel"
      class="hidden md:block w-80 px-4 py-2 rounded-full bg-gray-100">
  </div>

  <div class="flex items-center gap-4 text-sm">

    <?php if ($isLogged): ?>
      <span><?= htmlspecialchars("$greeting, $firstName") ?></span>
      <a href="my-bookings.php">My Bookings</a>
    <?php endif; ?>

    <a href="support.php">Support</a>

    <?php if ($isLogged): ?>
      <a href="logout.php" class="px-3 py-2 bg-gray-100 rounded">Logout</a>
    <?php else: ?>
      <a href="login.php" class="px-4 py-2 bg-blue-600 text-white rounded">Sign in</a>
      <a href="register.php" class="px-4 py-2 border rounded">Register</a>
    <?php endif; ?>

  </div>
</header>

<script>
document.getElementById('sidebarToggle')?.addEventListener('click', () => {
  document.getElementById('sidebar')?.classList.toggle('-translate-x-full');
});
</script>
