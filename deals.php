<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Deals – KavPlus Travel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      darkMode: 'class'
    }
  </script>

  <style>
    :root{
      --kav:#0097D7;
      --kav2:#007fb8;
    }

    .hero {
      background:
        linear-gradient(90deg, rgba(0,151,215,.9), rgba(0,127,184,.85)),
        url("banners/deals.jpg") center/cover no-repeat;
    }

    .card-hover{ transition:.25s; }
    .card-hover:hover{
      transform: translateY(-3px);
      box-shadow:0 20px 45px rgba(0,0,0,.18);
    }

    .btn-kav{
      background: var(--kav);
      color:#fff;
    }
    .btn-kav:hover{
      background: var(--kav2);
    }
  </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="pt-20 md:ml-60">

  <!-- HERO -->
  <section class="hero rounded-b-3xl shadow overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 py-12 text-white">
      <h1 class="text-4xl font-extrabold">🔥 Deals & Offers</h1>
      <p class="mt-2 text-white/90 max-w-2xl">
        Exclusive Kav+ discounts on flights, hotels, tours & bundles.
      </p>

      <div class="mt-5 flex flex-wrap gap-2">
        <span class="px-4 py-2 rounded-full bg-white/20 text-sm">All</span>
        <span class="px-4 py-2 rounded-full bg-white/10 text-sm">Flights</span>
        <span class="px-4 py-2 rounded-full bg-white/10 text-sm">Hotels</span>
        <span class="px-4 py-2 rounded-full bg-white/10 text-sm">Tours</span>
      </div>
    </div>
  </section>

  <!-- SEARCH -->
  <div class="max-w-7xl mx-auto px-6 -mt-8 relative z-10">
    <?php include "search-box.php"; ?>
  </div>

  <!-- DEALS GRID -->
  <section class="max-w-7xl mx-auto px-6 py-12">

    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
      Top Picks For You
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

      <!-- CARD -->
      <article class="bg-white dark:bg-gray-800 rounded-2xl shadow card-hover overflow-hidden">
        <img src="banners/flights.jpg"
             class="h-44 w-full object-cover">

        <div class="p-5">
          <span class="inline-block bg-blue-100 dark:bg-blue-900/40
                       text-[#0097D7] text-xs px-3 py-1 rounded-full mb-2">
            Flights · -15%
          </span>

          <h3 class="text-lg font-bold text-gray-900 dark:text-white">
            London → Dubai Flash Fare
          </h3>

          <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
            Limited-time flight discounts with flexible dates.
          </p>

          <div class="mt-4 flex justify-between items-end">
            <div>
              <p class="text-xs text-gray-500">From</p>
              <p class="text-2xl font-extrabold text-[#0097D7]">£349</p>
            </div>
            <a href="flights.php" class="btn-kav px-5 py-3 rounded-xl font-semibold text-sm">
              View Deal
            </a>
          </div>
        </div>
      </article>

      <!-- CARD -->
      <article class="bg-white dark:bg-gray-800 rounded-2xl shadow card-hover overflow-hidden">
        <img src="banners/hotels.jpg"
             class="h-44 w-full object-cover">

        <div class="p-5">
          <span class="inline-block bg-green-100 dark:bg-green-900/40
                       text-green-600 text-xs px-3 py-1 rounded-full mb-2">
            Hotels · Member
          </span>

          <h3 class="text-lg font-bold text-gray-900 dark:text-white">
            City Hotels Extra 5% Off
          </h3>

          <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
            Kav+ members save more on selected stays.
          </p>

          <div class="mt-4 flex justify-between items-end">
            <div>
              <p class="text-xs text-gray-500">From</p>
              <p class="text-2xl font-extrabold text-[#0097D7]">£79</p>
            </div>
            <a href="hotels.php" class="btn-kav px-5 py-3 rounded-xl font-semibold text-sm">
              Browse
            </a>
          </div>
        </div>
      </article>

      <!-- CARD -->
      <article class="bg-white dark:bg-gray-800 rounded-2xl shadow card-hover overflow-hidden">
        <img src="banners/tours.jpg"
             class="h-44 w-full object-cover">

        <div class="p-5">
          <span class="inline-block bg-purple-100 dark:bg-purple-900/40
                       text-purple-600 text-xs px-3 py-1 rounded-full mb-2">
            Tours · Bundle
          </span>

          <h3 class="text-lg font-bold text-gray-900 dark:text-white">
            Top Tours – Save on 2+
          </h3>

          <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
            Pick any 2 tours & get automatic discounts.
          </p>

          <div class="mt-4 flex justify-between items-end">
            <div>
              <p class="text-xs text-gray-500">From</p>
              <p class="text-2xl font-extrabold text-[#0097D7]">£39</p>
            </div>
            <a href="tours.php" class="btn-kav px-5 py-3 rounded-xl font-semibold text-sm">
              Explore
            </a>
          </div>
        </div>
      </article>

    </div>

    <!-- PROMO STRIP -->
    <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">

      <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow card-hover">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
          Flight + Hotel Bundles
        </h3>
        <p class="text-gray-600 dark:text-gray-300 mt-1">
          Save up to 25% when booking together.
        </p>
        <a href="packages.php"
           class="inline-block mt-4 btn-kav px-6 py-3 rounded-xl font-semibold text-sm">
          View Bundles
        </a>
      </div>

      <div class="bg-gradient-to-r from-[#0097D7] to-[#007fb8]
                  rounded-2xl p-6 shadow card-hover text-white">
        <h3 class="text-xl font-bold">Kav+ Rewards Week</h3>
        <p class="mt-1 text-white/90">
          Earn double points on eligible bookings.
        </p>
        <a href="rewards.php"
           class="inline-block mt-4 bg-white text-[#0097D7]
                  px-6 py-3 rounded-xl font-semibold text-sm">
          Learn More
        </a>
      </div>

    </div>

  </section>

  <?php include "footer.php"; ?>
</main>

<script src="include.js"></script>
</body>
</html>
