<?php
session_start();

/* ==========================
   SAFE GUARDS
========================== */
$search   = $_SESSION['flight_search'] ?? ['adults'=>1];
$selected = $_SESSION['selected_flight'] ?? [
  'airline'=>'Selected flight',
  'price'=>2496
];

/* ==========================
   CONFIG
========================== */
$currency = "£";
$baseTicket = (float)($selected['price'] ?? 2496);
$flexPrice  = 385.00;

$adults = (int)($search['adults'] ?? 1);
$totalPax = max(1, $adults);

/* ==========================
   INIT SESSION SEATS
========================== */
if (!isset($_SESSION['seat_assignments'])) {
  $_SESSION['seat_assignments'] = array_fill(0, $totalPax, null);
}

/* ==========================
   SEAT CONFIG
========================== */
$seatPrices = [
  "standard"  => 0,
  "preferred" => 58.60,
  "legroom"   => 92.10
];

$blockedSeats = ['37C','38D','39A','40F','41B','42E'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Seat selection – Kav+</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={darkMode:"class"}</script>

<style>
:root{ --kav:#0A84D0; --kav-dark:#0669A6; }

.seat-scroll{ max-height:70vh; overflow:hidden; }
.seat-scroll:hover{ overflow:auto; }

.seat{
  width:44px;height:44px;border-radius:10px;
  border:2px solid var(--kav);
  font-size:12px;font-weight:600;
  display:flex;align-items:center;justify-content:center;
  cursor:pointer;background:#fff;position:relative;
}
.dark .seat{ background:#1e293b; }

.seat.preferred{ background:#e0f2fe; }
.seat.legroom{ background:#fff7ed;border-color:#f59e0b; }
.seat.blocked{ background:#e5e7eb;border-color:#9ca3af;cursor:not-allowed;opacity:.6; }
.seat.selected{ background:var(--kav);color:#fff; }

.tooltip{
  position:absolute;bottom:115%;left:50%;
  transform:translateX(-50%);
  background:#111;color:#fff;padding:6px 10px;
  font-size:11px;border-radius:6px;display:none;
}
.seat:hover .tooltip{ display:block; }

.stickyPrice{ position:sticky; top:96px; }

.modalBg{
  position:fixed;inset:0;background:rgba(0,0,0,.5);
  display:none;align-items:center;justify-content:center;z-index:50;
}
.modal{
  background:#fff;border-radius:16px;
  max-width:420px;width:92%;padding:24px;
}
.dark .modal{ background:#1e293b; }
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100
             pt-16 md:pt-20 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<div class="px-4 md:px-8">

<!-- HEADER -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 mb-6">
  <h1 class="text-3xl font-bold">Seat selection</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

<!-- LEFT -->
<div class="lg:col-span-2 space-y-6">

<!-- PASSENGERS -->
<?php for($i=0;$i<$totalPax;$i++): ?>
<div class="bg-blue-50 dark:bg-gray-800 border border-blue-300 dark:border-gray-700 rounded-2xl p-4">
  <div class="font-semibold">Passenger <?= $i+1 ?></div>
  <div class="text-sm text-gray-500">
    Seat:
    <span id="seatLabel<?= $i ?>">
      <?= $_SESSION['seat_assignments'][$i]['seat'] ?? 'Not selected' ?>
    </span>
  </div>
</div>
<?php endfor; ?>

<!-- AIRCRAFT -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5">
  <div class="font-semibold"><?= htmlspecialchars($selected['airline']) ?></div>
  <div class="text-sm text-gray-500">Boeing 787-9 · Economy class</div>
</div>

<!-- SEAT MAP -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 seat-scroll">
  <div class="grid grid-cols-6 gap-3 justify-center">
<?php
$rows = range(37,42);
$cols = ['A','B','C','D','E','F'];
foreach($rows as $r){
  foreach($cols as $c){
    $code = $r.$c;
    $blocked = in_array($code,$blockedSeats);
    $type = ($r<=38) ? 'legroom' : (($c==='C'||$c==='D')?'preferred':'standard');
    $price = $seatPrices[$type];
    $cls = "seat $type".($blocked?" blocked":"");
    echo "<div class='$cls' onclick=\"selectSeat('$code',$price,$blocked)\">
            $code
            <div class='tooltip'>$currency".number_format($price,2)."</div>
          </div>";
  }
}
?>
  </div>
</div>

<!-- ACTIONS -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex justify-between items-center">
  <a href="flight-fare.php"
     class="px-6 py-3 rounded-xl border border-gray-300 dark:border-gray-600">
    Back
  </a>

  <form action="flight-payment.php" method="POST">
    <button id="skipBtn"
            class="px-6 py-3 rounded-xl bg-[var(--kav)] text-white">
      Skip seat selection
    </button>
  </form>
</div>

</div>

<!-- RIGHT -->
<div class="lg:col-span-1">
<div class="stickyPrice bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
  <h3 class="text-xl font-bold mb-4">Price Details</h3>

  <div class="flex justify-between text-sm">
    <span>Tickets</span>
    <span><?= $currency ?><?= number_format($baseTicket,2) ?></span>
  </div>

  <div class="flex justify-between text-sm mt-1">
    <span>Seat</span>
    <span id="seatTotal"><?= $currency ?>0.00</span>
  </div>

  <div class="flex justify-between text-sm mt-1">
    <span>Flexibility</span>
    <span><?= $currency ?><?= number_format($flexPrice,2) ?></span>
  </div>

  <hr class="my-4">

  <div class="flex justify-between font-bold text-lg">
    <span>Total</span>
    <span id="grandTotal">
      <?= $currency ?><?= number_format($baseTicket+$flexPrice,2) ?>
    </span>
  </div>
</div>
</div>

</div>
</div>

<!-- MODAL -->
<div id="confirmModal" class="modalBg">
  <div class="modal">
    <h3 class="text-lg font-bold mb-2">Confirm paid seat</h3>
    <p class="text-sm text-gray-500 mb-4">
      This seat has an additional cost. Continue?
    </p>
    <div class="flex justify-end gap-3">
      <button onclick="closeModal()" class="px-4 py-2 rounded-xl border">
        Cancel
      </button>
      <button onclick="confirmSeat()"
              class="px-4 py-2 rounded-xl bg-[var(--kav)] text-white">
        Confirm
      </button>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>

<script>
let currentPassenger = 0;
let pendingSeat = null;
let pendingPrice = 0;
let seatSum = 0;

function selectSeat(code,price,blocked){
  if(blocked) return;
  if(price>0){
    pendingSeat=code; pendingPrice=price;
    document.getElementById('confirmModal').style.display='flex';
  }else{
    applySeat(code,price);
  }
}

function confirmSeat(){
  applySeat(pendingSeat,pendingPrice);
  closeModal();
}
function closeModal(){
  document.getElementById('confirmModal').style.display='none';
}

function applySeat(code,price){
  document.getElementById('seatLabel'+currentPassenger).textContent = code;

  fetch("seat-save.php",{
    method:"POST",
    headers:{ "Content-Type":"application/json" },
    body:JSON.stringify({
      passenger: currentPassenger,
      seat: code,
      price: price
    })
  });

  seatSum += price;
  document.getElementById('seatTotal').textContent = "£"+seatSum.toFixed(2);
  document.getElementById('grandTotal').textContent =
    "£"+(<?= $baseTicket ?>+<?= $flexPrice ?>+seatSum).toFixed(2);

  currentPassenger++;
  if(currentPassenger>=<?= $totalPax ?>){
    document.getElementById('skipBtn').textContent="Continue";
  }
}
</script>

</body>
</html>
