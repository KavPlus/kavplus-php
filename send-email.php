<?php
$to = $_SESSION['final_booking']['contact']['email'];
$subject = "Your Kav+ E-Ticket | PNR ".$_SESSION['final_booking']['pnr'];

$b = $_SESSION['final_booking'];

$message = "
<h2>Kav+ Travel – Booking Confirmed</h2>
<p><strong>PNR:</strong> {$b['pnr']}</p>
<p><strong>E-Ticket:</strong> {$b['ticket']}</p>

<h3>Flight</h3>
<p>{$b['flight']['airline']} | {$b['search']['from']} → {$b['search']['to']}</p>

<h3>Passenger</h3>
<p>{$b['passenger']['given_names']} {$b['passenger']['last_name']}</p>

<h3>Seat</h3>
<p>".implode(", ", array_column($b['seats'],'code'))."</p>

<h3>Total Paid</h3>
<p>{$b['currency']}{$b['amount']}</p>

<p>Thank you for booking with Kav+</p>
";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type:text/html;charset=UTF-8\r\n";
$headers .= "From: KavPlus <no-reply@kavplus.com>\r\n";

@mail($to, $subject, $message, $headers);
