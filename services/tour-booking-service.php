<?php
require_once __DIR__ . '/../db.php';

class TourBookingService {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = db();
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS tour_bookings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                email TEXT NOT NULL,
                confirmation TEXT UNIQUE NOT NULL,
                tour_name TEXT NOT NULL,
                city TEXT NOT NULL,
                tour_date TEXT NOT NULL,
                guests INTEGER NOT NULL,
                total_paid REAL NOT NULL,
                status TEXT NOT NULL DEFAULT 'PAID',
                created_at TEXT NOT NULL
            )
        ");
    }

    public function create(array $d): int {
        $c = 'KT-' . random_int(100000,999999);
        $stmt = $this->pdo->prepare("
            INSERT INTO tour_bookings
            (user_id,email,confirmation,tour_name,city,tour_date,guests,total_paid,status,created_at)
            VALUES (?,?,?,?,?,?,?,?,?,?)
        ");
        $stmt->execute([
            $d['user_id'],$d['email'],$c,$d['tour_name'],$d['city'],
            $d['tour_date'],$d['guests'],$d['price'],'PAID',date('Y-m-d H:i:s')
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getByUser(int $uid): array {
        $s=$this->pdo->prepare("SELECT *, 'TOUR' AS booking_type FROM tour_bookings WHERE user_id=?");
        $s->execute([$uid]);
        return $s->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
