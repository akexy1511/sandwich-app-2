<?php include 'includes/header.php'; ?>
<?php include 'includes/database.php'; ?>
<?php include 'includes/auth.php'; ?>

<?php
if (!isset($_GET['id'])) {
    header("Location: commandes.php");
    exit;
}

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Charger commande
$stmt = $conn->prepare("SELECT * FROM commandes WHERE id_commande = ? AND id_utilisateur = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo "<p>Commande introuvable.</p>";
    include 'includes/footer.php';
    exit;
}

// Charger JSON pour le prix
$data = json_decode(file_get_contents("sandwiches.json"), true);
$key = strtolower($order['nom']);
$price = $data[$key]['price'] ?? 5.0;
?>

<div class="page-header">
    <h1 class="page-title">Paiement</h1>
    <p class="page-sub">Finaliser votre commande</p>
</div>

<div class="orders-wrap">

    <div class="card">
        <div class="card-body">
            <p><strong>Sandwich :</strong> <?= $order['nom'] ?></p>
            <p><strong>Jour :</strong> <?= $order['jour'] ?></p>
            <p><strong>Crudités :</strong> <?= $order['crudites'] ?></p>
            <p><strong>Prix :</strong> <?= $price ?> €</p>
        </div>
    </div>

    <form action="paiement-process.php" method="POST">

        <input type="hidden" name="id_commande" value="<?= $id ?>">

        <div class="form-group">
            <label class="form-label">Méthode de paiement</label>
            <select class="form-control" name="payment_method" id="pmethod" required>
                <option value="">Sélectionnez...</option>
                <option value="card">Carte</option>
                <option value="paypal">PayPal</option>
                <option value="cash">Espèces</option>
                <option value="bank">Virement</option>
            </select>
        </div>

        <div id="cardzone" style="display:none;">
            <h4>Détails carte :</h4>

            <div class="form-group">
                <label>Numéro</label>
                <input type="text" class="form-control" name="card_number">
            </div>

            <div class="form-group">
                <label>Expiration</label>
                <input type="text" class="form-control" name="expiry_date" placeholder="MM/YY">
            </div>

            <div class="form-group">
                <label>CVV</label>
                <input type="text" class="form-control" name="cvv">
            </div>
        </div>

        <button class="btn btn-primary" style="margin-top:20px; width:100%;">Payer</button>
    </form>

</div>

<script>
document.getElementById('pmethod').addEventListener('change', function() {
    document.getElementById('cardzone').style.display =
        this.value === 'card' ? 'block' : 'none';
});
</script>

<?php include 'includes/footer.php'; ?>
