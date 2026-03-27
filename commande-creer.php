<?php
include 'includes/database.php';
include 'includes/auth.php';

$user_id = $_SESSION['user_id'];

$sandwich = trim($_POST['sandwich'] ?? "");
$crudites = ($_POST['crudites'] ?? "") === "sans" ? "sans" : "avec";
$jours = $_POST['jours'] ?? [];

if ($sandwich === "" || empty($jours)) {
    $_SESSION['message'] = "Veuillez sélectionner un sandwich et au moins un jour.";
    header("Location: index.php");
    exit;
}

$inserted = 0;
$skipped = 0;

$sql = "INSERT INTO commandes (jour, id_utilisateur, crudites, nom, date_de_commande)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

foreach ($jours as $val) {

    if (!str_contains($val, "\n")) {
        $skipped++;
        continue;
    }

    list($jour, $date_fr) = explode("\n", $val);

    $date_obj = DateTime::createFromFormat("d/m/Y", trim($date_fr));

    if (!$date_obj) {
        $skipped++;
        continue;
    }

    $date_sql = $date_obj->format("Y-m-d");

    try {
        $stmt->bind_param("sisss", $jour, $user_id, $crudites, $sandwich, $date_sql);
        $stmt->execute();
        $inserted++;
    } catch (Exception $e) {
        $skipped++;
    }
}

$_SESSION['message'] = "Commandes enregistrées: $inserted, ignorées: $skipped.";
header("Location: commandes.php");
exit;