<?php
require "db.php";

$USE_REAL_EMAILS = false; // change to true for live SMTP
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {

        $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", time() + 3600);

        $stmt2 = $conn->prepare("UPDATE users SET reset_token = ?, token_expire = ? WHERE id = ?");
        $stmt2->bind_param("ssi", $token, $expiry, $user["id"]);
        $stmt2->execute();

        $resetLink = "http://localhost/kavplus/reset-password-confirm.php?token=" . $token;

        if ($USE_REAL_EMAILS) {
            // email sending code here when live
            $message = "A reset link has been emailed to you.";
        } else {
            // debug mode
            $message = "DEBUG: Reset Link → <a href='$resetLink' class='text-[#0097D7] underline'>$resetLink</a>";
        }

    } else {
        $message = "No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - KavPlus Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: "class" }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="ml-60 pt-24 flex justify-center px-6">
    
    <div class="w-full max-w-xl bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-10 mb-16">

        <h1 class="text-3xl font-bold text-center mb-6 text-[#2D516C] dark:text-white">Reset Password</h1>

        <?php if (!empty($message)): ?>
            <div class="mb-4 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 p-4 rounded-lg">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Email Address</label>
                <input type="email" name="email" required
                       class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 
                              text-gray-900 dark:text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#0097D7]">
            </div>

            <button class="w-full bg-[#0097D7] hover:bg-[#0083BD] text-white py-3 rounded-lg font-semibold transition">
                Send Reset Link
            </button>

        </form>

        <div class="text-center mt-4">
            <a href="login.php" class="text-[#0097D7] hover:underline">Back to Login</a>
        </div>

    </div>

</main>

<?php include "footer.php"; ?>

</body>
</html>
