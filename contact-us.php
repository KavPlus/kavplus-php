<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Us – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- TailwindCSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- UI Enhancements -->
<link rel="stylesheet" href="styles.css">

</head>

<body class="bg-gray-100">

<!-- Sidebar + Header -->
<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="ml-60 pt-24 pb-20 page-fade">

    <!-- HEADER -->
    <section>
        <img src="banners/contact.jpg" class="w-full h-72 object-cover">
    </section>

    <div class="max-w-6xl mx-auto mt-10">
        <h1 class="text-3xl font-bold">Contact Us</h1>
        <p class="text-gray-600 mt-2">
            We’re here to help with bookings, cancellations, payments, and more.
        </p>
    </div>

    <!-- CONTACT GRID -->
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 mt-10">

        <!-- LEFT: CONTACT FORM -->
        <div class="bg-white p-8 rounded-xl shadow card-hover">

            <h2 class="text-2xl font-bold mb-4">Send Us a Message</h2>
            <p class="text-gray-600 mb-6">Our support team replies within 12–24 hours.</p>

            <form class="space-y-5">

                <div>
                    <label class="font-medium">Full Name</label>
                    <input type="text" class="w-full border p-3 rounded-lg mt-1" placeholder="Your Name">
                </div>

                <div>
                    <label class="font-medium">Email Address</label>
                    <input type="email" class="w-full border p-3 rounded-lg mt-1" placeholder="you@example.com">
                </div>

                <div>
                    <label class="font-medium">Phone Number</label>
                    <input type="text" class="w-full border p-3 rounded-lg mt-1" placeholder="+44 7123 456789">
                </div>

                <div>
                    <label class="font-medium">Message</label>
                    <textarea class="w-full border p-3 rounded-lg mt-1" rows="4" placeholder="How can we help you?"></textarea>
                </div>

                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 btn-hover">
                    Submit Message
                </button>

            </form>
        </div>

        <!-- RIGHT: CONTACT INFO -->
        <div class="space-y-6">

            <!-- PHONE SUPPORT -->
            <div class="bg-white p-6 rounded-xl shadow card-hover">
                <h3 class="text-xl font-bold">📞 Phone Support</h3>
                <p class="text-gray-600 mt-2">Available 24/7 for urgent inquiries.</p>
                <p class="text-blue-700 font-bold text-lg mt-2">+44 20 1234 5678</p>
            </div>

            <!-- EMAIL SUPPORT -->
            <div class="bg-white p-6 rounded-xl shadow card-hover">
                <h3 class="text-xl font-bold">📧 Email Support</h3>
                <p class="text-gray-600 mt-2">We reply within 12–24 hours.</p>
                <p class="text-blue-700 font-bold text-lg mt-2">support@kavplus.com</p>
                <p class="text-blue-700 font-bold text-lg">billing@kavplus.com</p>
            </div>

            <!-- OFFICE LOCATIONS -->
            <div class="bg-white p-6 rounded-xl shadow card-hover">
                <h3 class="text-xl font-bold">🏢 Office Address</h3>
                <p class="text-gray-600 mt-2">KavPlus Travel Headquarters</p>
                <p class="text-gray-700">123 West Avenue, London, UK</p>
                <p class="text-gray-700">Mon – Fri · 9:00 AM – 6:00 PM</p>
            </div>

        </div>
    </div>

    <!-- MAP PLACEHOLDER -->
    <div class="max-w-6xl mx-auto mt-12">
        <h2 class="text-xl font-bold mb-4">Find Us on the Map</h2>
        <div class="w-full h-72 bg-gray-300 rounded-xl shadow card-hover flex items-center justify-center">
            <p class="text-gray-700">Map Integration Coming Soon</p>
        </div>
    </div>

    <!-- FOOTER -->
    <?php include "footer.php"; ?>
</main>

<script src="include.js"></script>

</body>
</html>
