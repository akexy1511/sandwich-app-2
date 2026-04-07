<?php include 'includes/header.php'; ?>
<?php include 'includes/database.php'; ?>
<?php include 'includes/auth.php'; ?>
<?php include 'includes/stripe_config.php'; ?>

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

// Si paiement Stripe sélectionné, créer session Stripe Checkout
if (isset($_POST['payment_method']) && $_POST['payment_method'] === 'Stripe') {
    require_once 'vendor/autoload.php';

    \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

    try {
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Sandwich ' . $order['nom'],
                        'description' => 'Commande du ' . $order['jour'] . ' - Crudités: ' . $order['crudites'],
                    ],
                    'unit_amount' => intval($price * 100), // Montant en centimes
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => STRIPE_SUCCESS_URL . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $id,
            'cancel_url' => STRIPE_CANCEL_URL . '?id=' . $id,
            'metadata' => [
                'order_id' => $id,
                'user_id' => $user_id,
            ],
        ]);

        header("Location: " . $checkout_session->url);
        exit;
    } catch (Exception $e) {
        $_SESSION['message'] = "Erreur lors de la création du paiement: " . $e->getMessage();
        header("Location: paiement.php?id=" . $id);
        exit;
    }
} elseif (isset($_POST['payment_method']) && $_POST['payment_method'] !== 'Stripe') {
    // Pour les autres méthodes de paiement, rediriger vers paiement-process.php
    header("Location: paiement-process.php");
    exit;
}
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

    <form id="paymentForm" action="paiement.php?id=<?= $id ?>" method="POST">

        <input type="hidden" name="id_commande" value="<?= $id ?>">

        <div class="form-group">
            <label class="form-label">Méthode de paiement</label>
            <select class="form-control" name="payment_method" id="pmethod" required>
                <option value="">Sélectionnez...</option>
                <option value="Paypal">PayPal</option>
                <option value="Cash">Espèces</option>
                <option value="Stripe">Carte bancaire (Stripe)</option>
            </select>
        </div>

        <div id="cardzone" style="display:none;">
            <div class="alert alert-info">
                <p>Vous allez être redirigé vers Stripe pour effectuer le paiement en toute sécurité.</p>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top:20px; width:100%;">Procéder au paiement</button>
    </form>

</div>

<script>
document.getElementById('pmethod').addEventListener('change', function() {
    document.getElementById('cardzone').style.display =
        this.value === 'Stripe' ? 'block' : 'none';
});
</script>

<?php include 'includes/footer.php'; ?>
