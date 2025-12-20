<?php
/* =========================
   SUPPORTED CURRENCIES
========================= */

$CURRENCIES = [
  'GBP' => ['symbol' => '£', 'rate' => 1],
  'USD' => ['symbol' => '$', 'rate' => 1.27],
  'EUR' => ['symbol' => '€', 'rate' => 1.17],
  'INR' => ['symbol' => '₹', 'rate' => 105.4],
];

/* =========================
   CURRENT CURRENCY
========================= */

// session MUST already be started by header.php
$currency = $_SESSION['currency'] ?? 'GBP';

if (!isset($CURRENCIES[$currency])) {
  $currency = 'GBP';
}

/* =========================
   HELPERS
========================= */

function price(float $amount): string {
  global $CURRENCIES, $currency;
  $converted = $amount * $CURRENCIES[$currency]['rate'];
  return $CURRENCIES[$currency]['symbol'] . number_format($converted, 2);
}

function currency(): string {
  global $currency;
  return $currency;
}
