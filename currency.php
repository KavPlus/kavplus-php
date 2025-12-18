<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

/* =========================
   SUPPORTED CURRENCIES
========================= */
$CURRENCIES = [
  'GBP' => ['symbol'=>'£', 'rate'=>1],
  'USD' => ['symbol'=>'$', 'rate'=>1.27],
  'EUR' => ['symbol'=>'€', 'rate'=>1.17],
  'INR' => ['symbol'=>'₹', 'rate'=>105.4],
];

/* =========================
   CURRENT CURRENCY
========================= */
$currency = $_SESSION['currency'] ?? 'GBP';

if (!isset($CURRENCIES[$currency])) {
  $currency = 'GBP';
}

/* =========================
   HELPERS
========================= */
function price($amount){
  global $CURRENCIES, $currency;
  $converted = $amount * $CURRENCIES[$currency]['rate'];
  return $CURRENCIES[$currency]['symbol'] . number_format($converted, 2);
}

function currency(){
  global $currency;
  return $currency;
}
