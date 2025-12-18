<?php
require "db.php";

$token = $_GET["token"] ?? "";

$stmt = $conn->prepare("SELECT id, token_expire FROM users WHERE reset_token = ? LIMIT 1");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || strtotime($user["token_expire"]) < time()) {
    die("Invalid or expired password reset link.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Password - KavPlus Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: "class" }</script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="ml-60 pt-24 flex justify-center px-6">

    <div class="w-full max-w-xl bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-10 mb-16">

        <h1 class="text-3xl font-bold text-center mb-6 text-[#2D516C] dark:text-white">
            Create New Password
        </h1>

        <form method="POST" action="reset-password-save.php" class="space-y-5">

            <input type="hidden" name="token" value="<?= htmlspecialchars($token); ?>">

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">New Password</label>
                <input type="password" name="password" required
                       class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 
                                  text-gray-900 dark:text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#0097D7]">
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Confirm Password</label>
                <input type="password" name="confirm_password" required
                       class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 
                                  text-gray-900 dark:text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#0097D7]">
            </div>

            <button class="w-full bg-[#0097D7] hover:bg-[#0083BD] text-white py-3 rounded-lg font-semibold transition">
                Save New Password
            </button>

        </form>

    </div>

</main>

<?php include "footer.php"; ?>

</body>
</html>
