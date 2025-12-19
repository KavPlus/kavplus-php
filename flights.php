<?php

/* =========================
   LOAD PREVIOUS SEARCH (IF ANY)
========================= */
$sessionSearch = $_SESSION['flight_search'] ?? [];

$from     = $_GET['from']     ?? ($sessionSearch['from'] ?? '');
$to       = $_GET['to']       ?? ($sessionSearch['to'] ?? '');
$dates    = $_GET['dates']    ?? ($sessionSearch['dates'] ?? '');
$tripType = $_GET['trip']     ?? ($sessionSearch['trip'] ?? 'round');

$nonstopChecked = isset($_GET['nonstop']) || !empty($sessionSearch['nonstop']);

$adults   = (int)($_GET['adults']   ?? ($sessionSearch['adults'] ?? 1));
$children = (int)($_GET['children'] ?? ($sessionSearch['children'] ?? 0));
$infants  = (int)($_GET['infants']  ?? ($sessionSearch['infants'] ?? 0));
$class    = $_GET['class']    ?? ($sessionSearch['class'] ?? 'Economy');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Flights – Kav+ Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode: "class" }
</script>

<!-- Date picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
:root{
  --kav-blue:#0097D7;
  --kav-blue-dark:#0083BD;
}

/* hero */
.hero{
  height:420px;
  background:url("./banners/flight-banner.jpg") center/cover no-repeat;
  position:relative;
}
.hero::after{
  content:"";
  position:absolute;
  inset:0;
  background:linear-gradient(to bottom,rgba(0,0,0,.35),rgba(0,0,0,.65));
}

/* Buttons */
.kav-btn{ background:var(--kav-blue); }
.kav-btn:hover{ background:var(--kav-blue-dark); }

.paxBtn{
  width:34px;height:34px;border-radius:9999px;
  border:1px solid rgba(0,0,0,.2);
  font-weight:700;color:var(--kav-blue);
}
.dark .paxBtn{
  border-color:rgba(255,255,255,.3);
  color:#60a5fa;
}
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100
             pt-16 md:pt-20 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<!-- HERO -->
<section class="hero rounded-b-[28px] shadow-lg">
  <div class="relative z-10 max-w-6xl mx-auto px-6 pt-24 text-white">
    <h1 class="text-4xl font-extrabold">Book Fast - Fly Safe!</h1>
    <p class="mt-2 text-sm text-white/90">Secure Payments</p>
    <p class="mt-2 text-sm text-white/90">24/7 Support</p>
    <p class="mt-2 text-sm text-white/90">KAV+ Rewards on every booking</p>
  </div>
</section>

<!-- SEARCH CARD -->
<div class="-mt-24 px-4 md:px-8 relative z-20">
<form action="flights-result.php" method="GET"
      class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-4 md:p-6">

<!-- TRIP TYPE -->
<div class="flex flex-wrap gap-4 mb-4 text-sm font-semibold">
  <label>
    <input type="radio" name="trip" value="round" <?= $tripType==='round'?'checked':'' ?>>
    Round-trip
  </label>
  <label>
    <input type="radio" name="trip" value="oneway" <?= $tripType==='oneway'?'checked':'' ?>>
    One-way
  </label>
  <label class="text-gray-500 dark:text-gray-400">
    <input type="checkbox" name="nonstop" <?= $nonstopChecked?'checked':'' ?>>
    Nonstop
  </label>
</div>

<!-- GRID -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">

<input name="from" value="<?= htmlspecialchars($from) ?>" placeholder="From"
       class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">

<input name="to" value="<?= htmlspecialchars($to) ?>" placeholder="To"
       class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">

<input id="dateRange" name="dates" value="<?= htmlspecialchars($dates) ?>"
       placeholder="Depart — Return" readonly
       class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl cursor-pointer">

<!-- PASSENGERS -->
<div class="relative">
<button type="button" id="paxTrigger"
  class="w-full bg-gray-100 dark:bg-gray-700 p-3 rounded-xl flex justify-between">
  <span id="paxLabel"><?= $adults ?> adult · <?= htmlspecialchars($class) ?></span>
  <span>▾</span>
</button>

<div id="paxPanel"
     class="hidden absolute right-0 mt-2 w-[360px]
            bg-white dark:bg-gray-800
            rounded-2xl shadow-xl z-50">

<div class="p-4 space-y-4">
<?php
$rows = [
  ['Adults','adults','12+'],
  ['Children','children','2–11'],
  ['Infants','infants','<2'],
];
foreach($rows as $r):
?>
<div class="flex justify-between items-center">
  <div>
    <div class="font-semibold"><?= $r[0] ?></div>
    <div class="text-xs text-gray-500"><?= $r[2] ?></div>
  </div>
  <div class="flex items-center gap-2">
    <button type="button" class="paxBtn" data-type="<?= $r[1] ?>" data-op="-">−</button>
    <span id="<?= $r[1] ?>Val"><?= $$r[1] ?></span>
    <button type="button" class="paxBtn" data-type="<?= $r[1] ?>" data-op="+">+</button>
  </div>
</div>
<?php endforeach; ?>

<select id="cabinSelect" class="w-full bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">
<?php foreach(['Economy','Premium Economy','Business','First'] as $c): ?>
<option <?= $class===$c?'selected':'' ?>><?= $c ?></option>
<?php endforeach; ?>
</select>

<button type="button" id="paxDone"
        class="kav-btn text-white w-full py-2 rounded-xl">
Done
</button>
</div>

<input type="hidden" name="adults" id="adultsInput" value="<?= $adults ?>">
<input type="hidden" name="children" id="childrenInput" value="<?= $children ?>">
<input type="hidden" name="infants" id="infantsInput" value="<?= $infants ?>">
<input type="hidden" name="class" id="classInput" value="<?= htmlspecialchars($class) ?>">
</div>
</div>

<button type="submit"
        class="kav-btn text-white rounded-xl py-3 font-semibold">
Search Flights
</button>

</div>
</form>
</div>

<?php include "footer.php"; ?>

<script>
flatpickr("#dateRange",{
  mode: "<?= $tripType==='oneway' ? 'single' : 'range' ?>",
  showMonths: 2,
  minDate: "today",
  disableMobile: true
});

const state = {
  adults: <?= $adults ?>,
  children: <?= $children ?>,
  infants: <?= $infants ?>
};

function syncPax(){
  if(state.adults < 1) state.adults = 1;
  if(state.infants > state.adults) state.infants = state.adults;

  adultsVal.textContent = state.adults;
  childrenVal.textContent = state.children;
  infantsVal.textContent = state.infants;

  adultsInput.value = state.adults;
  childrenInput.value = state.children;
  infantsInput.value = state.infants;

  classInput.value = cabinSelect.value;
  paxLabel.textContent = `${state.adults} adult · ${cabinSelect.value}`;
}

document.querySelectorAll(".paxBtn").forEach(btn=>{
  btn.addEventListener("click",()=>{
    state[btn.dataset.type] += btn.dataset.op === "+" ? 1 : -1;
    syncPax();
  });
});

paxTrigger.onclick = ()=> paxPanel.classList.toggle("hidden");
paxDone.onclick    = ()=> paxPanel.classList.add("hidden");
cabinSelect.onchange = syncPax;

syncPax();
</script>

</body>
</html>
