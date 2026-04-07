<?php
include 'includes/header.php';
include 'includes/database.php';
include 'includes/auth.php';
include 'includes/stripe_config.php';

if (!isset($_GET['session_id']) || !isset($_GET['order_id'])) {
    header("Location: commandes.php");
    exit;
}

$session_id = $_GET['session_id'];
$order_id = intval($_GET['order_id']);
$user_id = $_SESSION['user_id'];

require_once 'vendor/autoload.php';

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

try {
    // Récupérer la session de paiement Stripe
    $session = \Stripe\Checkout\Session::retrieve($session_id);

    // Vérifier que le paiement a réussi
    if ($session->payment_status === 'paid') {
        // Vérifier que la commande appartient à l'utilisateur
        $stmt = $conn->prepare("SELECT * FROM commandes WHERE id_commande = ? AND id_utilisateur = ?");
        $stmt->bind_param("ii", $order_id, $user_id);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();

        if ($order) {
            // Prix
            $data = json_decode(file_get_contents("sandwiches.json"), true);
            $key = strtolower($order['nom']);
            $amount = $data[$key]['price'] ?? 5;

            // Enregistrer transaction
            $stmt = $conn->prepare("
                INSERT INTO transaction (heure, montant, jour_, id_utilisateur)
                VALUES (?, ?, ?, ?)
            ");

            $heure = date("H:i:s");
            $jour_ = date("Y-m-d");

            $stmt->bind_param("sdsi", $heure, $amount, $jour_, $user_id);
            $stmt->execute();

            $transaction_id = $conn->insert_id;

            // Lier facturation
            $stmt = $conn->prepare("
                INSERT INTO facturation (id_commande, id_transaction)
                VALUES (?, ?)
            ");
            $stmt->bind_param("ii", $order_id, $transaction_id);
            $stmt->execute();

            $_SESSION['message'] = "Paiement Stripe effectué avec succès !";
        } else {
            $_SESSION['message'] = "Erreur : commande introuvable.";
        }
    } else {
        $_SESSION['message'] = "Le paiement n'a pas été complété.";
    }
} catch (Exception $e) {
    $_SESSION['message'] = "Erreur lors de la vérification du paiement: " . $e->getMessage();
}

header("Location: commandes.php");
exit;
?>