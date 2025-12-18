<?php include "auth.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Account – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- UI Enhancements -->
<link rel="stylesheet" href="styles.css">

</head>

<body class="bg-gray-100">

<!-- Sidebar + Header -->
<?php include "sidebar.php"; ?>
<?php include "header.php"; ?>

<main class="ml-60 pt-24 pb-20 page-fade">

    <!-- TITLE -->
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold">My Account</h1>
        <p class="text-gray-600 mt-1">Manage your personal information & travel documents.</p>
    </div>

    <!-- ACCOUNT BOX -->
    <div class="max-w-5xl mx-auto mt-8 bg-white shadow-xl rounded-xl p-8 space-y-10 card-hover">

        <!-- PERSONAL DETAILS -->
        <h2 class="text-xl font-semibold border-b pb-2">Personal Information</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div>
                <label class="font-medium">First Name</label>
                <input type="text" class="w-full border p-3 rounded-lg mt-1" placeholder="John">
            </div>

            <div>
                <label class="font-medium">Last Name</label>
                <input type="text" class="w-full border p-3 rounded-lg mt-1" placeholder="Doe">
            </div>

            <div>
                <label class="font-medium">Email</label>
                <input type="email" class="w-full border p-3 rounded-lg mt-1" placeholder="john@example.com">
            </div>

            <div>
                <label class="font-medium">Phone Number</label>
                <input type="text" class="w-full border p-3 rounded-lg mt-1" placeholder="+44 7123 456789">
            </div>

            <div>
                <label class="font-medium">Date of Birth</label>
                <input type="date" class="w-full border p-3 rounded-lg mt-1">
            </div>

            <div>
                <label class="font-medium">Gender</label>
                <select class="w-full border p-3 rounded-lg mt-1">
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>

        </div>

        <!-- PASSPORT DETAILS -->
        <h2 class="text-xl font-semibold border-b pb-2 mt-6">Travel Documents</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="font-medium">Passport Number</label>
                <input type="text" class="w-full border p-3 rounded-lg mt-1" placeholder="123456789">
            </div>

            <div>
                <label class="font-medium">Nationality</label>
                <input type="text" class="w-full border p-3 rounded-lg mt-1" placeholder="United Kingdom">
            </div>

            <div>
                <label class="font-medium">Passport Expiry Date</label>
                <input type="date" class="w-full border p-3 rounded-lg mt-1">
            </div>

        </div>

        <!-- PREFERENCES -->
        <h2 class="text-xl font-semibold border-b pb-2 mt-6">Travel Preferences</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div>
                <label class="font-medium">Meal Preference</label>
                <select class="w-full border p-3 rounded-lg mt-1">
                    <option>Standard Meal</option>
                    <option>Vegetarian</option>
                    <option>Vegan</option>
                    <option>Halal Meal</option>
                    <option>Kids Meal</option>
                </select>
            </div>

            <div>
                <label class="font-medium">Seat Preference</label>
                <select class="w-full border p-3 rounded-lg mt-1">
                    <option>No Preference</option>
                    <option>Aisle Seat</option>
                    <option>Window Seat</option>
                    <option>Extra Legroom</option>
                </select>
            </div>
        </div>

        <!-- SAVE BUTTON -->
        <div class="flex justify-end pt-6">
            <button class="bg-blue-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-blue-700 btn-hover">
                Save Changes
            </button>
        </div>

    </div>

    <!-- FOOTER -->
    

  <?php include "footer.php"; ?>

</main>

<script src="include.js"></script>

</body>
</html>
