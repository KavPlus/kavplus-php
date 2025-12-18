<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password – KavPlus Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- TailwindCSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Animations + UI Enhancements -->
<link rel="stylesheet" href="styles.css">

</head>

<body class="bg-gray-100 page-fade">

<!-- AUTH PAGE (NO SIDEBAR/HEADER) -->

<div class="flex items-center justify-center min-h-screen">

    <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-xl card-hover">

        <h1 class="text-3xl font-bold text-center">Forgot Password?</h1>
        <p class="text-gray-600 text-center mt-2">
            Enter your email and we’ll send you a reset link.
        </p>

        <!-- FORM -->
        <form class="space-y-5 mt-8" onsubmit="showMessage(event)">

            <div>
                <label class="font-medium">Email Address</label>
                <input type="email" class="w-full border p-3 rounded-lg mt-1"
                       placeholder="you@example.com" required>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 btn-hover">
                Send Reset Link
            </button>

        </form>

        <!-- STATUS MESSAGE (Hidden until submitted) -->
        <div id="successBox"
             class="mt-5 hidden bg-green-100 text-green-800 p-4 rounded-lg text-center shadow">
            Password reset link has been sent ✔  
        </div>

        <!-- BACK LINKS -->
        <p class="text-center text-gray-600 mt-6">
            Remember your password?
            <a href="login.php" class="text-blue-600 font-medium hover:underline">Login</a>
        </p>

        <p class="text-center text-gray-600 mt-2">
            Need an account?
            <a href="register.php" class="text-blue-600 font-medium hover:underline">Register</a>
        </p>

    </div>
</div>

<script>
function showMessage(e) {
    e.preventDefault();
    document.getElementById("successBox").classList.remove("hidden");
}
</script>

</body>
</html>
