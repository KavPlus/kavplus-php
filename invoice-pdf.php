<?php
require_once __DIR__ . '/booking-service.php';
require_once __DIR__ . '/config.php';

$c = $_GET['c'] ?? '';
$bk = $c ? getBookingByConfirmation($c) : null;
if (!$bk) { http_response_code(404); exit('Not found'); }

header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=invoice-$c.pdf");

echo "%PDF-1.4\n1 0 obj<<>>endobj\ntrailer<<>>\n%%EOF";
