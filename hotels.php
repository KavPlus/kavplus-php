<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Hotels – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { darkMode: 'class' }
</script>

<style>
:root{
  --kav:#0097D7;
  --kav2:#007fb8;
}
.card-hover{transition:.25s}
.card-hover:hover{
  transform:translateY(-3px);
  box-shadow:0 18px 45px rgba(0,0,0,.15)
}
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300
             text-gray-900 dark:text-gray-100
             pt-16 md:pt-20 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="pb-20">

<!-- HERO -->
<section class="relative h-[420px]">
  <img src="banners/hotels.jpg"
       class="absolute inset-0 w-full h-full object-cover"
       onerror="this.src='banners/home.jpg'">
  <div class="absolute inset-0 bg-gradient-to-b from-black/30 to-black/70"></div>

  <div class="relative z-10 max-w-7xl mx-auto px-6 h-full flex items-end pb-16">
    <div>
      <h1 class="text-4xl md:text-5xl font-extrabold text-white">
        Discover Your Perfect Stay
      </h1>
      <p class="text-white/90 mt-2 text-lg">
        Hand-picked hotels · Exclusive Kav+ deals · Best prices
      </p>
    </div>
  </div>
</section>

<!-- SEARCH BAR -->
<div class="-mt-20 relative z-20 max-w-7xl mx-auto px-6">
  <form method="GET"
        class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-6
               grid grid-cols-1 md:grid-cols-5 gap-4 card-hover">

    <div>
      <label class="text-xs text-gray-500">Destination</label>
      <input name="destination"
             value="<?= htmlspecialchars($_GET['destination'] ?? '') ?>"
             placeholder="City or hotel"
             class="w-full rounded-xl bg-gray-100 dark:bg-gray-700 p-3 outline-none">
    </div>

    <div>
      <label class="text-xs text-gray-500">Check-in</label>
      <input type="date" name="checkin"
             value="<?= htmlspecialchars($_GET['checkin'] ?? '') ?>"
             class="w-full rounded-xl bg-gray-100 dark:bg-gray-700 p-3 outline-none">
    </div>

    <div>
      <label class="text-xs text-gray-500">Check-out</label>
      <input type="date" name="checkout"
             value="<?= htmlspecialchars($_GET['checkout'] ?? '') ?>"
             class="w-full rounded-xl bg-gray-100 dark:bg-gray-700 p-3 outline-none">
    </div>

    <div>
      <label class="text-xs text-gray-500">Guests</label>
      <select name="guests"
              class="w-full rounded-xl bg-gray-100 dark:bg-gray-700 p-3">
        <?php foreach(['1 Guest','2 Guests','3 Guests','4 Guests','5+ Guests'] as $g): ?>
          <option <?= ($_GET['guests'] ?? '') === $g ? 'selected':'' ?>>
            <?= $g ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="flex items-end">
      <button class="w-full bg-[#0097D7] hover:bg-[#007fb8]
                     text-white font-bold py-3 rounded-xl">
        Search Hotels
      </button>
    </div>

  </form>
</div>

<!-- CONTENT -->
<div class="max-w-7xl mx-auto px-6 mt-12 flex gap-8">

<!-- FILTERS -->
<aside class="hidden lg:block w-72 bg-white dark:bg-gray-800 rounded-2xl shadow p-6 space-y-6">

  <h3 class="text-lg font-bold text-gray-900 dark:text-white">Filters</h3>

  <div>
    <p class="font-medium mb-2">Price Range</p>
    <input type="range" min="50" max="1000" class="w-full">
    <p class="text-sm text-gray-500 mt-1">£50 – £1000</p>
  </div>

  <div>
    <p class="font-medium mb-2">Star Rating</p>
    <label class="block"><input type="checkbox"> ★★★★★</label>
    <label class="block"><input type="checkbox"> ★★★★☆</label>
    <label class="block"><input type="checkbox"> ★★★☆☆</label>
  </div>

  <div>
    <p class="font-medium mb-2">Amenities</p>
    <label class="block"><input type="checkbox"> Free WiFi</label>
    <label class="block"><input type="checkbox"> Pool</label>
    <label class="block"><input type="checkbox"> Gym</label>
    <label class="block"><input type="checkbox"> Breakfast</label>
  </div>

</aside>

<!-- RESULTS -->
<section class="flex-1">

<!-- SORT -->
<div class="flex gap-3 mb-6">
  <button class="px-4 py-2 rounded-full bg-[#0097D7] text-white">Recommended</button>
  <button class="px-4 py-2 rounded-full bg-gray-200 dark:bg-gray-700">Price</button>
  <button class="px-4 py-2 rounded-full bg-gray-200 dark:bg-gray-700">Rating</button>
</div>

<?php
$hotels = [
  [
    "name"=>"Grand Palace Hotel",
    "location"=>"Central London · 0.5 km from center",
    "rating"=>"8.9 Excellent",
    "reviews"=>"3,200 reviews",
    "price"=>"210",
    "image"=>"images/hotel1.jpg"
  ],
  [
    "name"=>"Skyline Luxury Suites",
    "location"=>"Dubai Marina · Near JBR",
    "rating"=>"9.2 Superb",
    "reviews"=>"1,850 reviews",
    "price"=>"340",
    "image"=>"images/hotel2.jpg"
  ]
];
?>

<?php foreach($hotels as $h): ?>
<div class="bg-white dark:bg-gray-800 rounded-3xl shadow p-6 mb-6
            flex flex-col md:flex-row gap-6 card-hover">

  <img src="<?= $h['image'] ?>"
       onerror="this.src='banners/hotels.jpg'"
       class="w-full md:w-56 h-40 object-cover rounded-2xl">

  <div class="flex-1">
    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
      <?= htmlspecialchars($h['name']) ?>
    </h3>
    <p class="text-gray-500 mt-1"><?= htmlspecialchars($h['location']) ?></p>

    <div class="flex items-center gap-2 mt-2">
      <span class="bg-green-500 text-white text-sm px-2 py-1 rounded-lg">
        <?= $h['rating'] ?>
      </span>
      <span class="text-sm text-gray-500"><?= $h['reviews'] ?></span>
    </div>

    <ul class="flex gap-4 text-sm text-gray-500 mt-3">
      <li>Free WiFi</li>
      <li>Breakfast</li>
      <li>Pool</li>
    </ul>
  </div>

  <div class="text-right flex flex-col justify-between">
    <p class="text-3xl font-extrabold text-[#0097D7]">
      £<?= $h['price'] ?>
    </p>
    <p class="text-sm text-gray-500">per night</p>

    <a href="hotel-details.php"
       class="mt-4 bg-[#0097D7] hover:bg-[#007fb8]
              text-white font-bold px-6 py-3 rounded-xl text-center">
      View Details
    </a>
  </div>

</div>
<?php endforeach; ?>

</section>
</div>

<?php include "footer.php"; ?>

</main>
</body>
</html>
