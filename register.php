<?php
session_start();
require_once __DIR__ . '/db.php';

$error = "";

/* =========================
   ALREADY LOGGED IN?
========================= */
if (!empty($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name     = trim($_POST["name"] ?? "");
    $email    = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm  = $_POST["confirm_password"] ?? "";

    /* =========================
       VALIDATION
    ========================= */
    if ($name === "" || $email === "" || $password === "" || $confirm === "") {
        $error = "All fields are required.";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email.";
    }
    elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    }
    elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    }
    else {

        $pdo = db();

        /* =========================
           CHECK EMAIL EXISTS
        ========================= */
        $stmt = $pdo->prepare("
            SELECT id
            FROM users
            WHERE email = ?
            LIMIT 1
        ");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = "This email is already registered. Please sign in.";
        }
        else {

            /* =========================
               CREATE USER
            ========================= */
            $stmt = $pdo->prepare("
                INSERT INTO users
                (name, email, password, role, status, created_at)
                VALUES (?, ?, ?, 'user', 'ACTIVE', ?)
            ");
            $stmt->execute([
                $name,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                date('Y-m-d H:i:s')
            ]);

            /* =========================
               AUTO LOGIN (NO RE-SIGN-IN)
            ========================= */
            $userId = $pdo->lastInsertId();

            $_SESSION['user_id'] = (int)$userId;
            $_SESSION['user'] = [
                'id'    => (int)$userId,
                'name'  => $name,
                'email' => $email,
                'role'  => 'user'
            ];

            header("Location: /kavplus/index.php");
            exit;
        }
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
    <title>Register – KavPlus Travel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: "class" }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="ml-60 pt-24 flex justify-center px-6">

    <div class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-10 mb-16">

        <h1 class="text-3xl font-bold text-center mb-6 text-[#2D516C] dark:text-white">
            Create Account
        </h1>

        <?php if (!empty($error)): ?>
            <div class="mb-4 bg-red-100 dark:bg-red-900
                        text-red-700 dark:text-red-300
                        px-4 py-3 rounded-lg">
                <?= h($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">

            <!-- FULL NAME -->
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">
                    Full Name
                </label>
                <input
                    type="text"
                    name="name"
                    required
                    value="<?= h($_POST["name"] ?? "") ?>"
                    class="w-full border border-gray-300 dark:border-gray-700
                           bg-gray-50 dark:bg-gray-700
                           text-gray-900 dark:text-white
                           rounded-lg px-3 py-2
                           focus:ring-2 focus:ring-[#0097D7] outline-none"
                >
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    required
                    value="<?= h($_POST["email"] ?? "") ?>"
                    class="w-full border border-gray-300 dark:border-gray-700
                           bg-gray-50 dark:bg-gray-700
                           text-gray-900 dark:text-white
                           rounded-lg px-3 py-2
                           focus:ring-2 focus:ring-[#0097D7] outline-none"
                >
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full border border-gray-300 dark:border-gray-700
                           bg-gray-50 dark:bg-gray-700
                           text-gray-900 dark:text-white
                           rounded-lg px-3 py-2
                           focus:ring-2 focus:ring-[#0097D7] outline-none"
                >
            </div>

            <!-- CONFIRM PASSWORD -->
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">
                    Confirm Password
                </label>
                <input
                    type="password"
                    name="confirm_password"
                    required
                    class="w-full border border-gray-300 dark:border-gray-700
                           bg-gray-50 dark:bg-gray-700
                           text-gray-900 dark:text-white
                           rounded-lg px-3 py-2
                           focus:ring-2 focus:ring-[#0097D7] outline-none"
                >
            </div>

            <!-- SUBMIT -->
            <button
                class="w-full py-3 rounded-lg font-semibold text-white
                       bg-[#0097D7] hover:bg-[#0083BD] transition">
                Create Account
            </button>

        </form>

        <div class="text-center mt-4 text-sm">
            <span class="text-gray-600 dark:text-gray-300">
                Already have an account?
            </span>
            <a href="login.php" class="text-[#0097D7] ml-1 hover:underline">
                Sign In
            </a>
        </div>

    </div>

</main>

<?php include "footer.php"; ?>

</body>
</html>
