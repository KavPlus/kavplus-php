<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Find Booking – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<!-- Sidebar + Header -->
<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="ml-60 pt-24">

    <!-- PAGE TITLE -->
    <div class="max-w-4xl mx-auto mb-8">
        <h2 class="text-3xl font-bold">Find Your Booking</h2>
        <p class="text-gray-600 mt-1">Enter your booking details to view, print, or manage your reservation.</p>
    </div>

    <!-- LOOKUP BOX -->
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl p-8 space-y-6">

        <!-- OPTION TABS -->
        <div class="flex space-x-6 border-b pb-2 text-lg font-medium">
            <button id="tabPNR" class="text-blue-600 border-b-2 border-blue-600 pb-2">By PNR</button>
            <button id="tabEmail" class="text-gray-500 pb-2 hover:text-blue-600">By Email</button>
        </div>

        <!-- SEARCH BY PNR -->
        <div id="boxPNR">
            <label class="block font-medium mb-1">Last Name</label>
            <input class="w-full border p-3 rounded-lg mb-4" type="text" placeholder="Example: Smith">

            <label class="block font-medium mb-1">Booking Reference (PNR)</label>
            <input class="w-full border p-3 rounded-lg mb-4" type="text" placeholder="Example: KP8Z302">

            <a href="booking-confirmed.php">
                <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
                    Find Booking
                </button>
            </a>
        </div>

        <!-- SEARCH BY EMAIL & PHONE -->
        <div id="boxEmail" class="hidden">
            <label class="block font-medium mb-1">Email</label>
            <input class="w-full border p-3 rounded-lg mb-4" type="email" placeholder="you@example.com">

            <label class="block font-medium mb-1">Phone Number</label>
            <input class="w-full border p-3 rounded-lg mb-4" type="text" placeholder="+44 7123 456789">

            <a href="booking-confirmed.php">
                <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
                    Find Booking
                </button>
            </a>
        </div>

    </div>

    <!-- FOOTER -->
    

  <?php include "footer.php"; ?>

</main>

<script src="include.js"></script>

<!-- TAB SWITCH SCRIPT -->
<script>
document.getElementById("tabPNR").addEventListener("click", () => {
    document.getElementById("boxPNR").classList.remove("hidden");
    document.getElementById("boxEmail").classList.add("hidden");
    document.getElementById("tabPNR").classList.add("text-blue-600", "border-blue-600", "border-b-2");
    document.getElementById("tabEmail").classList.remove("text-blue-600", "border-blue-600", "border-b-2");
});

document.getElementById("tabEmail").addEventListener("click", () => {
    document.getElementById("boxEmail").classList.remove("hidden");
    document.getElementById("boxPNR").classList.add("hidden");
    document.getElementById("tabEmail").classList.add("text-blue-600", "border-blue-600", "border-b-2");
    document.getElementById("tabPNR").classList.remove("text-blue-600", "border-blue-600", "border-b-2");
});
</script>

</body>
</html>
