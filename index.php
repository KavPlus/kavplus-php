<!DOCTYPE html> 
<html>
<head>
    <meta charset="UTF-8">
    <title>KavPlus Travel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- UI Enhancements CSS -->
    <link rel="stylesheet" href="styles.css">

    <script>
        tailwind.config = { darkMode: "class" }
    </script>

    <style>
        /* HERO BANNER */
        .hero-bg {
            background: url("./banners/home.jpg") center/cover no-repeat;
            height: 430px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }
        .hero-overlay {
            background: linear-gradient(to bottom,
                    rgba(0,0,0,0.35),
                    rgba(0,0,0,0.55));
        }

        /* DATE INPUT COLOR FIX */
        input[type="date"] {
            color: transparent;
        }
        input[type="date"]::-webkit-datetime-edit,
        input[type="date"]::-webkit-datetime-edit-fields-wrapper,
        input[type="date"]::-webkit-datetime-edit-text,
        input[type="date"]::-webkit-datetime-edit-month-field,
        input[type="date"]::-webkit-datetime-edit-day-field,
        input[type="date"]::-webkit-datetime-edit-year-field {
            color: rgb(156 163 175);
        }
        input[type="date"]:valid::-webkit-datetime-edit {
            color: rgb(17 24 39);
        }
        .dark input[type="date"]::-webkit-datetime-edit,
        .dark input[type="date"]::-webkit-datetime-edit-fields-wrapper,
        .dark input[type="date"]::-webkit-datetime-edit-text,
        .dark input[type="date"]::-webkit-datetime-edit-month-field,
        .dark input[type="date"]::-webkit-datetime-edit-day-field,
        .dark input[type="date"]::-webkit-datetime-edit-year-field {
            color: rgb(156 163 175);
        }
        .dark input[type="date"]:valid::-webkit-datetime-edit {
            color: rgb(249 250 251);
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="ml-60 pt-24 page-fade">

    <!-- HERO -->
    <section class="relative w-full hero-bg shadow overflow-hidden">
        <div class="hero-overlay absolute inset-0"></div>
    </section>


    <!-- SEARCH BOX (overlaps banner: ~30% on banner, ~70% on page) -->
    <section class="relative z-10 flex justify-center px-4 -mt-16 md:-mt-24 mb-10">
        <div class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-3xl shadow-2xl
                    border border-gray-200 dark:border-gray-700 p-8">

            <!-- TABS -->
            <div class="flex justify-between md:justify-start md:space-x-10
                        border-b border-gray-300 dark:border-gray-700 pb-4 mb-6">

                <!-- Kav+ Nights -->
                <button onclick="setTab(0)" id="tab0"
                        class="tabBtn flex flex-col items-center group">
                    <!-- Bed icon (clear “nights” icon) -->
                    <svg width="28" height="28" viewBox="0 0 24 24"
                         fill="none" stroke="#0097D7" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round"
                         class="mb-1 group-hover:scale-110 transition">
                        <rect x="3" y="11" width="18" height="6" rx="1"></rect>
                        <path d="M7 11V9a2 2 0 0 1 2-2h3v4"></path>
                        <path d="M3 17v3M21 17v3"></path>
                    </svg>
                    <span class="font-semibold text-gray-700 dark:text-gray-200">
                        Kav+ Nights
                    </span>
                </button>

                <!-- Flights -->
                <button onclick="setTab(1)" id="tab1"
                        class="tabBtn flex flex-col items-center group">
                    <!-- Plane icon -->
                    <svg width="28" height="28" viewBox="0 0 24 24"
                         fill="none" stroke="#0097D7" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round"
                         class="mb-1 group-hover:scale-110 transition">
                        <path d="M2 16l10 3 10-3-10-4z"></path>
                        <path d="M12 3v9"></path>
                    </svg>
                    <span class="font-semibold text-gray-700 dark:text-gray-200">
                        Flights
                    </span>
                </button>

                <!-- Tours -->
                <button onclick="setTab(2)" id="tab2"
                        class="tabBtn flex flex-col items-center group">
                    <!-- Map pin / tours icon -->
                    <svg width="28" height="28" viewBox="0 0 24 24"
                         fill="none" stroke="#0097D7" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round"
                         class="mb-1 group-hover:scale-110 transition">
                        <path d="M14 4a5 5 0 0 0-5 5c0 3.5 5 9 5 9s5-5.5 5-9a5 5 0 0 0-5-5z"></path>
                        <circle cx="14" cy="9" r="1.7"></circle>
                        <path d="M6 7h2M4 10h3"></path>
                    </svg>
                    <span class="font-semibold text-gray-700 dark:text-gray-200">
                        Tours
                    </span>
                </button>

                <!-- Flight + Nights -->
                <button onclick="setTab(3)" id="tab3"
                        class="tabBtn flex flex-col items-center group">
                    <!-- Bed + small plane icon -->
                    <svg width="28" height="28" viewBox="0 0 24 24"
                         fill="none" stroke="#0097D7" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round"
                         class="mb-1 group-hover:scale-110 transition">
                        <!-- bed -->
                        <rect x="3" y="12" width="18" height="6" rx="1"></rect>
                        <path d="M7 12V10a2 2 0 0 1 2-2h3v4"></path>
                        <!-- tiny plane on top -->
                        <path d="M5 7l5 1.5 5-1.5-5-2z"></path>
                        <path d="M10 3v3"></path>
                    </svg>
                    <span class="font-semibold text-gray-700 dark:text-gray-200">
                        Flight + Nights
                    </span>
                </button>
            </div>

            <!-- TAB CONTENTS -->

            <!-- Kav+ Nights -->
            <div id="tabContent0" class="tabContent">
                <form action="hotels.php" method="GET"
                      class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <input name="location"
                           placeholder="City, hotel, home, or area"
                           class="px-4 py-3 bg-gray-100 dark:bg-gray-700
                                  text-gray-900 dark:text-white rounded-xl">
                    <input type="date" name="checkin"
                           class="px-4 py-3 bg-gray-100 dark:bg-gray-700 rounded-xl">
                    <button
                        class="bg-[#0097D7] hover:bg-[#0083BD] text-white
                               px-6 py-3 rounded-xl shadow-lg">
                        Search Nights
                    </button>
                </form>
            </div>

            <!-- Flights -->
            <div id="tabContent1" class="tabContent hidden">
                <form action="flights.php" method="GET"
                      class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <input name="from" placeholder="From"
                           class="px-4 py-3 bg-gray-100 dark:bg-gray-700 rounded-xl">
                    <input name="to" placeholder="To"
                           class="px-4 py-3 bg-gray-100 dark:bg-gray-700 rounded-xl">
                    <button
                        class="bg-[#0097D7] hover:bg-[#0083BD] text-white
                               px-6 py-3 rounded-xl shadow-lg">
                        Search Flights
                    </button>
                </form>
            </div>

            <!-- Tours -->
            <div id="tabContent2" class="tabContent hidden">
                <form action="tours.php" method="GET"
                      class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <input name="place" placeholder="Tour location"
                           class="px-4 py-3 bg-gray-100 dark:bg-gray-700 rounded-xl">
                    <input type="date" name="date"
                           class="px-4 py-3 bg-gray-100 dark:bg-gray-700 rounded-xl">
                    <button
                        class="bg-[#0097D7] hover:bg-[#0083BD] text-white
                               px-6 py-3 rounded-xl shadow-lg">
                        Find Tours
                    </button>
                </form>
            </div>

            <!-- Flight + Nights -->
            <div id="tabContent3" class="tabContent hidden">
                <form action="packages.php" method="GET"
                      class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <input name="destination" placeholder="Destination"
                           class="px-4 py-3 bg-gray-100 dark:bg-gray-700 rounded-xl">
                    <input type="date" name="start"
                           class="px-4 py-3 bg-gray-100 dark:bg-gray-700 rounded-xl">
                    <button
                        class="bg-[#0097D7] hover:bg-[#0083BD] text-white
                               px-6 py-3 rounded-xl shadow-lg">
                        Search Packages
                    </button>
                </form>
            </div>
        </div>
    </section>


    <!-- DEALS -->
    <section class="p-6">
        <h2 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">
            🔥 Deals & Offers
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow card-hover transition">
                <img src="./banners/deals.jpg"
                     class="rounded-lg h-40 w-full object-cover">
                <p class="font-semibold mt-2 text-gray-800 dark:text-gray-200">
                    Holiday Package – Save 20%
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow card-hover transition">
                <img src="./banners/flights.jpg"
                     class="rounded-lg h-40 w-full object-cover">
                <p class="font-semibold mt-2 text-gray-800 dark:text-gray-200">
                    Flight Flash Sale – Limited Time
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow card-hover transition">
                <img src="./banners/hotels.jpg"
                     class="rounded-lg h-40 w-full object-cover">
                <p class="font-semibold mt-2 text-gray-800 dark:text-gray-200">
                    Hotel Deals – Up to 40% OFF
                </p>
            </div>

        </div>
    </section>

    <!-- TRENDING -->
    <section class="p-6">
        <h2 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">
            🌍 Trending Destinations
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow card-hover transition">
                <img src="./banners/dubai.jpg"
                     class="rounded-lg h-32 w-full object-cover">
                <p class="font-semibold mt-2 text-gray-800 dark:text-gray-200">Dubai</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow card-hover transition">
                <img src="./banners/singapore.jpg"
                     class="rounded-lg h-32 w-full object-cover">
                <p class="font-semibold mt-2 text-gray-800 dark:text-gray-200">Singapore</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow card-hover transition">
                <img src="./banners/london.jpg"
                     class="rounded-lg h-32 w-full object-cover">
                <p class="font-semibold mt-2 text-gray-800 dark:text-gray-200">London</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow card-hover transition">
                <img src="./banners/paris.jpg"
                     class="rounded-lg h-32 w-full object-cover">
                <p class="font-semibold mt-2 text-gray-800 dark:text-gray-200">Paris</p>
            </div>

        </div>
    </section>

    <?php include "footer.php"; ?>

</main>

<script src="include.js"></script>

<script>
function setTab(index) {
    document.querySelectorAll(".tabContent").forEach((el, i) => {
        el.classList.toggle("hidden", i !== index);
    });

    document.querySelectorAll(".tabBtn").forEach((btn, i) => {
        btn.classList.toggle(
            "text-[#0097D7] border-b-2 border-[#0097D7]",
            i === index
        );
    });
}
setTab(0);
</script>

</body>
</html>
