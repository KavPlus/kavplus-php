<?php
session_start();
require_once __DIR__ . '/db.php';

$error = '';

/* =========================
   REDIRECT IF ALREADY LOGGED IN
========================= */
if (!empty($_SESSION['admin'])) {
    header("Location: admin-dashboard.php");
    exit;
}

/* =========================
   CSRF TOKEN
========================= */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* =========================
   HANDLE LOGIN
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
        empty($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        $error = 'Invalid session. Please refresh and try again.';
    } else {

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $pdo = db();
        $stmt = $pdo->prepare("
            SELECT id, name, email, password, role
            FROM users
            WHERE email = ?
              AND role = 'admin'
              AND status = 'ACTIVE'
            LIMIT 1
        ");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {

            $_SESSION['admin'] = [
                'id'    => $admin['id'],
                'name'  => $admin['name'],
                'email' => $admin['email'],
                'role'  => $admin['role']
            ];

            header("Location: admin-dashboard.php");
            exit;
        }

        $error = "Invalid admin credentials.";
    }
}

function h($v){ return htmlspecialchars((string)$v); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>KAV+ Admin Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-[#0B1220] text-gray-100">

<div class="w-full max-w-md bg-[#111827] rounded-2xl shadow-xl p-8">

  <!-- LOGO -->
  <div class="text-center mb-6">
    <h1 class="text-3xl font-bold text-sky-400">KAV+</h1>
    <p class="text-gray-400 text-sm">Admin Panel Login</p>
  </div>

  <?php if ($error): ?>
    <div class="mb-4 bg-red-500/10 text-red-400 p-3 rounded-xl text-sm">
      <?= h($error) ?>
    </div>
  <?php endif; ?>

  <!-- LOGIN FORM -->
  <form method="POST" class="space-y-4">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

    <div>
      <label class="text-sm text-gray-400">Email</label>
      <input
        type="email"
        name="email"
        required
        class="w-full mt-1 px-4 py-2 rounded-xl bg-[#0B1220] border border-white/10 focus:outline-none focus:ring-2 focus:ring-sky-500"
      >
    </div>

    <div>
      <label class="text-sm text-gray-400">Password</label>
      <input
        type="password"
        name="password"
        required
        class="w-full mt-1 px-4 py-2 rounded-xl bg-[#0B1220] border border-white/10 focus:outline-none focus:ring-2 focus:ring-sky-500"
      >
    </div>

    <button
      class="w-full py-3 rounded-xl bg-gradient-to-r from-sky-500 to-cyan-400 text-black font-semibold hover:opacity-90 transition">
      Login
    </button>
  </form>

  <p class="text-center text-xs text-gray-500 mt-6">
    © <?= date('Y') ?> KavPlus Travel
  </p>

</div>

</body>
</html>
