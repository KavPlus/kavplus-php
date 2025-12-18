<?php
header("Content-Type: application/json");

$q = strtolower(trim($_GET['q'] ?? ''));
if (strlen($q) < 2) exit(json_encode([]));

$data = json_decode(file_get_contents(__DIR__."/data/airports.json"), true);
$out = [];

foreach ($data as $a) {
  if (
    strpos(strtolower($a['city']), $q) !== false ||
    strpos(strtolower($a['code']), $q) !== false
  ) {
    $out[] = $a;
    if (count($out) === 8) break;
  }
}

echo json_encode($out);
