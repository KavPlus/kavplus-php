<?php
session_start();
// ----------------------------
// Tour Details – KavPlus Travel
// Supports multiple tours via GET params
// ----------------------------

$name  = trim($_GET['name'] ?? '');
$city  = trim($_GET['city'] ?? '');
$price = (float)($_GET['price'] ?? 0);

// Fallback if user opens directly without parameters
if ($name === '') {
    $name  = 'Dubai Desert Safari – Dune Bashing & BBQ Dinner';
    $city  = 'Dubai';
    $price = 55;
}

// Tour catalog (UI + content)
$tourCatalog = [
    'Dubai Desert Safari – Dune Bashing & BBQ Dinner' => [
        'locationFull' => 'Dubai · United Arab Emirates',
        'rating' => '4.8',
        'reviews' => '12,500 reviews',
        'hero' => 'https://images.unsplash.com/photo-1508264165352-258859e62245?auto=format&fit=crop&w=1600&q=60',
        'highlights' => [
            'Thrilling dune bashing experience in a 4x4 vehicle',
            'BBQ dinner with vegetarian and non-vegetarian options',
            'Live entertainment: Belly dance, Tanoura, Fire show',
            'Camel ride experience',
            'Photography stops in the desert',
        ],
        'included' => [
            ['ok' => true,  'text' => 'Pickup & drop-off from your hotel'],
            ['ok' => true,  'text' => 'Dune bashing in 4x4 Land Cruiser'],
            ['ok' => true,  'text' => 'BBQ buffet dinner'],
            ['ok' => true,  'text' => 'Unlimited refreshments'],
            ['ok' => true,  'text' => 'Camel ride'],
            ['ok' => false, 'text' => 'Quad bike (optional extra)'],
        ],
        'about' => "Enjoy an unforgettable desert experience with this evening safari adventure. After a hotel pickup, you'll embark on a thrilling dune-bashing ride through the golden sands of Dubai. Take photos at scenic desert spots, enjoy a camel ride, and indulge in a delicious BBQ dinner with live cultural performances. A perfect mix of adventure, culture, and relaxation.",
        'itinerary' => [
            ['time' => '3:00 PM', 'text' => 'Pickup from hotel in Dubai'],
            ['time' => '4:00 PM', 'text' => 'Dune bashing adventure'],
            ['time' => '5:00 PM', 'text' => 'Camel ride & photo stop'],
            ['time' => '6:00 PM', 'text' => 'BBQ dinner & refreshments'],
            ['time' => '7:00 PM', 'text' => 'Entertainment shows'],
            ['time' => '8:30 PM', 'text' => 'Return journey to your hotel'],
        ],
        'defaultPrice' => 55,
    ],

    'London City Highlights' => [
        'locationFull' => 'London · United Kingdom',
        'rating' => '4.7',
        'reviews' => '8,420 reviews',
        'hero' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1600&q=60',
        'highlights' => [
            'See Big Ben, Westminster Abbey & Buckingham Palace',
            'River Thames viewpoints & iconic photo stops',
            'Local guide with hidden stories and tips',
            'Perfect for first-time visitors',
            'Flexible meeting point options',
        ],
        'included' => [
            ['ok' => true,  'text' => 'Expert English-speaking guide'],
            ['ok' => true,  'text' => 'Walking tour with curated photo stops'],
            ['ok' => true,  'text' => 'City highlights route map'],
            ['ok' => false, 'text' => 'Attraction entry tickets (optional)'],
            ['ok' => false, 'text' => 'Hotel pickup (optional)'],
            ['ok' => false, 'text' => 'Food & drinks'],
        ],
        'about' => "Discover London’s must-see landmarks in one smooth, guided experience. Walk through historic streets, learn local stories, and capture iconic views along the Thames. Great for families, couples and solo travellers looking for a fun and efficient city overview.",
        'itinerary' => [
            ['time' => '10:00 AM', 'text' => 'Meet your guide at central London'],
            ['time' => '10:30 AM', 'text' => 'Westminster highlights & Big Ben views'],
            ['time' => '11:30 AM', 'text' => 'Buckingham Palace area & photo stop'],
            ['time' => '12:15 PM', 'text' => 'Trafalgar Square & local tips'],
            ['time' => '1:00 PM',  'text' => 'Tour ends near a transport hub'],
        ],
        'defaultPrice' => 120,
    ],

    'Paris Eiffel & Louvre Experience' => [
        'locationFull' => 'Paris · France',
        'rating' => '4.9',
        'reviews' => '15,130 reviews',
        'hero' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1600&q=60',
        'highlights' => [
            'Eiffel Tower photo-perfect viewpoints',
            'Louvre area walk with art-history context',
            'Seine riverside stroll & hidden Paris corners',
            'Best spots for cafes & local pastries',
            'Ideal half-day itinerary for first timers',
        ],
        'included' => [
            ['ok' => true,  'text' => 'Local guide & curated route'],
            ['ok' => true,  'text' => 'Eiffel + Louvre area highlights'],
            ['ok' => true,  'text' => 'Paris photo stops & tips'],
            ['ok' => false, 'text' => 'Museum entry tickets (optional)'],
            ['ok' => false, 'text' => 'Hotel pickup'],
            ['ok' => false, 'text' => 'Food & drinks'],
        ],
        'about' => "Experience Paris with the perfect blend of iconic landmarks and local atmosphere. From Eiffel Tower viewpoints to the Louvre district and the Seine, your guide will help you discover the best angles, the best stories, and the best small stops along the way.",
        'itinerary' => [
            ['time' => '9:30 AM', 'text' => 'Meet near Trocadéro for Eiffel views'],
            ['time' => '10:30 AM', 'text' => 'Seine stroll & charming bridges'],
            ['time' => '11:30 AM', 'text' => 'Louvre district walk & photo stop'],
            ['time' => '12:30 PM', 'text' => 'Tour ends with cafe recommendations'],
        ],
        'defaultPrice' => 165,
    ],

    'Singapore Gardens & Marina Bay' => [
        'locationFull' => 'Singapore · Singapore',
        'rating' => '4.8',
        'reviews' => '9,775 reviews',
        'hero' => 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?auto=format&fit=crop&w=1600&q=60',
        'highlights' => [
            'Gardens by the Bay & Supertree viewpoints',
            'Marina Bay skyline photo stops',
            'Local guide with transport & timing tips',
            'Great evening option for city lights',
            'Comfortable pace and family-friendly',
        ],
        'included' => [
            ['ok' => true,  'text' => 'Guided city highlights route'],
            ['ok' => true,  'text' => 'Best Marina Bay viewpoints'],
            ['ok' => true,  'text' => 'Photography tips & timing'],
            ['ok' => false, 'text' => 'Attraction entry tickets (optional)'],
            ['ok' => false, 'text' => 'Hotel pickup'],
            ['ok' => false, 'text' => 'Meals'],
        ],
        'about' => "See Singapore at its best—lush gardens, futuristic architecture, and the famous Marina Bay skyline. Your guide helps you hit the perfect spots at the perfect times, whether you’re chasing golden hour or the night lights.",
        'itinerary' => [
            ['time' => '4:30 PM', 'text' => 'Meet near Gardens by the Bay entrance'],
            ['time' => '5:30 PM', 'text' => 'Supertree viewpoints & skyline photos'],
            ['time' => '6:30 PM', 'text' => 'Marina Bay waterfront stroll'],
            ['time' => '7:15 PM', 'text' => 'Tour ends near transport & dining'],
        ],
        'defaultPrice' => 140,
    ],

    'Tokyo Street Food & Night Walk' => [
        'locationFull' => 'Tokyo · Japan',
        'rating' => '4.9',
        'reviews' => '6,540 reviews',
        'hero' => 'https://images.unsplash.com/photo-1549692520-acc6669e2f0c?auto=format&fit=crop&w=1600&q=60',
        'highlights' => [
            'Taste local favourites in lively neighbourhoods',
            'Night walk with neon streets & hidden alleys',
            'Cultural insights from a local guide',
            'Photo stops + best convenience-store hacks',
            'Perfect for solo travellers and couples',
        ],
        'included' => [
            ['ok' => true,  'text' => 'Local guide & curated route'],
            ['ok' => true,  'text' => 'Street food stop recommendations'],
            ['ok' => true,  'text' => 'Night photography tips'],
            ['ok' => false, 'text' => 'Food purchases (pay-as-you-go)'],
            ['ok' => false, 'text' => 'Transport tickets'],
            ['ok' => false, 'text' => 'Hotel pickup'],
        ],
        'about' => "Walk Tokyo after dark with a local guide and discover the city’s food culture and neon energy. Learn what to try, where locals actually go, and how to get the best experience without the tourist traps.",
        'itinerary' => [
            ['time' => '6:00 PM', 'text' => 'Meet at a central Tokyo station exit'],
            ['time' => '6:30 PM', 'text' => 'First street-food stops & alley walk'],
            ['time' => '7:45 PM', 'text' => 'Neon district highlights + photo stop'],
            ['time' => '9:00 PM', 'text' => 'Tour ends near dining & transport'],
        ],
        'defaultPrice' => 155,
    ],

    'Rome Colosseum & Vatican Guided Tour' => [
        'locationFull' => 'Rome · Italy',
        'rating' => '4.8',
        'reviews' => '11,210 reviews',
        'hero' => 'https://images.unsplash.com/photo-1529260830199-42c24126f198?auto=format&fit=crop&w=1600&q=60',
        'highlights' => [
            'Colosseum area history & best viewpoints',
            'Vatican surroundings + storytelling stops',
            'Ancient Rome highlights with a local guide',
            'Insider tips: gelato, cafes, and quick routes',
            'Ideal for day trips and first-timers',
        ],
        'included' => [
            ['ok' => true,  'text' => 'Local guide & curated historical route'],
            ['ok' => true,  'text' => 'Colosseum area highlights'],
            ['ok' => true,  'text' => 'Vatican surroundings walk'],
            ['ok' => false, 'text' => 'Entry tickets (optional)'],
            ['ok' => false, 'text' => 'Hotel pickup'],
            ['ok' => false, 'text' => 'Food & drinks'],
        ],
        'about' => "Explore the legends of Ancient Rome and the grandeur of the Vatican district with a local guide. You’ll get the best viewpoints, the best stories, and practical tips to make the rest of your Rome trip smoother and more fun.",
        'itinerary' => [
            ['time' => '10:00 AM', 'text' => 'Meet near the Colosseum area'],
            ['time' => '11:15 AM', 'text' => 'Historic route & photo viewpoints'],
            ['time' => '12:30 PM', 'text' => 'Transfer suggestions + Vatican district start'],
            ['time' => '2:00 PM',  'text' => 'Tour ends with local food recommendations'],
        ],
        'defaultPrice' => 170,
    ],
];

// Pick tour data by name; if unknown, use a simple fallback
$tour = $tourCatalog[$name] ?? [
    'locationFull' => ($city !== '' ? htmlspecialchars($city) : 'Tour'),
    'rating' => '4.7',
    'reviews' => '1,000+ reviews',
    'hero' => 'https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?auto=format&fit=crop&w=1600&q=60',
    'highlights' => [
        'Curated experience with a local guide',
        'Great photo spots and flexible pacing',
        'Ideal for first-time visitors',
        'Instant confirmation',
        'Selected free cancellation options',
    ],
    'included' => [
        ['ok' => true, 'text' => 'Local guide'],
        ['ok' => true, 'text' => 'Curated route'],
        ['ok' => false,'text' => 'Entry tickets (optional)'],
        ['ok' => false,'text' => 'Meals'],
    ],
    'about' => "Enjoy a curated tour experience with local insights, photo stops and flexible pacing.",
    'itinerary' => [
        ['time' => 'Start', 'text' => 'Meet your guide at the meeting point'],
        ['time' => 'Mid', 'text' => 'Guided highlights and photo stops'],
        ['time' => 'End', 'text' => 'Tour ends near transport & dining'],
    ],
    'defaultPrice' => max(0, $price),
];

// Price fallback
if ($price <= 0) $price = (float)($tour['defaultPrice'] ?? 0);

// KAV+ theme colors
$primary = '#0097D7';
$primaryHover = '#007fb8';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tour Details – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode: 'class' }
</script>

<!-- Apply theme early (matches sidebar.php: localStorage 'theme') -->
<script>
(function () {
  const t = localStorage.getItem('theme');
  if (t === 'dark') document.documentElement.classList.add('dark');
})();
</script>

<style>
:root{
  --kav-primary: <?= $primary ?>;
  --kav-primary-hover: <?= $primaryHover ?>;
}
.kav-btn{
  background: var(--kav-primary);
  color:#fff;
  border-radius:999px;
  padding:0.85rem 1.4rem;
  font-weight:700;
  transition:.2s;
}
.kav-btn:hover{ background: var(--kav-primary-hover); transform: translateY(-1px); }
.kav-pill{ background: rgba(0,151,215,.12); color: var(--kav-primary); }
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300
             text-gray-900 dark:text-gray-100
             pt-16 md:pt-20 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="pb-20">

  <!-- HERO -->
  <div class="max-w-6xl mx-auto px-6">
    <div class="relative overflow-hidden rounded-2xl shadow bg-white dark:bg-gray-800">
      <img src="<?= htmlspecialchars($tour['hero']) ?>"
           onerror="this.src='./banners/home.jpg'"
           class="w-full h-80 object-cover">
      <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-black/10 to-transparent"></div>

      <div class="absolute bottom-5 left-6 right-6 flex items-end justify-between gap-4">
        <div>
          <div class="inline-flex items-center gap-2 mb-2">
            <span class="kav-pill text-xs font-semibold px-3 py-1 rounded-full">KAV+ Deal</span>
            <span class="bg-white/15 text-white text-xs px-3 py-1 rounded-full backdrop-blur">
              Instant confirmation
            </span>
          </div>
          <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight">
            <?= htmlspecialchars($name) ?>
          </h1>
          <p class="text-white/90 mt-1">
            <?= htmlspecialchars($tour['locationFull']) ?>
          </p>
        </div>

        <div class="hidden md:flex flex-col items-end">
          <div class="flex items-center gap-2">
            <span class="bg-green-600 text-white px-3 py-1 rounded-lg text-sm font-semibold">
              <?= htmlspecialchars($tour['rating']) ?>
            </span>
            <span class="text-white/90 text-sm"><?= htmlspecialchars($tour['reviews']) ?></span>
          </div>
          <div class="mt-3 text-right">
            <div class="text-white/80 text-xs">Price per person</div>
            <div class="text-white text-3xl font-extrabold">£<?= number_format($price, 2) ?></div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- CONTENT GRID -->
  <div class="max-w-6xl mx-auto px-6 mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- LEFT -->
    <div class="lg:col-span-2 space-y-6">

      <!-- Rating card (mobile) -->
      <div class="md:hidden bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
        <div class="flex items-center gap-3">
          <span class="bg-green-600 text-white px-3 py-1 rounded-lg text-sm font-semibold">
            <?= htmlspecialchars($tour['rating']) ?>
          </span>
          <span class="text-sm text-gray-600 dark:text-gray-300"><?= htmlspecialchars($tour['reviews']) ?></span>
        </div>
        <div class="mt-3">
          <div class="text-xs text-gray-500">Price per person</div>
          <div class="text-3xl font-extrabold text-[#0097D7]">£<?= number_format($price,2) ?></div>
        </div>
      </div>

      <!-- Highlights -->
      <section class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Highlights</h2>
        <ul class="space-y-2 text-gray-700 dark:text-gray-200">
          <?php foreach (($tour['highlights'] ?? []) as $hl): ?>
            <li class="flex gap-2">
              <span class="mt-1">•</span>
              <span><?= htmlspecialchars($hl) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </section>

      <!-- What's included -->
      <section class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
        <h2 class="text-2xl font-bold mb-4">What’s Included</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-gray-700 dark:text-gray-200">
          <?php foreach (($tour['included'] ?? []) as $inc): ?>
            <div class="flex items-start gap-2">
              <span class="<?= !empty($inc['ok']) ? 'text-green-600' : 'text-red-500' ?>">
                <?= !empty($inc['ok']) ? '✔️' : '❌' ?>
              </span>
              <p><?= htmlspecialchars($inc['text'] ?? '') ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- About -->
      <section class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
        <h2 class="text-2xl font-bold mb-4">About This Tour</h2>
        <p class="text-gray-700 dark:text-gray-200 leading-relaxed">
          <?= htmlspecialchars($tour['about'] ?? '') ?>
        </p>
      </section>

      <!-- Itinerary -->
      <section class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Itinerary</h2>

        <div class="space-y-3">
          <?php foreach (($tour['itinerary'] ?? []) as $it): ?>
            <div class="flex gap-4">
              <div class="w-24 shrink-0 font-semibold text-gray-900 dark:text-gray-100">
                <?= htmlspecialchars($it['time'] ?? '') ?>
              </div>
              <div class="text-gray-700 dark:text-gray-200">
                <?= htmlspecialchars($it['text'] ?? '') ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

    </div>

    <!-- RIGHT (Booking box) -->
    <aside class="space-y-6">
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 sticky top-28">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs text-gray-500">Price per person</p>
            <p class="text-3xl font-extrabold text-[#0097D7]">£<?= number_format($price,2) ?></p>
          </div>
          <span class="kav-pill text-xs font-semibold px-3 py-1 rounded-full">
            Free cancellation*
          </span>
        </div>

        <p class="text-xs text-gray-500 mt-2">
          *On selected tours. Final policy shown at checkout.
        </p>

        <a href="tour-booking.php?name=<?= urlencode($name) ?>&city=<?= urlencode($city) ?>&price=<?= urlencode((string)$price) ?>"
           class="kav-btn block text-center mt-4">
          Book Now
        </a>

        <div class="mt-4 grid grid-cols-2 gap-3 text-xs text-gray-600 dark:text-gray-300">
          <div class="bg-gray-50 dark:bg-gray-900/30 rounded-xl p-3">
            <div class="font-semibold">Instant</div>
            <div class="text-gray-500">Confirmation</div>
          </div>
          <div class="bg-gray-50 dark:bg-gray-900/30 rounded-xl p-3">
            <div class="font-semibold">Secure</div>
            <div class="text-gray-500">Payments</div>
          </div>
        </div>
      </div>
    </aside>

  </div>

  <?php include "footer.php"; ?>

</main>

</body>
</html>
