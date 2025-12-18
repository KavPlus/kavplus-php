<?php
session_start();
require_once __DIR__ . '/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter email and password';
    } else {

        $pdo = db();
        $stmt = $pdo->prepare("
            SELECT id, name, email, password, role
            FROM users
            WHERE email = ?
            LIMIT 1
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            $error = 'Invalid credentials';
        }
        elseif ($user['role'] !== 'admin') {
            $error = 'Access denied';
        }
        else {
            // ✅ ADMIN SESSION
            $_SESSION['admin'] = [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'role'  => 'admin'
            ];

            header("Location: admin/admin-bookings.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login – KavPlus</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white w-full max-w-md p-8 rounded-2xl shadow">

    <h1 class="text-2xl font-bold mb-2 text-center">Admin Login</h1>
    <p class="text-sm text-gray-500 text-center mb-6">
        KavPlus Administration Panel
    </p>

    <?php if ($error): ?>
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">

        <div>
            <label class="text-sm font-semibold">Email</label>
            <input type="email" name="email" required
                   class="w-full border rounded-xl p-3 mt-1">
        </div>

        <div>
            <label class="text-sm font-semibold">Password</label>
            <input type="password" name="password" required
                   class="w-full border rounded-xl p-3 mt-1">
        </div>

        <button type="submit"
                class="w-full bg-[#0097D7] text-white py-3 rounded-xl font-semibold hover:bg-[#007fb8]">
            Login as Admin
        </button>

    </form>

</div>

</body>
</html>
