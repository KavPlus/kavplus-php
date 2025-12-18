<?php
require_once '../includes/db.php';
session_start();
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$searchCount   = $pdo->query("SELECT COUNT(*) AS c FROM flight_search_logs")->fetch()['c'];
$bookingsCount = $pdo->query("SELECT COUNT(*) AS c FROM flight_bookings")->fetch()['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - KAV+ Travel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-body">
<header class="admin-header">
    <h1>KAV+ Travel Admin</h1>
    <a href="logout.php">Logout</a>
</header>

<main class="admin-main">
    <section class="admin-cards">
        <div class="admin-card">
            <h3>Total Flight Searches</h3>
            <p><?php echo (int)$searchCount; ?></p>
        </div>
        <div class="admin-card">
            <h3>Total Bookings</h3>
            <p><?php echo (int)$bookingsCount; ?></p>
        </div>
    </section>

    <section>
        <h2>Recent Bookings</h2>
        <?php
        $stmt = $pdo->query("SELECT * FROM flight_bookings ORDER BY created_at DESC LIMIT 20");
        $bookings = $stmt->fetchAll();
        ?>
        <table class="admin-table">
            <tr>
                <th>Ref</th>
                <th>Name</th>
                <th>Email</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
            <?php foreach ($bookings as $b): ?>
                <tr>
                    <td><?php echo htmlspecialchars($b['booking_ref']); ?></td>
                    <td><?php echo htmlspecialchars($b['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($b['user_email']); ?></td>
                    <td>$<?php echo number_format($b['total_price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($b['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>
</body>
</html>
