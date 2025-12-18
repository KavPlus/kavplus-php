<?php
// config.php
define('APP_NAME', 'KavPlus Travel');
define('CURRENCY', 'GBP');
define('CURRENCY_SYMBOL', '£');

// Admin login (change this)
define('ADMIN_USERNAME', 'admin');
// Password: change-me-123
define('ADMIN_PASSWORD_HASH', password_hash('change-me-123', PASSWORD_DEFAULT));

// Stripe (optional)
define('STRIPE_PUBLISHABLE_KEY', ''); // pk_live_xxx or pk_test_xxx
define('STRIPE_SECRET_KEY', '');      // sk_live_xxx or sk_test_xxx

// Razorpay (optional)
define('RAZORPAY_KEY_ID', '');        // rzp_live_xxx or rzp_test_xxx
define('RAZORPAY_KEY_SECRET', '');    // secret
