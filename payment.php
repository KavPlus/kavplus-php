<?php
session_start();
include "auth.php";

/* SAFETY: booking data must exist */
$booking = $_SESSION['pending_booking'] ?? [
  'route' => 'London → Dubai',
  'flight' => 'Emirates · EK004',
  'time' => '08:30 → 18:00 (Nonstop)',
  'passenger' => 'John Doe',
  'email' => 'johndoe@gmail.com',
  'base' => 390,
  'taxes' => 30,
];

$total = (float)$booking['base'] + (float)$booking['taxes'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Dark mode before paint -->
<script>
(function(){
  try{
    if(localStorage.getItem('theme')==='dark'){
      document.documentElement.classList.add('dark');
    }
  }catch(e){}
})();
</script>

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode:'class' }
</script>

<link rel="stylesheet" href="styles.css">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="md:ml-60 pt-24 pb-20 px-4">

<form method="POST" action="payment-process.php"
      class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

<!-- ================= LEFT ================= -->
<section class="md:col-span-2 space-y-6">

<!-- PAGE TITLE -->
<div class="bg-white dark:bg-gray-800 shadow p-6 rounded-xl">
  <h2 class="text-3xl font-bold">Secure Payment</h2>
  <p class="text-gray-600 dark:text-gray-400">
    Complete your booking with a secure checkout.
  </p>
</div>

<!-- TRIP SUMMARY -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
  <h3 class="font-bold text-lg mb-3">Your Trip</h3>

  <div class="flex justify-between">
    <div>
      <p class="font-semibold text-lg"><?= htmlspecialchars($booking['route']) ?></p>
      <p class="text-sm text-gray-500"><?= htmlspecialchars($booking['flight']) ?></p>
      <p class="text-sm text-gray-500"><?= htmlspecialchars($booking['time']) ?></p>
    </div>
    <p class="text-2xl font-bold text-[#0097D7]">£<?= number_format($total,2) ?></p>
  </div>
</div>

<!-- PASSENGER -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
  <h3 class="font-bold text-lg mb-4">Passenger</h3>

  <p class="font-semibold"><?= htmlspecialchars($booking['passenger']) ?></p>
  <p class="text-gray-600 dark:text-gray-400 text-sm">
    Email: <?= htmlspecialchars($booking['email']) ?>
  </p>
</div>

<!-- PAYMENT METHOD -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
  <h3 class="font-bold text-lg mb-4">Payment Method</h3>

  <label class="flex items-center gap-2 mb-4">
    <input type="radio" name="payment_method" value="CARD" checked>
    <span>Credit / Debit Card</span>
  </label>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
      <label class="text-sm font-semibold">Card Number</label>
      <input required name="card_number"
             class="w-full border rounded-lg p-3"
             placeholder="xxxx xxxx xxxx xxxx">
    </div>

    <div>
      <label class="text-sm font-semibold">Expiry</label>
      <input required name="expiry"
             class="w-full border rounded-lg p-3"
             placeholder="MM/YY">
    </div>

    <div>
      <label class="text-sm font-semibold">CVV</label>
      <input required name="cvv" type="password"
             class="w-full border rounded-lg p-3"
             placeholder="123">
    </div>

    <div class="md:col-span-2">
      <label class="text-sm font-semibold">Cardholder Name</label>
      <input required name="card_name"
             class="w-full border rounded-lg p-3">
    </div>
  </div>
</div>

<!-- BILLING -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
  <h3 class="font-bold text-lg mb-4">Billing Address</h3>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <input name="address" required class="border rounded-lg p-3" placeholder="Address">
    <input name="city" required class="border rounded-lg p-3" placeholder="City">
    <input name="state" class="border rounded-lg p-3" placeholder="State">
    <input name="postcode" required class="border rounded-lg p-3" placeholder="Postal Code">

    <select name="country" class="border rounded-lg p-3 md:col-span-2">
      <option>United Kingdom</option>
      <option>United States</option>
      <option>India</option>
      <option>UAE</option>
    </select>
  </div>
</div>

</section>

<!-- ================= RIGHT ================= -->
<aside class="bg-white dark:bg-gray-800 shadow rounded-xl p-5 h-fit">

<h3 class="font-bold text-lg mb-3">Price Summary</h3>

<div class="flex justify-between text-gray-700 dark:text-gray-300">
  <span>Base Fare</span>
  <span>£<?= number_format($booking['base'],2) ?></span>
</div>

<div class="flex justify-between text-gray-700 dark:text-gray-300">
  <span>Taxes & Fees</span>
  <span>£<?= number_format($booking['taxes'],2) ?></span>
</div>

<hr class="my-3">

<div class="flex justify-between font-bold text-xl text-[#0097D7]">
  <span>Total</span>
  <span>£<?= number_format($total,2) ?></span>
</div>

<input type="hidden" name="total" value="<?= $total ?>">

<button type="submit"
        class="w-full bg-[#0097D7] hover:bg-[#007fb8]
               text-white py-3 mt-4 rounded-lg text-lg font-semibold">
  Pay Now
</button>

<p class="text-sm text-gray-400 mt-3 text-center">
  🔒 Secure Encrypted Payment
</p>

</aside>

</form>

<?php include "footer.php"; ?>
</main>
</body>
</html>
