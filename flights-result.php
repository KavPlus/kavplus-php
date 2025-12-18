<?php
session_start();

/* =========================
   READ SEARCH PARAMS
========================= */
$from   = $_GET['from']   ?? 'London';
$to     = $_GET['to']     ?? 'Bangkok';
$dates  = $_GET['dates']  ?? 'Dec 16 - Dec 18';
$adults = (int)($_GET['adults'] ?? 1);
$class  = $_GET['class']  ?? 'Economy';

/* =========================
   MOCK FLIGHTS (UI ONLY)
========================= */
$flights = [
  [
    'airline'=>'Norse Atlantic Airways',
    'from_time'=>'16:00',
    'from_code'=>'LGW S',
    'to_time'=>'10:25',
    'to_code'=>'BKK',
    'duration'=>'11h 25m',
    'price'=>765,
    'badge'=>'Cheapest direct'
  ],
  [
    'airline'=>'EVA Air',
    'from_time'=>'21:20',
    'from_code'=>'LHR T2',
    'to_time'=>'16:00',
    'to_code'=>'BKK',
    'duration'=>'11h 40m',
    'price'=>927,
    'badge'=>'Included'
  ],
  [
    'airline'=>'Thai Airways',
    'from_time'=>'21:35',
    'from_code'=>'LHR T2',
    'to_time'=>'16:00',
    'to_code'=>'BKK',
    'duration'=>'11h 25m',
    'price'=>1333,
    'badge'=>'Included'
  ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Flight Results – Kav+</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode:'class' }
</script>

<style>
.kav-bg{ background:#0097D7 }
.kav-bg:hover{ background:#0083BD }
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100
             pt-16 md:pt-20 md:ml-60">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<!-- ========================= -->
<!-- SEARCH BAR -->
<!-- ========================= -->
<form action="flights-result.php" method="GET"
      class="bg-white dark:bg-gray-800 rounded-2xl shadow mx-6 p-4">

  <!-- Top options -->
  <div class="flex flex-wrap items-center gap-4 text-sm mb-4">
    <label><input type="radio" checked> Return</label>
    <label><input type="radio"> One-way</label>
    <label><input type="radio"> Multi-city</label>
    <label class="ml-4"><input type="checkbox"> Direct</label>

    <button type="submit"
            class="ml-auto kav-bg text-white px-6 py-2 rounded-xl font-semibold">
      🔍 Search
    </button>
  </div>

  <!-- Inputs -->
  <div class="grid grid-cols-1 md:grid-cols-5 gap-3">

    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">
      <div class="font-semibold"><?= htmlspecialchars($from) ?></div>
      <div class="text-xs">All airports</div>
      <input type="hidden" name="from" value="<?= htmlspecialchars($from) ?>">
    </div>

    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">
      <div class="font-semibold"><?= htmlspecialchars($to) ?></div>
      <div class="text-xs">All airports</div>
      <input type="hidden" name="to" value="<?= htmlspecialchars($to) ?>">
    </div>

    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">
      <?= htmlspecialchars($dates) ?>
      <input type="hidden" name="dates" value="<?= htmlspecialchars($dates) ?>">
    </div>

    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">
      <?= $adults ?> adult · <?= htmlspecialchars($class) ?>
      <input type="hidden" name="adults" value="<?= $adults ?>">
      <input type="hidden" name="class" value="<?= htmlspecialchars($class) ?>">
    </div>

  </div>
</form>

<!-- ========================= -->
<!-- DATE PRICE STRIP -->
<!-- ========================= -->
<div class="mx-6 mt-4 bg-white dark:bg-gray-800 rounded-xl p-3 flex gap-4 overflow-x-auto text-sm">
<?php
$days = [
 ['Dec 14 - Dec 16',640],
 ['Dec 15 - Dec 17',640],
 ['Dec 16 - Dec 18',605],
 ['Dec 17 - Dec 19',770],
 ['Dec 18 - Dec 20',824],
];
foreach($days as $i=>$d):
?>
<div class="min-w-[140px] text-center p-3 rounded-xl
            <?= $i==2?'kav-bg text-white':'bg-gray-100 dark:bg-gray-700' ?>">
  <div><?= $d[0] ?></div>
  <div class="font-semibold">£<?= $d[1] ?></div>
</div>
<?php endforeach; ?>
</div>

<!-- ========================= -->
<!-- MAIN GRID -->
<!-- ========================= -->
<div class="mx-6 mt-6 grid grid-cols-1 md:grid-cols-12 gap-6">

<!-- FILTERS -->
<aside class="md:col-span-3 space-y-6 text-sm">

  <div class="bg-white dark:bg-gray-800 rounded-xl p-4">
    <h3 class="font-semibold mb-2">Recommended</h3>
    <label class="block"><input type="checkbox"> Direct</label>
    <label class="block"><input type="checkbox"> Checked baggage</label>
    <div class="text-[#0097D7] mt-2 cursor-pointer">Show more</div>
  </div>

  <div class="bg-white dark:bg-gray-800 rounded-xl p-4">
    <h3 class="font-semibold mb-2">Alliance</h3>
    <div>Oneworld</div>
    <div>Star Alliance</div>
    <div>SkyTeam</div>
  </div>

  <div class="bg-white dark:bg-gray-800 rounded-xl p-4">
    <h3 class="font-semibold mb-2">Airlines</h3>
    <div>Emirates</div>
    <div>Cathay Pacific</div>
    <div>Thai Airways</div>
  </div>

</aside>

<!-- RESULTS -->
<section class="md:col-span-9 space-y-4">

<div class="flex justify-between items-center">
  <h2 class="font-semibold">Departures to <?= htmlspecialchars($to) ?></h2>
  <span class="text-sm text-gray-500">91 flights found</span>
</div>

<?php foreach($flights as $f): ?>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">

  <div class="flex flex-wrap items-center justify-between gap-4">

    <!-- LEFT -->
    <div>
      <div class="flex items-center gap-2">
        <span class="font-semibold"><?= $f['airline'] ?></span>
        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">
          <?= $f['badge'] ?>
        </span>
      </div>

      <div class="mt-3 flex items-center gap-6 text-sm">
        <div>
          <div class="font-semibold"><?= $f['from_time'] ?></div>
          <div class="text-xs text-gray-500"><?= $f['from_code'] ?></div>
        </div>

        <div class="text-gray-400">──── Direct ────</div>

        <div>
          <div class="font-semibold"><?= $f['to_time'] ?> <sup>+1</sup></div>
          <div class="text-xs text-gray-500"><?= $f['to_code'] ?></div>
        </div>
      </div>

      <div class="text-xs text-gray-500 mt-1"><?= $f['duration'] ?></div>
    </div>

    <!-- RIGHT -->
    <div class="text-right">
      <div class="text-2xl font-bold">£<?= $f['price'] ?></div>
      <div class="text-xs text-gray-500">Return</div>
      <a href="flight-details.php"
         class="inline-block mt-3 kav-bg text-white px-6 py-2 rounded-xl font-semibold">
        Select
      </a>
    </div>

  </div>
</div>
<?php endforeach; ?>

</section>
</div>

<?php include "footer.php"; ?>
</body>
</html>
