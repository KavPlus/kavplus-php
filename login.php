<?php
session_start();
require_once __DIR__ . '/db.php';

$error = '';

/* =========================
   ALREADY LOGGED IN?
========================= */
if (!empty($_SESSION['user_id'])) {
    header("Location: /kavplus/index.php");
    exit;
}

/* =========================
   HANDLE LOGIN
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Email and password are required.';
    } else {

        $pdo = db();
        $stmt = $pdo->prepare("
            SELECT id, name, email, password, role, status
            FROM users
            WHERE email = ?
            LIMIT 1
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (
            $user &&
            ($user['status'] ?? 'ACTIVE') === 'ACTIVE' &&
            password_verify($password, $user['password'])
        ) {

            /* 🔑 SINGLE SOURCE OF TRUTH */
            $_SESSION['user_id'] = (int)$user['id'];

            /* UI / DISPLAY */
            $_SESSION['user'] = [
                'id'    => (int)$user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'role'  => $user['role'] ?? 'user'
            ];

            header("Location: /kavplus/index.php");
            exit;
        }

        $error = 'Invalid email or password.';
    }
}

function h($v){
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In – KavPlus Travel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="ml-60 pt-24 flex justify-center px-6">

    <div class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-10 mb-16">

        <h1 class="text-3xl font-bold text-center mb-6 text-[#2D516C] dark:text-white">
            Sign In
        </h1>

        <?php if (!empty($error)): ?>
            <div class="mb-4 bg-red-100 dark:bg-red-900
                        text-red-700 dark:text-red-300
                        px-4 py-3 rounded-lg">
                <?= h($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">

            <!-- EMAIL -->
            <div>
                <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    required
                    value="<?= h($_POST['email'] ?? '') ?>"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700
                           bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white
                           focus:ring-2 focus:ring-[#0097D7] outline-none"
                />
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700
                           bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white
                           focus:ring-2 focus:ring-[#0097D7] outline-none"
                />
            </div>

            <!-- SUBMIT -->
            <button
                class="w-full py-3 rounded-lg font-semibold text-white
                       bg-[#0097D7] hover:bg-[#0083BD] transition">
                Sign In
            </button>

        </form>

        <!-- ✅ REGISTER LINK -->
        <div class="text-center mt-6 text-sm">
            <span class="text-gray-600 dark:text-gray-300">
                Don’t have an account?
            </span>
            <a href="/kavplus/register.php"
               class="ml-1 text-[#0097D7] font-semibold hover:underline">
                Create account
            </a>
        </div>

    </div>

</main>

<?php include "footer.php"; ?>

</body>
</html>
