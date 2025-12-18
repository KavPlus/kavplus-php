<?php
// flight-data.php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

function h($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }

function money_gbp($n) {
  return "£" . number_format((float)$n, 0);
}

// Mock flight results dataset
function get_mock_flights() {
  return [
    [
      "id" => "EK-LHR-DXB-001",
      "airline" => "Emirates",
      "logo" => "plane",
      "from_city" => "London",
      "from_airport" => "LHR",
      "to_city" => "Dubai",
      "to_airport" => "DXB",
      "dep_time" => "09:45",
      "arr_time" => "20:10",
      "duration" => "6h 25m",
      "stops" => 0,
      "stop_label" => "Non-stop",
      "badge" => "Best choice",
      "price" => 549,
      "carbon" => "Avg CO₂",
      "baggage" => "Cabin 7kg • Checked 20kg",
      "aircraft" => "Boeing 777",
      "refundable" => true,
      "changeable" => true,
    ],
    [
      "id" => "QR-LHR-DXB-012",
      "airline" => "Qatar Airways",
      "logo" => "plane",
      "from_city" => "London",
      "from_airport" => "LHR",
      "to_city" => "Dubai",
      "to_airport" => "DXB",
      "dep_time" => "13:10",
      "arr_time" => "00:05",
      "duration" => "9h 55m",
      "stops" => 1,
      "stop_label" => "1 stop",
      "badge" => "Cheapest",
      "price" => 429,
      "carbon" => "Low CO₂",
      "baggage" => "Cabin 7kg • Checked 25kg",
      "aircraft" => "A350",
      "refundable" => false,
      "changeable" => true,
    ],
    [
      "id" => "BA-LHR-DXB-107",
      "airline" => "British Airways",
      "logo" => "plane",
      "from_city" => "London",
      "from_airport" => "LHR",
      "to_city" => "Dubai",
      "to_airport" => "DXB",
      "dep_time" => "21:00",
      "arr_time" => "07:45",
      "duration" => "6h 45m",
      "stops" => 0,
      "stop_label" => "Non-stop",
      "badge" => "Fastest",
      "price" => 515,
      "carbon" => "Avg CO₂",
      "baggage" => "Cabin 10kg • Checked 23kg",
      "aircraft" => "A380",
      "refundable" => false,
      "changeable" => false,
    ],
  ];
}

function find_flight_by_id($id) {
  foreach (get_mock_flights() as $f) {
    if ($f["id"] === $id) return $f;
  }
  return null;
}

// Persist booking in session
function booking_set($key, $val) { $_SESSION["flight_booking"][$key] = $val; }
function booking_get($key, $default=null) { return $_SESSION["flight_booking"][$key] ?? $default; }
function booking_all() { return $_SESSION["flight_booking"] ?? []; }
