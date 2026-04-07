<?php
// Script de test pour vérifier la configuration Stripe
require_once 'includes/stripe_config.php';
require_once 'vendor/autoload.php';

echo "=== Test de configuration Stripe ===\n\n";

echo "Clé publique: " . STRIPE_PUBLISHABLE_KEY . "\n";
echo "Clé secrète: " . substr(STRIPE_SECRET_KEY, 0, 15) . "...\n";
echo "Mode: " . STRIPE_MODE . "\n";
echo "URL succès: " . STRIPE_SUCCESS_URL . "\n";
echo "URL annulation: " . STRIPE_CANCEL_URL . "\n\n";

if (STRIPE_SECRET_KEY === 'sk_test_your_secret_key_here') {
    echo "❌ ERREUR: La clé secrète Stripe n'est pas configurée!\n";
    echo "Modifiez includes/stripe_config.php avec vos vraies clés.\n\n";
    exit(1);
}

try {
    \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

    // Test simple de connexion à l'API Stripe
    $balance = \Stripe\Balance::retrieve();
    echo "✅ Connexion Stripe réussie!\n";
    echo "Solde disponible: " . ($balance->available[0]->amount / 100) . " " . strtoupper($balance->available[0]->currency) . "\n";

} catch (Exception $e) {
    echo "❌ ERREUR de connexion Stripe: " . $e->getMessage() . "\n";
    echo "Vérifiez que vos clés API sont correctes.\n";
}

echo "\n=== Fin du test ===\n";
?>