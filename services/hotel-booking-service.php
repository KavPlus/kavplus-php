<?php
// services/hotel-booking-service.php

require_once __DIR__ . '/../db.php';

class HotelBookingService
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = db();
        $this->createTable();
    }

    private function createTable(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS hotel_bookings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                email TEXT NOT NULL,
                confirmation TEXT UNIQUE NOT NULL,
                hotel_name TEXT NOT NULL,
                city TEXT NOT NULL,
                checkin TEXT NOT NULL,
                checkout TEXT NOT NULL,
                guests INTEGER NOT NULL DEFAULT 1,
                rooms INTEGER NOT NULL DEFAULT 1,
                base_price REAL NOT NULL DEFAULT 0,
                taxes REAL NOT NULL DEFAULT 0,
                total_paid REAL NOT NULL DEFAULT 0,
                payment_provider TEXT,
                status TEXT NOT NULL DEFAULT 'PAID',
                created_at TEXT NOT NULL
            )
        ");
    }

    /* ===============================
       CREATE BOOKING
    =============================== */
    public function createHotelBooking(array $data): int
    {
        $confirmation = 'KH-' . random_int(1000000, 9999999);

        $base  = (float)($data['price'] ?? 0);
        $taxes = round($base * 0.06, 2);
        $total = $base + $taxes;

        $stmt = $this->pdo->prepare("
            INSERT INTO hotel_bookings (
                user_id,email,confirmation,hotel_name,city,
                checkin,checkout,guests,rooms,
                base_price,taxes,total_paid,
                payment_provider,status,created_at
            ) VALUES (
                :user_id,:email,:confirmation,:hotel_name,:city,
                :checkin,:checkout,:guests,:rooms,
                :base_price,:taxes,:total_paid,
                :payment_provider,'PAID',:created_at
            )
        ");

        $stmt->execute([
            ':user_id'          => (int)$data['user_id'],
            ':email'            => $data['email'],
            ':confirmation'     => $confirmation,
            ':hotel_name'       => $data['hotel_name'],
            ':city'             => $data['city'],
            ':checkin'          => $data['checkin'],
            ':checkout'         => $data['checkout'],
            ':guests'           => (int)$data['guests'],
            ':rooms'            => (int)$data['rooms'],
            ':base_price'       => $base,
            ':taxes'            => $taxes,
            ':total_paid'       => $total,
            ':payment_provider' => $data['payment_provider'] ?? 'CARD',
            ':created_at'       => date('Y-m-d H:i:s'),
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    /* ===============================
       GET BOOKING BY ID (FIX)
    =============================== */
    public function getBookingById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM hotel_bookings WHERE id = ?
        ");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }

    /* ===============================
       MY BOOKINGS
    =============================== */
    public function getUserHotelBookings(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT *, 'HOTEL' AS type
            FROM hotel_bookings
            WHERE user_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
