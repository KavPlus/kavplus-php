<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/booking-service.php';

$flight  = $_SESSION['selected_flight'] ?? null;
$booking = $_SESSION['booking'] ?? null;

if(!$flight || !$booking){
  header("Location: flights.php");
  exit;
}

// provider passed from payment page
$provider = $_POST['provider'] ?? 'TEST';

// Create booking in DB
$done = createBooking($flight, $booking, $provider);

// Save for confirmation page
$_SESSION['completed_booking'] = $done;

// OPTIONAL: send email (enable on live server with SMTP)
$to = $done['email'];
if($to){
  $subject = "Booking Confirmed – {$done['confirmation']} ({$done['pnr']})";
  $msg = "Booking confirmed!\n\nConfirmation: {$done['confirmation']}\nPNR: {$done['pnr']}\n";
  // mail($to, $subject, $msg, "From: no-reply@kavplus.com");
}

// Clear temp checkout sessions
unset($_SESSION['selected_flight'], $_SESSION['booking'], $_SESSION['flight_search']);

header("Location: booking-confirmed.php");
exit;
