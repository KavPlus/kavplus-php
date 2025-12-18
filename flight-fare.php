<?php
session_start();

/* Fare selection */
$fare = $_GET['fare'] ?? 'standard';

$fareData = [
  'basic' => ['name'=>'Basic','price'=>765],
  'standard' => ['name'=>'Standard','price'=>927],
  'flex' => ['name'=>'Flex','price'=>1333],
];

$selectedFare = $fareData[$fare];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Passenger details – Kav+</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode:'class' }
</script>

<style>
.kav-bg{ background:#0097D7 }
.kav-bg:hover{ background:#0083BD }
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100
             pt-16 md:pt-20 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<form action="flight-payment.php" method="POST"
      class="max-w-7xl mx-auto px-6 py-6
             grid grid-cols-1 lg:grid-cols-12 gap-6">

<!-- LEFT -->
<section class="lg:col-span-8 space-y-6">

<!-- FARE INFO -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
  <h2 class="text-lg font-semibold">Selected fare</h2>
  <p class="mt-2 text-sm text-gray-500">
    <?= $selectedFare['name'] ?> · <?= ucfirst($fare) ?>
  </p>
</div>

<!-- PASSENGER DETAILS -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
  <h2 class="text-lg font-semibold mb-4">Passenger details</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <input required name="first_name" placeholder="First name"
           class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">
    <input required name="last_name" placeholder="Last name"
           class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">

    <input required type="date" name="dob"
           class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">

    <select required name="gender"
            class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">
      <option value="">Gender</option>
      <option>Male</option>
      <option>Female</option>
    </select>
  </div>
</div>

<!-- BAGGAGE -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
  <h2 class="text-lg font-semibold mb-4">Add baggage</h2>

  <label class="flex justify-between items-center mb-3">
    <span>+ 20kg checked baggage</span>
    <span>
      <input type="radio" name="baggage" value="0" checked> Free
    </span>
  </label>

  <label class="flex justify-between items-center">
    <span>+ 30kg checked baggage</span>
    <span>
      <input type="radio" name="baggage" value="50"> £50
    </span>
  </label>
</div>

<!-- SEAT SELECTION -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
  <h2 class="text-lg font-semibold mb-2">Seat selection</h2>
  <p class="text-sm text-gray-500 mb-3">
    Choose your seat after passenger details
  </p>

  <a href="seat-selection.php"
     class="inline-block px-4 py-2 rounded-xl
            bg-gray-200 dark:bg-gray-700">
    Choose seats
  </a>
</div>

</section>

<!-- RIGHT SUMMARY -->
<aside class="lg:col-span-4">
  <div class="sticky top-28 bg-white dark:bg-gray-800 rounded-2xl shadow p-6">

    <h3 class="font-semibold mb-4">Price summary</h3>

    <div class="flex justify-between text-sm mb-2">
      <span>Flight (1 adult)</span>
      <span>£<?= $selectedFare['price'] ?></span>
    </div>

    <div class="flex justify-between text-sm mb-2">
      <span>Baggage</span>
      <span id="bagPrice">£0</span>
    </div>

    <div class="border-t border-gray-200 dark:border-gray-700 my-3"></div>

    <div class="flex justify-between font-semibold text-lg">
      <span>Total</span>
      <span id="totalPrice">£<?= $selectedFare['price'] ?></span>
    </div>

    <input type="hidden" name="fare" value="<?= $fare ?>">
    <input type="hidden" name="base_price" value="<?= $selectedFare['price'] ?>">

    <button type="submit"
            class="w-full kav-bg text-white py-3 rounded-xl font-semibold">
      Continue to seat selection
    </button>

  </div>
</aside>

</form>

<?php include "footer.php"; ?>

<script>
const baggageRadios = document.querySelectorAll('[name="baggage"]');
const bagPriceEl = document.getElementById('bagPrice');
const totalEl = document.getElementById('totalPrice');
const base = <?= $selectedFare['price'] ?>;

baggageRadios.forEach(r=>{
  r.addEventListener('change', ()=>{
    const bag = parseInt(r.value);
    bagPriceEl.textContent = '£' + bag;
    totalEl.textContent = '£' + (base + bag);
  });
});
</script>

</body>
</html>
