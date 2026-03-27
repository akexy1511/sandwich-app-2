<?php
include 'includes/database.php';
include 'includes/auth.php';

$cmd = intval($_POST['id_commande']);
$user_id = $_SESSION['user_id'];
$method = $_POST['payment_method'] ?? "";

// Vérifier commande
$stmt = $conn->prepare("SELECT * FROM commandes WHERE id_commande = ? AND id_utilisateur = ?");
$stmt->bind_param("ii", $cmd, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    header("Location: commandes.php");
    exit;
}

// Prix
$data = json_decode(file_get_contents("sandwiches.json"), true);
$key = strtolower($order['nom']);
$amount = $data[$key]['price'] ?? 5;

// Vérification CB
if ($method === "card") {
    if (empty($_POST['card_number']) || empty($_POST['expiry_date']) || empty($_POST['cvv'])) {
        $_SESSION['message'] = "Détails de carte incomplets.";
        header("Location: paiement.php?id=" . $cmd);
        exit;
    }
}

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
$stmt->bind_param("ii", $cmd, $transaction_id);
$stmt->execute();

$_SESSION['message'] = "Paiement effectué.";
header("Location: commandes.php");
exit;