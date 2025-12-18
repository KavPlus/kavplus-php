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
   LOAD CURRENT SETTINGS
========================= */
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch(PDO::FETCH_ASSOC) ?: [
    'site_name'        => 'KavPlus Travel',
    'support_email'    => 'support@kavplus.com',
    'currency_symbol'  => '£',
    'refund_window'    => 48,
    'maintenance_mode' => 0
];

/* =========================
   SAVE SETTINGS
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $siteName   = trim($_POST['site_name']);
    $email      = trim($_POST['support_email']);
    $currency   = trim($_POST['currency_symbol']);
    $refundHrs  = (int)$_POST['refund_window'];
    $maint      = isset($_POST['maintenance_mode']) ? 1 : 0;

    $pdo->prepare("
        UPDATE settings SET
            site_name = ?,
            support_email = ?,
            currency_symbol = ?,
            refund_window = ?,
            maintenance_mode = ?
        LIMIT 1
    ")->execute([
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
   HELPERS
========================= */
function h($v){
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin – Settings</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">

<?php include "admin-header.php"; ?>

<main class="ml-64 p-6 max-w-4xl">

<!-- HEADER -->
<div class="mb-6">
    <h1 class="text-2xl font-bold">System Settings</h1>
    <p class="text-sm text-gray-500">
        Manage global platform configuration
    </p>
</div>

<?php if (isset($_GET['saved'])): ?>
<div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-6">
    ✔ Settings updated successfully
</div>
<?php endif; ?>

<!-- SETTINGS FORM -->
<form method="POST" class="bg-white rounded-2xl shadow p-6 space-y-6">

    <!-- SITE -->
    <div>
        <h3 class="font-bold mb-3">Site</h3>

        <label class="block text-sm font-medium mb-1">Site Name</label>
        <input
            type="text"
            name="site_name"
            value="<?= h($settings['site_name']) ?>"
            class="w-full border rounded-xl p-3"
            required
        />
    </div>

    <!-- SUPPORT -->
    <div>
        <h3 class="font-bold mb-3">Support</h3>

        <label class="block text-sm font-medium mb-1">Support Email</label>
        <input
            type="email"
            name="support_email"
            value="<?= h($settings['support_email']) ?>"
            class="w-full border rounded-xl p-3"
            required
        />
    </div>

    <!-- PAYMENTS -->
    <div>
        <h3 class="font-bold mb-3">Payments</h3>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Currency Symbol</label>
                <input
                    type="text"
                    name="currency_symbol"
                    value="<?= h($settings['currency_symbol']) ?>"
                    class="w-full border rounded-xl p-3"
                />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Refund Window (hours)</label>
                <input
                    type="number"
                    name="refund_window"
                    min="1"
                    value="<?= (int)$settings['refund_window'] ?>"
                    class="w-full border rounded-xl p-3"
                />
            </div>
        </div>
    </div>

    <!-- MAINTENANCE -->
    <div>
        <h3 class="font-bold mb-3">System</h3>

        <label class="flex items-center gap-3">
            <input
                type="checkbox"
                name="maintenance_mode"
                <?= $settings['maintenance_mode'] ? 'checked' : '' ?>
                class="w-5 h-5"
            >
            <span>Enable maintenance mode (site offline)</span>
        </label>
    </div>

    <!-- SAVE -->
    <div class="pt-4 flex gap-3">
        <button
            type="submit"
            class="px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700">
            Save Settings
        </button>

        <a href="admin-dashboard.php"
           class="px-6 py-3 rounded-xl border">
            Cancel
        </a>
    </div>

</form>

</main>

</body>
</html>
