<?php include 'includes/header.php'; ?>
<?php include 'includes/database.php'; ?>
<?php include 'includes/auth.php'; ?>

<?php
require_once __DIR__ . "/vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$user_id = $_SESSION['user_id'];
$today = date("Y-m-d");

// Récup commande du jour
$stmt = $conn->prepare("
    SELECT nom, jour
    FROM commandes
    WHERE id_utilisateur = ?
    AND date_de_commande = ?
    LIMIT 1
");

$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo "<p>Aucune commande aujourd'hui.</p>";
    include 'includes/footer.php';
    exit;
}

$content = "Commande : {$order['nom']} ({$order['jour']})";

$qr = QrCode::create($content)->setSize(300);
$writer = new PngWriter();
$result = $writer->write($qr);

$temp = "qr.png";
$result->saveToFile($temp);
?>

<div class="page-header">
    <h1 class="page-title">QR Code</h1>
</div>

<div style="text-align:center; padding:20px;">
    <p><?= htmlspecialchars($content) ?></p>

    <img src="qr.png" alt="QR Code">

    commandes.php
        <button class="btn btn-secondary" style="margin-top:20px;">Retour</button>
    </a>
</div>

<?php include 'includes/footer.php'; ?>
``