<?php
include 'includes/database.php';
include 'includes/auth.php';

$user_id = $_SESSION['user_id'];

$sandwich = trim($_POST['sandwich'] ?? "");
$crudites = ($_POST['crudites'] ?? "") === "sans" ? "sans" : "avec";
$jours = $_POST['jours'] ?? [];

// Débogage
error_log("Sandwich: $sandwich");
error_log("Crudites: $crudites");
error_log("Jours reçus: " . json_encode($jours));

if ($sandwich === "" || empty($jours)) {
    $_SESSION['message'] = "Veuillez sélectionner un sandwich et au moins un jour.";
    header("Location: sandwich.php?name=" . strtolower($sandwich));
    exit;
}

$inserted = 0;
$skipped = 0;

$sql = "INSERT INTO commandes (jour, id_utilisateur, crudites, nom, date_de_commande)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    error_log("Erreur de préparation de la requête: " . $conn->error);
    $_SESSION['message'] = "Erreur de base de données.";
    header("Location: index.php");
    exit;
}

foreach ($jours as $val) {
    error_log("Traitement de la valeur: " . var_export($val, true));
    
    // Gérer les deux formats possibles: avec \n réel ou avec espace
    $parts = preg_split('/[\n\r\s]+/', trim($val), 2);
    
    if (count($parts) < 2) {
        error_log("Format invalide pour: $val");
        $skipped++;
        continue;
    }

    $jour = trim($parts[0]);
    $date_fr = trim($parts[1]);

    error_log("Jour: $jour, Date: $date_fr");

    $date_obj = DateTime::createFromFormat("d/m/Y", $date_fr);

    if (!$date_obj) {
        error_log("Format de date invalide: $date_fr");
        $skipped++;
        continue;
    }

    $date_sql = $date_obj->format("Y-m-d");

    if (!$stmt->bind_param("sisss", $jour, $user_id, $crudites, $sandwich, $date_sql)) {
        error_log("Erreur bind_param: " . $stmt->error);
        $skipped++;
        continue;
    }

    if (!$stmt->execute()) {
        error_log("Erreur execute: " . $stmt->error);
        $skipped++;
        continue;
    }

    $inserted++;
}

$stmt->close();

$_SESSION['message'] = "Commandes enregistrées: $inserted, ignorées: $skipped.";
header("Location: commandes.php");
exit;