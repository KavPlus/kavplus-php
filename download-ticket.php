<?php
session_start();
$b = $_SESSION['final_booking'] ?? null;
if(!$b) exit("Invalid");

header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=e-ticket.txt");

echo "KAV+ E-TICKET\n";
echo "PNR: {$b['pnr']}\n";
echo "Ticket: {$b['ticket']}\n";
echo "Passenger: {$b['passenger']['given_names']} {$b['passenger']['last_name']}\n";
echo "Flight: {$b['search']['from']} → {$b['search']['to']}\n";
echo "Seat(s): ".implode(", ", array_column($b['seats'],'code'))."\n";
echo "Amount Paid: {$b['currency']}{$b['amount']}\n";
