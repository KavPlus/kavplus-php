<?php
session_start();
require_once __DIR__ . '/db.php';

/* =========================
   ADMIN GUARD
========================= */
if (empty($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit;
}

$pdo = db();

/* =========================
   CSRF TOKEN
========================= */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* =========================
   CREATE SETTINGS TABLE IF NOT EXISTS
========================= */
$pdo->exec("
    CREATE TABLE IF NOT EXISTS settings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        site_name VARCHAR(100) NOT NULL,
        support_email VARCHAR(100) NOT NULL,
        currency_symbol VARCHAR(10) NOT NULL,
        refund_window INTEGER NOT NULL,
        maintenance_mode INTEGER NOT NULL DEFAULT 0
    )
");

/* =========================
   ENSURE ONE SETTINGS ROW
========================= */
$count = $pdo->query("SELECT COUNT(*) FROM settings")->fetchColumn();
if ((int)$count === 0) {
    $stmt = $pdo->prepare("
        INSERT INTO settings
        (site_name, support_email, currency_symbol, refund_window, maintenance_mode)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        'KavPlus Travel',
        'support@kavplus.com',
        '£',
        48,
        0
    ]);
}

/* =========================
   LOAD SETTINGS
========================= */
$settings = $pdo->query("SELECT * FROM settings LIMIT 1")
                ->fetch(PDO::FETCH_ASSOC);

/* =========================
   SAVE SETTINGS
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
        empty($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die('Invalid CSRF token');
    }

    $siteName  = trim($_POST['site_name']);
    $email     = trim($_POST['support_email']);
    $currency  = trim($_POST['currency_symbol']);
    $refundHrs = max(1, (int)$_POST['refund_window']);
    $maint     = isset($_POST['maintenance_mode']) ? 1 : 0;

    $stmt = $pdo->prepare("
        UPDATE settings SET
            site_name = ?,
            support_email = ?,
            currency_symbol = ?,
            refund_window = ?,
            maintenance_mode = ?
        WHERE id = 1
    ");
    $stmt->execute([
        $siteName,
        $email,
        $currency,
        $refundHrs,
        $maint
    ]);

    header("Location: admin-settings.php?saved=1");
    exit;
}

/* =========================
   HELPER
========================= */
function h($v){
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>KAV+ Admin – Settings</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B1220] text-gray-100">

<?php include 'admin-header.php'; ?>

<main class="ml-64 p-8 max-w-4xl">

  <!-- HEADER -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold">System Settings</h1>
    <p class="text-gray-400">Global platform configuration</p>
  </div>

  <?php if (isset($_GET['saved'])): ?>
    <div class="mb-6 bg-green-500/10 text-green-400 px-5 py-3 rounded-xl">
      ✔ Settings updated successfully
    </div>
  <?php endif; ?>

  <!-- FORM -->
  <form method="POST" class="bg-[#111827] rounded-2xl p-8 space-y-8">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

    <!-- SITE -->
    <div>
      <h3 class="text-lg font-semibold mb-3">Site</h3>
      <input
        type="text"
        name="site_name"
        value="<?= h($settings['site_name']) ?>"
        class="w-full px-4 py-3 rounded-xl bg-[#0B1220] border border-white/10"
        required
      />
    </div>

    <!-- SUPPORT -->
    <div>
      <h3 class="text-lg font-semibold mb-3">Support</h3>
      <input
        type="email"
        name="support_email"
        value="<?= h($settings['support_email']) ?>"
        class="w-full px-4 py-3 rounded-xl bg-[#0B1220] border border-white/10"
        required
      />
    </div>

    <!-- PAYMENTS -->
    <div class="grid md:grid-cols-2 gap-6">
      <div>
        <label class="text-sm text-gray-400">Currency Symbol</label>
        <input
          type="text"
          name="currency_symbol"
          value="<?= h($settings['currency_symbol']) ?>"
          class="w-full px-4 py-3 rounded-xl bg-[#0B1220] border border-white/10"
        />
      </div>

      <div>
        <label class="text-sm text-gray-400">Refund Window (hours)</label>
        <input
          type="number"
          min="1"
          name="refund_window"
          value="<?= (int)$settings['refund_window'] ?>"
          class="w-full px-4 py-3 rounded-xl bg-[#0B1220] border border-white/10"
        />
      </div>
    </div>

    <!-- SYSTEM -->
    <div>
      <label class="flex items-center gap-3">
        <input
          type="checkbox"
          name="maintenance_mode"
          <?= $settings['maintenance_mode'] ? 'checked' : '' ?>
          class="w-5 h-5 accent-sky-500"
        >
        <span>Enable maintenance mode (site offline)</span>
      </label>
    </div>

    <!-- ACTIONS -->
    <div class="flex gap-4 pt-4">
      <button
        type="submit"
        class="px-6 py-3 rounded-xl bg-gradient-to-r from-sky-500 to-cyan-400 text-black font-semibold">
        Save Settings
      </button>

      <a href="admin-dashboard.php"
         class="px-6 py-3 rounded-xl bg-white/5">
        Cancel
      </a>
    </div>
  </form>

</main>

</body>
</html>
