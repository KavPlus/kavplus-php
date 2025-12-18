<?php
session_start();
include "header.php";
include "sidebar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Get the Kav+ App</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { darkMode:'class' }
</script>

<style>
.kav-bg{ background:#0097D7 }
.kav-bg:hover{ background:#0083BD }
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 md:ml-60 pt-24 text-gray-900 dark:text-gray-100">

<div class="max-w-5xl mx-auto px-6 py-10">

<!-- HEADER -->
<div class="text-center mb-10">
  <h1 class="text-3xl font-extrabold mb-3">Get the Kav+ App</h1>
  <p class="text-gray-600 dark:text-gray-400">
    Book flights, hotels & tours faster with the Kav+ mobile app
  </p>
</div>

<!-- CONTENT -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

<!-- ANDROID -->
<div class="bg-white dark:bg-gray-800 rounded-3xl shadow p-8 text-center">
  <h2 class="text-xl font-semibold mb-4">Android</h2>

  <!-- QR -->
  <div class="flex justify-center mb-4">
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=https://play.google.com/store"
         alt="Android QR"
         class="rounded-xl border dark:border-gray-700">
  </div>

  <p class="text-sm text-gray-500 mb-4">
    Scan to download from Google Play
  </p>

  <a href="https://play.google.com/store"
     target="_blank"
     class="inline-block kav-bg text-white px-6 py-3 rounded-xl font-semibold">
    Download for Android
  </a>
</div>

<!-- IOS -->
<div class="bg-white dark:bg-gray-800 rounded-3xl shadow p-8 text-center">
  <h2 class="text-xl font-semibold mb-4">iPhone</h2>

  <!-- QR -->
  <div class="flex justify-center mb-4">
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=https://www.apple.com/app-store/"
         alt="iOS QR"
         class="rounded-xl border dark:border-gray-700">
  </div>

  <p class="text-sm text-gray-500 mb-4">
    Scan to download from App Store
  </p>

  <a href="https://www.apple.com/app-store/"
     target="_blank"
     class="inline-block kav-bg text-white px-6 py-3 rounded-xl font-semibold">
    Download for iPhone
  </a>
</div>

</div>

<!-- FOOT NOTE -->
<div class="mt-10 text-center text-sm text-gray-500">
  Available on Android & iOS · Secure · Fast · Trusted
</div>

</div>

<?php include "footer.php"; ?>

</body>
</html>
