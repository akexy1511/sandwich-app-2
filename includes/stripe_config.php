<?php
// Configuration Stripe
// Remplacez ces valeurs par vos vraies clés Stripe
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_VOTRE_CLE_PUBLIQUE_ICI');
define('STRIPE_SECRET_KEY', 'sk_test_VOTRE_CLE_SECRETE_ICI');

// URL de succès et d'annulation pour Stripe Checkout
// SOLUTION SIMPLE: Utilisez une URL temporaire pour les tests
define('STRIPE_SUCCESS_URL', 'http://localhost/sandwich-app-2/paiement-success.php');
define('STRIPE_CANCEL_URL', 'http://localhost/sandwich-app-2/paiement.php');

// Mode test/production
define('STRIPE_MODE', 'test'); // 'test' ou 'live'
?>