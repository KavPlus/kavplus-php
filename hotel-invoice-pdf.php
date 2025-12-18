<?php
require_once __DIR__ . '/services/hotel-booking-service.php';

$id = (int)($_GET['id'] ?? 0);
$s = new HotelBookingService();
$b = $s->getBookingById($id);

if (!$b) die("Invoice not found");

header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=hotel-invoice.pdf");

echo "
HOTEL INVOICE

Confirmation: {$b['confirmation']}
Hotel: {$b['hotel_name']}
City: {$b['city']}
Dates: {$b['checkin']} → {$b['checkout']}
Guests: {$b['guests']}

Base: £{$b['base_price']}
Taxes: £{$b['taxes']}
TOTAL: £{$b['total_paid']}

Status: {$b['status']}
";
