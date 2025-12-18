<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Reset Successful - KavPlus Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: "class" }</script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="ml-60 pt-24 flex justify-center px-6">

    <div class="w-full max-w-xl bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-10 mb-16 text-center">

        <h1 class="text-3xl font-bold mb-4 text-green-600 dark:text-green-300">
            🎉 Password Reset Successful
        </h1>

        <p class="text-gray-700 dark:text-gray-300 mb-6">
            Your password has been updated.  
            You may now sign in using your new password.
        </p>

        <a href="login.php"
           class="px-6 py-3 bg-[#0097D7] hover:bg-[#0083BD] text-white rounded-lg font-semibold transition">
            Go to Login
        </a>

    </div>

</main>

<?php include "footer.php"; ?>

</body>
</html>
