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
$adminId = (int)$_SESSION['admin']['id'];

/* =========================
   CSRF TOKEN
========================= */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* =========================
   HANDLE ACTIONS
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
        empty($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die('Invalid CSRF token');
    }

    $userId = (int)($_POST['user_id'] ?? 0);
    $action = $_POST['action'] ?? '';

    if ($userId > 0 && $userId !== $adminId) {

        if ($action === 'enable') {
            $stmt = $pdo->prepare(
                "UPDATE users SET status='ACTIVE' WHERE id=? LIMIT 1"
            );
            $stmt->execute([$userId]);
        }

        if ($action === 'disable') {
            $stmt = $pdo->prepare(
                "UPDATE users SET status='DISABLED' WHERE id=? LIMIT 1"
            );
            $stmt->execute([$userId]);
        }

        if ($action === 'delete') {
            $stmt = $pdo->prepare(
                "DELETE FROM users WHERE id=? LIMIT 1"
            );
            $stmt->execute([$userId]);
        }
    }

    header("Location: admin-users.php");
    exit;
}

/* =========================
   FETCH USERS
========================= */
$stmt = $pdo->query("
    SELECT id, name, email, role, status, created_at
    FROM users
    ORDER BY created_at DESC
");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

function h($v){ return htmlspecialchars((string)$v); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>KAV+ Admin – Users</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B1220] text-gray-100">

<?php include 'admin-header.php'; ?>

<main class="ml-64 p-8">

  <!-- HEADER -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold">Users</h1>
    <p class="text-gray-400">
      Manage platform users
    </p>
  </div>

  <!-- TABLE -->
  <div class="bg-[#111827] rounded-2xl shadow overflow-hidden">

    <table class="w-full text-sm">
      <thead class="bg-white/5 text-gray-300">
        <tr>
          <th class="p-4 text-left">Name</th>
          <th class="p-4 text-left">Email</th>
          <th class="p-4 text-center">Role</th>
          <th class="p-4 text-center">Status</th>
          <th class="p-4 text-center">Joined</th>
          <th class="p-4 text-center">Actions</th>
        </tr>
      </thead>
      <tbody>

      <?php if (!$users): ?>
        <tr>
          <td colspan="6" class="p-6 text-center text-gray-400">
            No users found
          </td>
        </tr>
      <?php endif; ?>

      <?php foreach ($users as $u): ?>
        <tr class="border-t border-white/5 hover:bg-white/5">

          <td class="p-4 font-medium"><?= h($u['name']) ?></td>
          <td class="p-4 text-gray-300"><?= h($u['email']) ?></td>

          <td class="p-4 text-center">
            <span class="px-3 py-1 rounded-full text-xs
              <?= $u['role']==='admin'
                ? 'bg-purple-500/20 text-purple-300'
                : 'bg-sky-500/20 text-sky-300' ?>">
              <?= strtoupper(h($u['role'])) ?>
            </span>
          </td>

          <td class="p-4 text-center">
            <span class="px-3 py-1 rounded-full text-xs
              <?= $u['status']==='ACTIVE'
                ? 'bg-green-500/20 text-green-300'
                : 'bg-red-500/20 text-red-300' ?>">
              <?= h($u['status']) ?>
            </span>
          </td>

          <td class="p-4 text-center text-xs text-gray-400">
            <?= date('Y-m-d', strtotime($u['created_at'])) ?>
          </td>

          <td class="p-4 text-center">
            <?php if ($u['id'] === $adminId): ?>
              <span class="text-xs text-gray-500 italic">You</span>
            <?php else: ?>
            <div class="flex justify-center gap-2">

              <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="user_id" value="<?= $u['id'] ?>">

                <?php if ($u['status']==='ACTIVE'): ?>
                  <input type="hidden" name="action" value="disable">
                  <button class="px-3 py-1 rounded-lg bg-amber-500/20 text-amber-300">
                    Disable
                  </button>
                <?php else: ?>
                  <input type="hidden" name="action" value="enable">
                  <button class="px-3 py-1 rounded-lg bg-green-500/20 text-green-300">
                    Enable
                  </button>
                <?php endif; ?>
              </form>

              <form method="POST"
                    onsubmit="return confirm('Delete this user permanently?');">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                <input type="hidden" name="action" value="delete">
                <button class="px-3 py-1 rounded-lg bg-red-500/20 text-red-300">
                  Delete
                </button>
              </form>

            </div>
            <?php endif; ?>
          </td>

        </tr>
      <?php endforeach; ?>

      </tbody>
    </table>

  </div>

</main>

</body>
</html>
