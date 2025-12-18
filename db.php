<?php
function db()
{
    static $pdo = null;

    if ($pdo === null) {

        $dataDir = __DIR__ . '/data';
        $dbFile  = $dataDir . '/kavplus.sqlite';

        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0777, true);
        }

        $pdo = new PDO('sqlite:' . $dbFile);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /* USERS */
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                role TEXT NOT NULL DEFAULT 'user',
                status TEXT NOT NULL DEFAULT 'ACTIVE',
                created_at TEXT NOT NULL
            )
        ");
    }

    return $pdo;
}
