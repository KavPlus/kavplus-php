<?php
include "auth.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$name = $_SESSION["name"] ?? "Guest";
$firstLetter = strtoupper(substr($name, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - KavPlus Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: "class"
        }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<!-- MAIN CONTENT -->
<main class="ml-60 pt-24 px-8 pb-16">

    <!-- WELCOME CARD -->
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-10 flex items-center gap-8 mb-10">

        <!-- Avatar -->
        <div class="w-24 h-24 bg-[#0097D7] text-white text-4xl font-bold rounded-full flex items-center justify-center shadow-xl">
            <?= $firstLetter ?>
        </div>

        <!-- Greeting -->
        <div>
            <h1 class="text-4xl font-bold text-[#2D516C] dark:text-white leading-tight">
                Welcome back, <?= htmlspecialchars($name); ?> 👋
            </h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2 text-lg">
                Manage your bookings, rewards, and personal settings from here.
            </p>
        </div>

    </div>

    <!-- ACTION GRID -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- Profile -->
        <a href="profile.php"
           class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 text-center border border-gray-200 dark:border-gray-700
                  hover:scale-[1.02] transition-transform">
            <div class="text-5xl mb-3">👤</div>
            <h2 class="text-xl font-bold text-[#2D516C] dark:text-white">Profile</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2 text-sm">
                Update your account details
            </p>
        </a>

        <!-- Bookings -->
        <a href="my-bookings.php"
           class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 text-center border border-gray-200 dark:border-gray-700
                  hover:scale-[1.02] transition-transform">
            <div class="text-5xl mb-3">🧳</div>
            <h2 class="text-xl font-bold text-[#2D516C] dark:text-white">My Bookings</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2 text-sm">
                View and manage your past & upcoming trips
            </p>
        </a>

        <!-- Rewards -->
        <a href="rewards.php"
           class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 text-center border border-gray-200 dark:border-gray-700
                  hover:scale-[1.02] transition-transform">
            <div class="text-5xl mb-3">🏆</div>
            <h2 class="text-xl font-bold text-[#2D516C] dark:text-white">Rewards</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2 text-sm">
                Track your loyalty points & perks
            </p>
        </a>

    </div>

    <!-- REWARDS PROGRESS CARD -->
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 mt-12 max-w-4xl">

        <h2 class="text-2xl font-bold text-[#2D516C] dark:text-white mb-4">
            Your Rewards Progress
        </h2>

        <p class="text-gray-600 dark:text-gray-300 mb-3">
            You’re making great progress! Keep booking to unlock new tiers & benefits.
        </p>

        <div class="w-full bg-gray-200 dark:bg-gray-700 h-4 rounded-full overflow-hidden">
            <div class="bg-[#0097D7] h-4" style="width: 40%;"></div>
        </div>

        <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
            400 / 1000 points
        </p>

    </div>

    <!-- RECENT BOOKINGS -->
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 mt-12 max-w-4xl">
        
        <h2 class="text-2xl font-bold text-[#2D516C] dark:text-white mb-4">
            Recent Bookings
        </h2>

        <div class="space-y-4">

            <!-- Booking Card -->
            <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                <div>
                    <p class="font-semibold text-[#2D516C] dark:text-white">London → Dubai</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Emirates · Oct 03, 2025</p>
                </div>
                <a href="booking-details.php" class="text-[#0097D7] hover:underline">View</a>
            </div>

            <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                <div>
                    <p class="font-semibold text-[#2D516C] dark:text-white">Sydney → Melbourne</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Qantas · Nov 12, 2025</p>
                </div>
                <a href="booking-details.php" class="text-[#0097D7] hover:underline">View</a>
            </div>

        </div>

    </div>

</main>

<?php include "footer.php"; ?>

</body>
</html>
