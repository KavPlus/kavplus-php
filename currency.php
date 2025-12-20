<?php
$CURRENCIES = [
  'GBP' => ['symbol' => '£', 'rate' => 1],
  'USD' => ['symbol' => '$', 'rate' => 1.27],
  'EUR' => ['symbol' => '€', 'rate' => 1.17],
  'INR' => ['symbol' => '₹', 'rate' => 105.4],
];

$currency = $_SESSION['currency'] ?? 'GBP';
if (!isset($CURRENCIES[$currency])) {
  $currency = 'GBP';
}

function price($amount) {
  global $CURRENCIES, $currency;
  $converted = $amount * $CURRENCIES[$currency]['rate'];
  return $CURRENCIES[$currency]['symbol'] . number_format($converted, 2);
}

function currency() {
  global $currency;
  return $currency;
}
