<?php
// Configuration Stripe
// Remplacez ces valeurs par vos vraies clés Stripe
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_your_publishable_key_here');
define('STRIPE_SECRET_KEY', 'sk_test_your_secret_key_here');

// URL de succès et d'annulation pour Stripe Checkout
define('STRIPE_SUCCESS_URL', 'http://localhost/sandwich-app-2/paiement-success.php');
define('STRIPE_CANCEL_URL', 'http://localhost/sandwich-app-2/paiement.php');

// Mode test/production
define('STRIPE_MODE', 'test'); // 'test' ou 'live'
?>