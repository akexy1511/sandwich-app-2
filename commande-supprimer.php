<?php
include 'includes/database.php';
include 'includes/auth.php';

if (!isset($_GET['id'])) {
    header("Location: commandes.php");
    exit;
}

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM commandes WHERE id_commande = ? AND id_utilisateur = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();

header("Location: commandes.php");
exit;
``