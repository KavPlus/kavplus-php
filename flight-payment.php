<?php
session_start();

/* ==========================
   READ SESSION DATA
========================== */
$fare       = $_SESSION['fare'] ?? ($_POST['fare'] ?? 'standard');
$basePrice  = (float)($_SESSION['base_price'] ?? ($_POST['base_price'] ?? 927));
$seats      = $_SESSION['seat_assignments'] ?? [];
$baggage    = (float)($_POST['baggage'] ?? 0);

/* Seat total */
$seatTotal = 0;
foreach ($seats as $s) {
  if (is_array($s)) {
    $seatTotal += (float)$s['price'];
  }
}

$total = $basePrice + $seatTotal + $baggage;

/* Save for confirmation */
$_SESSION['final_total'] = $total;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment – Kav+</title>
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

<form action="flight-booking.php" method="POST"
      class="max-w-7xl mx-auto px-6 py-6
             grid grid-cols-1 lg:grid-cols-12 gap-6">

<!-- LEFT -->
<section class="lg:col-span-8 space-y-6">

<!-- PAYMENT METHOD -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
  <h2 class="text-lg font-semibold mb-4">Payment method</h2>

  <div class="space-y-4">
    <label class="flex items-center gap-3">
      <input type="radio" name="payment" checked>
      <span>Credit / Debit Card</span>
    </label>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <input required placeholder="Card number"
             class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">
      <input required placeholder="Name on card"
             class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">

      <input required placeholder="MM / YY"
             class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">
      <input required placeholder="CVV"
             class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">
    </div>
  </div>
</div>

<!-- PROMO CODE -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
  <h2 class="text-lg font-semibold mb-3">Promo code</h2>
  <div class="flex gap-3">
    <input placeholder="Enter code"
           class="flex-1 bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">
    <button type="button"
            class="px-4 py-2 rounded-xl bg-gray-200 dark:bg-gray-700">
      Apply
    </button>
  </div>
</div>

<!-- TERMS -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
  <label class="flex gap-3 text-sm">
    <input type="checkbox" required>
    <span>
      I confirm passenger details are correct and agree to the
      <a href="#" class="text-[#0097D7]">terms &amp; conditions</a>
    </span>
  </label>
</div>

</section>

<!-- RIGHT SUMMARY -->
<aside class="lg:col-span-4">
  <div class="sticky top-28 bg-white dark:bg-gray-800 rounded-2xl shadow p-6">

    <h3 class="font-semibold mb-4">Price summary</h3>

    <div class="flex justify-between text-sm mb-2">
      <span>Flight fare</span>
      <span>£<?= number_format($basePrice,2) ?></span>
    </div>

    <div class="flex justify-between text-sm mb-2">
      <span>Seats</span>
      <span>£<?= number_format($seatTotal,2) ?></span>
    </div>

    <div class="flex justify-between text-sm mb-2">
      <span>Baggage</span>
      <span>£<?= number_format($baggage,2) ?></span>
    </div>

    <div class="border-t border-gray-200 dark:border-gray-700 my-3"></div>

    <div class="flex justify-between font-semibold text-lg">
      <span>Total</span>
      <span>£<?= number_format($total,2) ?></span>
    </div>

    <input type="hidden" name="total" value="<?= $total ?>">

    <button type="submit"
            class="mt-4 w-full kav-bg text-white py-3 rounded-xl font-semibold">
      Pay £<?= number_format($total,2) ?>
    </button>

  </div>
</aside>

</form>

<?php include "footer.php"; ?>

</body>
</html>
