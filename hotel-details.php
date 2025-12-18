<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Hotel Details – KavPlus Travel</title>
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
.kav-input{
  width:100%;
  border-radius:14px;
  padding:.85rem 1rem;
  border:1px solid rgba(148,163,184,.45);
  outline:none;
  background:#fff;
}
.dark .kav-input{
  background:#111827;
  border-color:#334155;
  color:#e5e7eb;
}
.kav-input:focus{
  border-color: var(--kav);
  box-shadow: 0 0 0 3px rgba(0,151,215,.18);
}
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300
             text-gray-900 dark:text-gray-100
             pt-16 md:pt-20 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="pb-20">

<?php
/* You can replace these with DB values later */
$hotelName = "Grand Palace Hotel";
$city      = "London";
$pricePerNight = 210; // base nightly price
?>

<!-- IMAGE GALLERY -->
<section class="max-w-7xl mx-auto px-6">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-3 rounded-3xl overflow-hidden">
    <img src="images/hotel1.jpg" onerror="this.src='banners/hotels.jpg'"
         class="md:col-span-2 h-[380px] w-full object-cover">
    <div class="grid grid-rows-2 gap-3">
      <img src="images/hotel2.jpg" onerror="this.src='banners/hotels.jpg'"
           class="h-[185px] w-full object-cover">
      <img src="images/hotel3.jpg" onerror="this.src='banners/hotels.jpg'"
           class="h-[185px] w-full object-cover">
    </div>
  </div>
</section>

<!-- CONTENT -->
<section class="max-w-7xl mx-auto px-6 mt-8 flex flex-col lg:flex-row gap-10">

<!-- LEFT -->
<div class="flex-1 space-y-6">

  <!-- TITLE -->
  <div>
    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white">
      <?= htmlspecialchars($hotelName) ?>
    </h1>
    <p class="text-gray-500 mt-1">
      Central <?= htmlspecialchars($city) ?> · 0.5 km from city center · ★★★★★
    </p>

    <div class="flex items-center gap-3 mt-3">
      <span class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm font-semibold">
        8.9 Excellent
      </span>
      <span class="text-sm text-gray-500">3,200 verified reviews</span>
    </div>
  </div>

  <!-- HIGHLIGHTS -->
  <div class="grid md:grid-cols-3 gap-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5 card-hover">
      <h3 class="font-semibold mb-2 text-gray-900 dark:text-white">Facilities</h3>
      <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
        <li>✔ Free WiFi</li>
        <li>✔ Swimming Pool</li>
        <li>✔ Spa & Wellness</li>
        <li>✔ Airport Shuttle</li>
      </ul>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5 card-hover">
      <h3 class="font-semibold mb-2 text-gray-900 dark:text-white">Perfect For</h3>
      <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
        <li>✔ Couples</li>
        <li>✔ Families</li>
        <li>✔ Business Trips</li>
        <li>✔ City Breaks</li>
      </ul>
    </div>

    <div class="bg-gradient-to-br from-[#0097D7] to-[#007fb8]
                text-white rounded-2xl shadow p-5 card-hover">
      <h3 class="font-semibold mb-2">Kav+ Benefits</h3>
      <ul class="text-sm space-y-1">
        <li>★ Extra 5% Discount</li>
        <li>★ Late Checkout</li>
        <li>★ Priority Support</li>
      </ul>
    </div>
  </div>

  <!-- ABOUT -->
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 card-hover">
    <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">
      About this property
    </h3>
    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
      Grand Palace Hotel blends luxury with comfort in the heart of London.
      Enjoy panoramic city views, premium dining, and world-class spa facilities.
      Perfect for both leisure and business travelers.
    </p>
  </div>

  <!-- ROOMS -->
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 card-hover">
    <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">
      Room Highlights
    </h3>
    <ul class="grid md:grid-cols-2 gap-3 text-sm text-gray-600 dark:text-gray-300">
      <li>✔ Air-conditioned rooms</li>
      <li>✔ City / Pool view</li>
      <li>✔ King & Twin beds</li>
      <li>✔ Free cancellation</li>
    </ul>
  </div>

</div>

<!-- RIGHT (BOOKING) -->
<aside class="w-full lg:w-96">
  <div class="sticky top-28 bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 card-hover">

    <p class="text-sm text-gray-500">Price per night from</p>
    <p class="text-4xl font-extrabold text-[#0097D7]">
      £<?= number_format($pricePerNight, 2) ?>
    </p>

    <form method="POST" action="hotel-booking.php"
          class="mt-5 space-y-4" oninput="updateHotelTotal()">

      <input type="hidden" name="hotel_name" value="<?= htmlspecialchars($hotelName) ?>">
      <input type="hidden" name="city" value="<?= htmlspecialchars($city) ?>">

      <div>
        <label class="text-sm text-gray-600 dark:text-gray-300">Check-in</label>
        <input type="date" name="checkin" id="checkin" required class="kav-input mt-1">
      </div>

      <div>
        <label class="text-sm text-gray-600 dark:text-gray-300">Check-out</label>
        <input type="date" name="checkout" id="checkout" required class="kav-input mt-1">
      </div>

      <div class="grid grid-cols-3 gap-3">
        <div>
          <label class="text-sm text-gray-600 dark:text-gray-300">Rooms</label>
          <select name="rooms" id="rooms" class="kav-input mt-1">
            <option value="1" selected>1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        </div>
        <div>
          <label class="text-sm text-gray-600 dark:text-gray-300">Adults</label>
          <select name="adults" id="adults" class="kav-input mt-1">
            <option value="1">1</option>
            <option value="2" selected>2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </div>
        <div>
          <label class="text-sm text-gray-600 dark:text-gray-300">Children</label>
          <select name="children" id="children" class="kav-input mt-1">
            <option value="0" selected>0</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </div>
      </div>

      <div class="mt-2 space-y-2 text-sm text-gray-600 dark:text-gray-300">
        <div class="flex justify-between">
          <span>Nights</span>
          <span id="nightsText">0</span>
        </div>
        <div class="flex justify-between">
          <span>Rooms</span>
          <span id="roomsText">1</span>
        </div>
        <div class="flex justify-between font-semibold">
          <span>Total</span>
          <span class="text-[#0097D7]">
            £<span id="totalText"><?= number_format($pricePerNight,2) ?></span>
          </span>
        </div>
      </div>

      <input type="hidden" name="guests" id="guestsInput" value="2">
      <input type="hidden" name="price" id="priceInput" value="<?= (float)$pricePerNight ?>">

      <button type="submit"
              class="mt-4 w-full bg-[#0097D7] hover:bg-[#007fb8]
                     text-white font-bold py-4 rounded-xl text-lg">
        Book This Hotel
      </button>

      <p class="text-xs text-gray-400 mt-3 text-center">
        Free cancellation up to 24 hours before check-in
      </p>

    </form>

  </div>
</aside>

</section>

<?php include "footer.php"; ?>
</main>

<script>
const pricePerNight = <?= json_encode((float)$pricePerNight) ?>;

function daysBetween(d1, d2){
  const a = new Date(d1);
  const b = new Date(d2);
  const ms = b - a;
  if (isNaN(ms)) return 0;
  const nights = Math.ceil(ms / (1000*60*60*24));
  return nights > 0 ? nights : 0;
}

function updateHotelTotal(){
  const checkin  = document.getElementById('checkin').value;
  const checkout = document.getElementById('checkout').value;
  const rooms    = parseInt(document.getElementById('rooms').value || '1', 10);
  const adults   = parseInt(document.getElementById('adults').value || '1', 10);
  const children = parseInt(document.getElementById('children').value || '0', 10);

  const guests = adults + children;
  document.getElementById('guestsInput').value = guests;

  const nights = daysBetween(checkin, checkout);
  const total = (nights > 0 ? nights : 1) * rooms * pricePerNight;

  document.getElementById('nightsText').innerText = nights;
  document.getElementById('roomsText').innerText = rooms;
  document.getElementById('totalText').innerText = total.toFixed(2);
  document.getElementById('priceInput').value = total.toFixed(2);
}

(function initDefaults(){
  const ci = document.getElementById('checkin');
  const co = document.getElementById('checkout');
  if(!ci.value){
    const today = new Date();
    const inDate = new Date(today.getFullYear(), today.getMonth(), today.getDate()+7);
    const outDate = new Date(today.getFullYear(), today.getMonth(), today.getDate()+10);
    ci.value = inDate.toISOString().slice(0,10);
    co.value = outDate.toISOString().slice(0,10);
  }
  updateHotelTotal();
})();
</script>

</body>
</html>
