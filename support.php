<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Support – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { darkMode: 'class' }
</script>

<style>
:root{
  --kav:#0097D7;
  --kav2:#007fb8;
}
.card-hover{transition:.25s}
.card-hover:hover{transform:translateY(-3px);box-shadow:0 18px 45px rgba(0,0,0,.15)}
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300">

<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="pt-24 md:ml-60 pb-20">

<!-- HERO -->
<section class="relative h-80">
  <img src="banners/support.jpg"
       class="absolute inset-0 w-full h-full object-cover"
       onerror="this.src='banners/home.jpg'">

  <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/30"></div>

  <div class="relative z-10 max-w-7xl mx-auto px-6 h-full flex items-center">
    <div>
      <h1 class="text-4xl font-extrabold text-white">How can we help?</h1>
      <p class="text-white/90 mt-2 text-lg">
        24/7 support for bookings, payments, cancellations & more
      </p>
    </div>
  </div>
</section>

<div class="max-w-7xl mx-auto px-6">

<!-- QUICK HELP -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">

  <a href="my-bookings.php"
     class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow card-hover">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
      Booking Issues
    </h3>
    <p class="text-gray-600 dark:text-gray-300">
      Flights, hotels, tours or ticket problems
    </p>
    <span class="text-[#0097D7] font-semibold mt-4 inline-block">
      View My Bookings →
    </span>
  </a>

  <a href="#refunds"
     class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow card-hover">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
      Refunds & Cancellations
    </h3>
    <p class="text-gray-600 dark:text-gray-300">
      Cancellation rules & refund timelines
    </p>
    <span class="text-[#0097D7] font-semibold mt-4 inline-block">
      Refund Policy →
    </span>
  </a>

  <a href="#payments"
     class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow card-hover">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
      Payment & Billing
    </h3>
    <p class="text-gray-600 dark:text-gray-300">
      Cards, invoices & charges
    </p>
    <span class="text-[#0097D7] font-semibold mt-4 inline-block">
      Payment Help →
    </span>
  </a>

</div>

<!-- CONTACT -->
<div class="mt-16 bg-white dark:bg-gray-800 rounded-3xl p-10 shadow card-hover">

  <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">
    Contact Support
  </h2>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- CHAT -->
    <div class="bg-blue-50 dark:bg-gray-700 rounded-2xl p-6 text-center card-hover">
      <h3 class="text-xl font-bold mb-2">Live Chat</h3>
      <p class="text-gray-700 dark:text-gray-300">
        Chat instantly with our agents
      </p>
      <button class="mt-4 bg-[#0097D7] text-white px-6 py-3 rounded-xl hover:bg-[#007fb8]">
        Start Chat
      </button>
    </div>

    <!-- EMAIL -->
    <div class="bg-blue-50 dark:bg-gray-700 rounded-2xl p-6 text-center card-hover">
      <h3 class="text-xl font-bold mb-2">Email Support</h3>
      <p class="text-gray-700 dark:text-gray-300">
        Response within 6–12 hours
      </p>
      <p class="font-semibold text-[#0097D7] mt-2">
        support@kavplus.com
      </p>
    </div>

    <!-- PHONE -->
    <div class="bg-blue-50 dark:bg-gray-700 rounded-2xl p-6 text-center card-hover">
      <h3 class="text-xl font-bold mb-2">Call Us</h3>
      <p class="text-gray-700 dark:text-gray-300">
        24/7 urgent assistance
      </p>
      <p class="font-semibold text-[#0097D7] mt-2">
        +44 20 1234 5678
      </p>
    </div>

  </div>
</div>

<!-- FAQ -->
<div class="mt-16">

  <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
    Frequently Asked Questions
  </h2>

  <div class="space-y-4">

    <?php
    $faqs = [
      ["How do I cancel my booking?","Go to My Bookings → Select booking → Cancel."],
      ["When will I get my refund?","Most refunds are processed in 5–7 business days."],
      ["How can I change flight dates?","If allowed by airline, changes appear in booking details."],
      ["I didn’t receive my ticket email.","Check spam or contact support to resend."]
    ];
    foreach($faqs as $f):
    ?>
    <details class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 card-hover">
      <summary class="cursor-pointer font-semibold text-gray-900 dark:text-white">
        <?= htmlspecialchars($f[0]) ?>
      </summary>
      <p class="text-gray-600 dark:text-gray-300 mt-3">
        <?= htmlspecialchars($f[1]) ?>
      </p>
    </details>
    <?php endforeach; ?>

  </div>

</div>

</div>

<?php include "footer.php"; ?>
</main>

<script src="include.js"></script>
</body>
</html>
