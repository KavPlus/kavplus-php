<?php

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tours – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { darkMode: 'class' }
</script>
</head>

<body class="bg-gray-100 dark:bg-gray-900
             text-gray-900 dark:text-gray-100
             pt-16 md:pt-20 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="pb-16">

<div class="px-6 md:px-8 max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="flex items-end justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Popular Tours</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
              Trip.com style • Kav+ themed tours
            </p>
        </div>

        <a href="hotels.php"
           class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-full
                  bg-white dark:bg-gray-800
                  border border-gray-200 dark:border-gray-700
                  text-sm hover:shadow">
            🏨 Explore Hotels
        </a>
    </div>

<?php
$tours = [
    ['name'=>'London City Highlights','city'=>'London','price'=>120,'image'=>'./banners/london.jpg'],
    ['name'=>'Dubai Desert Safari','city'=>'Dubai','price'=>180,'image'=>'./banners/dubai.jpg'],
    ['name'=>'Paris Eiffel & Louvre Experience','city'=>'Paris','price'=>165,'image'=>'./banners/paris.jpg'],
    ['name'=>'Singapore Gardens & Marina Bay','city'=>'Singapore','price'=>140,'image'=>'./banners/singapore.jpg'],
    ['name'=>'Tokyo Street Food & Night Walk','city'=>'Tokyo','price'=>155,'image'=>'./banners/home.jpg'],
    ['name'=>'Rome Colosseum & Vatican Guided Tour','city'=>'Rome','price'=>170,'image'=>'./banners/rome.jpg'],
];
?>

    <!-- TOUR GRID -->
    <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6">
        <?php foreach ($tours as $t): ?>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow
                    hover:shadow-lg transition overflow-hidden">

            <img src="<?= htmlspecialchars($t['image']) ?>"
                 onerror="this.src='./banners/home.jpg'"
                 class="h-44 w-full object-cover">

            <div class="p-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-lg leading-snug">
                            <?= htmlspecialchars($t['name']) ?>
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            📍 <?= htmlspecialchars($t['city']) ?>
                        </p>
                    </div>

                    <span class="shrink-0 text-xs font-semibold px-2 py-1 rounded-full
                                 bg-[#0097D7]/10 text-[#0097D7]">
                        KAV+ Deal
                    </span>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-400">From</p>
                        <p class="font-bold text-[#0097D7] text-xl">
                            £<?= number_format((float)$t['price'], 2) ?>
                        </p>
                    </div>

                    <a href="tour-details.php?name=<?= urlencode($t['name']) ?>&city=<?= urlencode($t['city']) ?>&price=<?= urlencode((string)$t['price']) ?>"
                       class="px-4 py-2 bg-[#0097D7] text-white rounded-full
                              hover:bg-[#007fb8] transition">
                        View
                    </a>
                </div>

                <div class="mt-3 text-xs text-gray-400">
                    Free cancellation on selected tours • Instant confirmation
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>

</main>

<?php include "footer.php"; ?>
</body>
</html>
