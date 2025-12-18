<?php
session_start();

/* =========================
   GUARDS
========================= */
$search   = $_SESSION['flight_search'] ?? null;
$selected = $_SESSION['selected_flight'] ?? null;
$booking  = $_SESSION['booking_info'] ?? null;
$seats    = $_SESSION['seat_assignments'] ?? [];

if (!$search || !$selected || !$booking) {
    header("Location: flights.php");
    exit;
}

/* =========================
   PREVENT DOUBLE SUBMIT
========================= */
if (!empty($_SESSION['payment_status']) && $_SESSION['payment_status'] === 'paid') {
    header("Location: booking-success.php");
    exit;
}

/* =========================
   TOTAL CALCULATION
========================= */
$baseTicket = (float)($selected['price'] ?? 0);
$taxes      = 50.00; // static for now

$seatTotal = 0;
if (!empty($seats) && is_array($seats)) {
    foreach ($seats as $s) {
        if (is_array($s) && isset($s['price'])) {
            $seatTotal += (float)$s['price'];
        }
    }
}

$grandTotal = round($baseTicket + $taxes + $seatTotal, 2);

/* =========================
   HANDLE PAYMENT (MOCK)
   Replace with Stripe / Razorpay later
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /*
      TODO:
      - Stripe payment intent verification
      - Razorpay signature verification
    */

    // ✅ Mark payment as completed
    $_SESSION['payment_status'] = 'paid';

    /* =========================
       GENERATE REFERENCES
    ========================= */
    $pnr        = strtoupper(substr(md5(uniqid('pnr', true)), 0, 6));
    $ticketNo   = 'KAV' . time();
    $bookingRef = 'KP-' . random_int(100000, 999999);

    /* =========================
       FINAL GLOBAL BOOKING OBJECT
       (Used by ALL confirmation pages)
    ========================= */
    $_SESSION['completed_booking'] = [
        'confirmation'     => $bookingRef,
        'pnr'              => $pnr,
        'ticket'           => $ticketNo,

        'flight'           => $selected,
        'search'           => $search,
        'passengers'       => $booking['passengers'] ?? [],
        'seat'             => $booking['seat'] ?? 'Not selected',
        'seats'            => $seats,

        'email'            => $booking['email'] ?? '',
        'phone'            => $booking['phone'] ?? '',

        'base_fare'        => $baseTicket,
        'taxes'            => $taxes,
        'seat_total'       => $seatTotal,
        'total_paid'       => $grandTotal,
        'currency'         => '£',
        'payment_provider' => $_POST['payment_method'] ?? 'CARD',

        'paid_at'          => date('Y-m-d H:i:s'),
    ];

    /* =========================
       OPTIONAL EMAIL
    ========================= */
    if (file_exists(__DIR__ . '/send-email.php')) {
        include __DIR__ . '/send-email.php';
    }

    /* =========================
       CLEANUP TEMP SESSION
    ========================= */
    unset(
        $_SESSION['seat_assignments'],
        $_SESSION['booking_info']
    );

    /* =========================
       REDIRECT SUCCESS
    ========================= */
    header("Location: booking-success.php");
    exit;
}

/* =========================
   SAFETY FALLBACK
========================= */
header("Location: payment.php");
exit;
