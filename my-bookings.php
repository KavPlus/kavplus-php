<?php
session_start();
require_once __DIR__ . '/db.php';

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$pdo = db();
$userId = $_SESSION['user']['id'];
$email  = $_SESSION['user']['email'];

/* ======================
   FLIGHT BOOKINGS
====================== */
$fStmt = $pdo->prepare("
    SELECT
        confirmation,
        pnr,
        flight_json,
        total_paid AS price,
        status,
        created_at,
        'FLIGHT' AS type
    FROM bookings
    WHERE email = ?
    ORDER BY created_at DESC
");
$fStmt->execute([$email]);
$flights = $fStmt->fetchAll(PDO::FETCH_ASSOC);

/* ======================
   HOTEL BOOKINGS
====================== */
$hStmt = $pdo->prepare("
    SELECT
        confirmation,
        hotel_name,
        city,
        checkin  AS start_date,
        checkout AS end_date,
        total_paid AS price,
        status,
        created_at,
        'HOTEL' AS type
    FROM hotel_bookings
    WHERE user_id = ?
    ORDER BY created_at DESC
");
$hStmt->execute([$userId]);
$hotels = $hStmt->fetchAll(PDO::FETCH_ASSOC);

/* ======================
   TOUR BOOKINGS
====================== */
$tStmt = $pdo->prepare("
    SELECT
        confirmation,
        tour_name,
        city,
        tour_date AS start_date,
        tour_date AS end_date,
        total_paid AS price,
        status,
        created_at,
        'TOUR' AS type
    FROM tour_bookings
    WHERE user_id = ?
    ORDER BY created_at DESC
");
$tStmt->execute([$userId]);
$tours = $tStmt->fetchAll(PDO::FETCH_ASSOC);

/* ======================
   MERGE + SORT
====================== */
$all = array_merge($flights, $hotels, $tours);

usort($all, function($a, $b){
    return strtotime($b['created_at'] ?? '') <=> strtotime($a['created_at'] ?? '');
});

/* ======================
   HELPERS
====================== */
function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function badgeTypeClass($type){
    return match($type){
        'FLIGHT' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
        'HOTEL'  => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
        'TOUR'   => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
        default  => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
    };
}

function badgeStatusClass($status){
    $s = strtoupper((string)$status);
    return match($s){
        'PAID', 'CONFIRMED', 'COMPLETED' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
        'PENDING' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
        'CANCELLED', 'FAILED' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
        default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
    };
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Bookings</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={darkMode:"class"}</script>
<style>
  :root{ --kav:#0A84D0; }
  .kav-link{ color:var(--kav); }
  .kav-btn{ background:var(--kav); }
  .kav-btn:hover{ filter:brightness(.92); }
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="md:ml-60 pt-24 px-4 md:px-6 pb-12">

  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
    <div>
      <h1 class="text-2xl font-bold">My Bookings</h1>
      <p class="text-sm text-gray-500 dark:text-gray-400">
        Flights, hotels, and tours in one place.
      </p>
    </div>

    <div class="flex items-center gap-2">
      <a href="index.php"
         class="px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-700">
        Home
      </a>
      <a href="flights.php"
         class="px-4 py-2 rounded-xl kav-btn text-white">
        Book new trip
      </a>
    </div>
  </div>

  <?php if (empty($all)): ?>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
      <p class="text-gray-500 dark:text-gray-400">No bookings found.</p>
    </div>
  <?php else: ?>

  <!-- DESKTOP TABLE -->
  <div class="hidden md:block bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 dark:bg-gray-700/60">
        <tr>
          <th class="p-4 text-left">Type</th>
          <th class="p-4 text-left">Details</th>
          <th class="p-4 text-center">Total</th>
          <th class="p-4 text-center">Status</th>
          <th class="p-4 text-center">Actions</th>
          <th class="p-4 text-center">Date</th>
        </tr>
      </thead>
      <tbody>

      <?php foreach ($all as $b): ?>
        <?php
          $type = $b['type'] ?? '';
          $status = $b['status'] ?? '';
          $confirmation = $b['confirmation'] ?? '';

          $flight = [];
          if ($type === 'FLIGHT') {
            $decoded = json_decode($b['flight_json'] ?? '{}', true);
            $flight = is_array($decoded) ? $decoded : [];
          }
        ?>
        <tr class="border-t border-gray-100 dark:border-gray-700/70 hover:bg-gray-50 dark:hover:bg-gray-700/30">

          <td class="p-4">
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?= badgeTypeClass($type) ?>">
              <?= h($type) ?>
            </span>
          </td>

          <td class="p-4">
            <?php if ($type === 'FLIGHT'): ?>
              <div class="font-semibold"><?= h($flight['airline'] ?? 'Flight') ?></div>
              <div class="text-gray-600 dark:text-gray-300">
                <?= h(($flight['from'] ?? '?').' → '.($flight['to'] ?? '?')) ?>
              </div>
              <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Confirmation: <?= h($confirmation) ?><?= !empty($b['pnr']) ? " · PNR: ".h($b['pnr']) : "" ?>
              </div>

            <?php elseif ($type === 'HOTEL'): ?>
              <div class="font-semibold"><?= h($b['hotel_name'] ?? 'Hotel') ?></div>
              <div class="text-gray-600 dark:text-gray-300">
                <?= h($b['city'] ?? '') ?> (<?= h($b['start_date'] ?? '') ?> → <?= h($b['end_date'] ?? '') ?>)
              </div>
              <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Confirmation: <?= h($confirmation) ?>
              </div>

            <?php else: ?>
              <div class="font-semibold"><?= h($b['tour_name'] ?? 'Tour') ?></div>
              <div class="text-gray-600 dark:text-gray-300">
                <?= h($b['city'] ?? '') ?> (<?= h($b['start_date'] ?? '') ?>)
              </div>
              <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Confirmation: <?= h($confirmation) ?>
              </div>
            <?php endif; ?>
          </td>

          <td class="p-4 text-center font-semibold">
            £<?= number_format((float)($b['price'] ?? 0), 2) ?>
          </td>

          <td class="p-4 text-center">
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?= badgeStatusClass($status) ?>">
              <?= h($status) ?>
            </span>
          </td>

          <td class="p-4 text-center">
            <div class="flex items-center justify-center gap-3">
              <?php if ($type === 'FLIGHT'): ?>
                <a class="kav-link hover:underline"
                   href="ticket-pdf.php?c=<?= urlencode($confirmation) ?>">
                   Ticket
                </a>
              <?php endif; ?>

              <a class="text-gray-600 dark:text-gray-300 hover:underline"
                 href="invoice-pdf.php?c=<?= urlencode($confirmation) ?>">
                 Invoice
              </a>

              <form method="POST" action="cancel-booking.php" class="inline">
                <input type="hidden" name="confirmation" value="<?= h($confirmation) ?>">
                <input type="hidden" name="type" value="<?= h($type) ?>">
                <button type="submit"
                        class="text-red-600 hover:underline"
                        onclick="return confirm('Cancel this booking?');">
                  Cancel
                </button>
              </form>
            </div>
          </td>

          <td class="p-4 text-center text-gray-500 dark:text-gray-400">
            <?= h($b['created_at'] ?? '') ?>
          </td>

        </tr>
      <?php endforeach; ?>

      </tbody>
    </table>
  </div>

  <!-- MOBILE CARDS -->
  <div class="md:hidden space-y-4">
    <?php foreach ($all as $b): ?>
      <?php
        $type = $b['type'] ?? '';
        $status = $b['status'] ?? '';
        $confirmation = $b['confirmation'] ?? '';

        if ($type === 'FLIGHT') {
          $decoded = json_decode($b['flight_json'] ?? '{}', true);
          $f = is_array($decoded) ? $decoded : [];
          $title = $f['airline'] ?? 'Flight';
          $line1 = ($f['from'] ?? '?').' → '.($f['to'] ?? '?');
          $line2 = 'Confirmation: '.$confirmation.( !empty($b['pnr']) ? ' · PNR: '.$b['pnr'] : '' );
        } elseif ($type === 'HOTEL') {
          $title = $b['hotel_name'] ?? 'Hotel';
          $line1 = ($b['city'] ?? '').' ('.$b['start_date'].' → '.$b['end_date'].')';
          $line2 = 'Confirmation: '.$confirmation;
        } else {
          $title = $b['tour_name'] ?? 'Tour';
          $line1 = ($b['city'] ?? '').' ('.$b['start_date'].')';
          $line2 = 'Confirmation: '.$confirmation;
        }
      ?>

      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5">
        <div class="flex items-start justify-between gap-3">
          <div>
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?= badgeTypeClass($type) ?>">
              <?= h($type) ?>
            </span>
            <div class="mt-2 font-semibold text-lg"><?= h($title) ?></div>
            <div class="text-sm text-gray-600 dark:text-gray-300"><?= h($line1) ?></div>
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?= h($line2) ?></div>
          </div>

          <div class="text-right">
            <div class="font-bold">£<?= number_format((float)($b['price'] ?? 0),2) ?></div>
            <div class="mt-2">
              <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?= badgeStatusClass($status) ?>">
                <?= h($status) ?>
              </span>
            </div>
          </div>
        </div>

        <div class="mt-4 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
          <span><?= h($b['created_at'] ?? '') ?></span>
          <div class="flex gap-3">
            <?php if ($type === 'FLIGHT'): ?>
              <a class="kav-link" href="ticket-pdf.php?c=<?= urlencode($confirmation) ?>">Ticket</a>
            <?php endif; ?>
            <a class="kav-link" href="invoice-pdf.php?c=<?= urlencode($confirmation) ?>">Invoice</a>
          </div>
        </div>

        <div class="mt-3">
          <form method="POST" action="cancel-booking.php">
            <input type="hidden" name="confirmation" value="<?= h($confirmation) ?>">
            <input type="hidden" name="type" value="<?= h($type) ?>">
            <button type="submit"
                    class="w-full border border-red-300 text-red-600 rounded-xl py-2"
                    onclick="return confirm('Cancel this booking?');">
              Cancel booking
            </button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <?php endif; ?>

<?php include "footer.php"; ?>
</main>
</body>
</html>
