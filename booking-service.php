<?php
// booking-service.php
require_once __DIR__ . '/db.php';

/* ===============================
   ID / CODE GENERATORS
================================ */

function generateConfirmation(): string {
    return 'KP-' . str_pad((string)random_int(1000000, 9999999), 7, '0', STR_PAD_LEFT);
}

function generatePNR(): string {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $pnr = '';
    for ($i = 0; $i < 6; $i++) {
        $pnr .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $pnr;
}

/* ===============================
   CREATE BOOKING
================================ */

function createBooking(array $flight, array $booking, string $provider = 'TEST'): array {

    $confirmation = generateConfirmation();
    $pnr = generatePNR();

    $baseFare = (float)($flight['price'] ?? 0);
    $taxes = 50.0;
    $total = $baseFare + $taxes;

    /* ✅ IMPORTANT FIX */
    if (!empty($_SESSION['user']['email'])) {
        // Logged-in user → link booking to account
        $email = $_SESSION['user']['email'];
    } else {
        // Guest booking fallback
        $email = trim($booking['contact_email'] ?? '');
    }

    $phone = trim($booking['contact_phone'] ?? '');
    $passengers = $booking['passengers'] ?? [];
    $seat = $flight['seat'] ?? null;

    $pdo = db();
    $stmt = $pdo->prepare("
        INSERT INTO bookings
        (confirmation, pnr, email, phone, flight_json, passengers_json, seat,
         base_fare, taxes, total_paid, payment_provider, status, created_at)
        VALUES
        (:c, :pnr, :e, :p, :fj, :pj, :s, :bf, :t, :tp, :prov, 'PAID', :at)
    ");

    $stmt->execute([
        ':c'    => $confirmation,
        ':pnr'  => $pnr,
        ':e'    => $email,
        ':p'    => $phone,
        ':fj'   => json_encode($flight, JSON_UNESCAPED_SLASHES),
        ':pj'   => json_encode($passengers, JSON_UNESCAPED_SLASHES),
        ':s'    => $seat,
        ':bf'   => $baseFare,
        ':t'    => $taxes,
        ':tp'   => $total,
        ':prov' => $provider,
        ':at'   => date('Y-m-d H:i:s'),
    ]);

    return [
        'confirmation' => $confirmation,
        'pnr' => $pnr,
        'email' => $email,
        'total_paid' => $total,
        'created_at' => date('Y-m-d H:i:s'),
        'flight' => $flight,
        'passengers' => $passengers
    ];
}
/* ===============================
   FETCH BOOKINGS (BASIC)
================================ */

function getBookingsByEmail(string $email): array {
    $pdo = db();
    $stmt = $pdo->prepare("
        SELECT * FROM bookings
        WHERE email = :e
        ORDER BY id DESC
    ");
    $stmt->execute([':e' => $email]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllBookings(): array {
    return db()
        ->query("SELECT * FROM bookings ORDER BY id DESC")
        ->fetchAll(PDO::FETCH_ASSOC);
}

function getBookingByConfirmation(string $confirmation): ?array {
    $pdo = db();
    $stmt = $pdo->prepare("
        SELECT * FROM bookings
        WHERE confirmation = :c
        LIMIT 1
    ");
    $stmt->execute([':c' => $confirmation]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}

/* ===============================
   PAGINATION (NEW)
================================ */

function getBookingsByEmailPaged(string $email, int $limit, int $offset): array {
    $pdo = db();
    $stmt = $pdo->prepare("
        SELECT * FROM bookings
        WHERE email = :e
        ORDER BY id DESC
        LIMIT :l OFFSET :o
    ");
    $stmt->bindValue(':e', $email);
    $stmt->bindValue(':l', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':o', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countBookingsByEmail(string $email): int {
    $pdo = db();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE email = ?");
    $stmt->execute([$email]);
    return (int)$stmt->fetchColumn();
}

function getAllBookingsPaged(int $limit, int $offset): array {
    $pdo = db();
    $stmt = $pdo->prepare("
        SELECT * FROM bookings
        ORDER BY id DESC
        LIMIT :l OFFSET :o
    ");
    $stmt->bindValue(':l', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':o', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countAllBookings(): int {
    return (int)db()->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
}

/* ===============================
   CANCEL / STATUS UPDATE
================================ */

function cancelBooking(string $confirmation, string $email, bool $isAdmin = false): bool {
    $pdo = db();

    if ($isAdmin) {
        $stmt = $pdo->prepare("
            UPDATE bookings
            SET status = 'CANCELLED'
            WHERE confirmation = ?
        ");
        return $stmt->execute([$confirmation]);
    }

    $stmt = $pdo->prepare("
        UPDATE bookings
        SET status = 'CANCELLED'
        WHERE confirmation = ?
          AND email = ?
          AND status = 'PAID'
    ");
    return $stmt->execute([$confirmation, $email]);
}
