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
   HANDLE USER ACTIONS
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';
    $userId = (int)($_POST['user_id'] ?? 0);

    if ($userId > 0) {

        if ($action === 'disable') {
            $stmt = $pdo->prepare("UPDATE users SET status='DISABLED' WHERE id=?");
            $stmt->execute([$userId]);
        }

        if ($action === 'enable') {
            $stmt = $pdo->prepare("UPDATE users SET status='ACTIVE' WHERE id=?");
            $stmt->execute([$userId]);
        }

        if ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
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
    SELECT
        id,
        name,
        email,
        role,
        status,
        created_at
    FROM users
    ORDER BY created_at DESC
");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   HELPERS
========================= */
function h($v){
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
?>

<?php include "admin-header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin – Users</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={darkMode:'class'}</script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<main class="ml-64 p-6">

  <!-- PAGE HEADER -->
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-bold">Users</h1>
      <p class="text-sm text-gray-500 dark:text-gray-400">
        Manage registered users
      </p>
    </div>

    <a href="admin-dashboard.php"
       class="px-4 py-2 rounded-xl bg-gray-200 dark:bg-gray-700">
      Dashboard
    </a>
  </div>

  <!-- USERS TABLE -->
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">

    <table class="w-full text-sm">
      <thead class="bg-gray-50 dark:bg-gray-700/60">
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

      <?php if (empty($users)): ?>
        <tr>
          <td colspan="6" class="p-6 text-center text-gray-500">
            No users found
          </td>
        </tr>
      <?php endif; ?>

      <?php foreach ($users as $u): ?>
        <tr class="border-t border-gray-100 dark:border-gray-700/70">

          <td class="p-4 font-semibold"><?= h($u['name']) ?></td>
          <td class="p-4"><?= h($u['email']) ?></td>

          <td class="p-4 text-center">
            <span class="px-3 py-1 rounded-full text-xs
              <?= $u['role']==='admin'
                ? 'bg-purple-100 text-purple-700'
                : 'bg-blue-100 text-blue-700' ?>">
              <?= h(strtoupper($u['role'])) ?>
            </span>
          </td>

          <td class="p-4 text-center">
            <span class="px-3 py-1 rounded-full text-xs
              <?= $u['status']==='ACTIVE'
                ? 'bg-green-100 text-green-700'
                : 'bg-red-100 text-red-700' ?>">
              <?= h($u['status']) ?>
            </span>
          </td>

          <td class="p-4 text-center text-xs text-gray-500">
            <?= h($u['created_at']) ?>
          </td>

          <td class="p-4 text-center">
            <div class="flex justify-center gap-2">

              <?php if ($u['status'] === 'ACTIVE'): ?>
                <form method="POST">
                  <input type="hidden" name="user_id" value="<?= (int)$u['id'] ?>">
                  <input type="hidden" name="action" value="disable">
                  <button class="px-3 py-1 text-xs rounded-lg bg-amber-500 text-white">
                    Disable
                  </button>
                </form>
              <?php else: ?>
                <form method="POST">
                  <input type="hidden" name="user_id" value="<?= (int)$u['id'] ?>">
                  <input type="hidden" name="action" value="enable">
                  <button class="px-3 py-1 text-xs rounded-lg bg-green-600 text-white">
                    Enable
                  </button>
                </form>
              <?php endif; ?>

              <form method="POST"
                    onsubmit="return confirm('Delete this user permanently?');">
                <input type="hidden" name="user_id" value="<?= (int)$u['id'] ?>">
                <input type="hidden" name="action" value="delete">
                <button class="px-3 py-1 text-xs rounded-lg bg-red-600 text-white">
                  Delete
                </button>
              </form>

            </div>
          </td>

        </tr>
      <?php endforeach; ?>

      </tbody>
    </table>

  </div>

</main>

</body>
</html>
