<?php
include 'includes/header.php';
include 'includes/database.php';
include 'includes/auth.php';
include 'includes/stripe_config.php';

$message = "";
$redirect = true;

if (!isset($_GET['session_id']) || !isset($_GET['order_id'])) {
    $message = "Paramètres de paiement manquants.";
    $redirect = false;
} else {
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

                $message = "Paiement Stripe effectué avec succès ! Votre commande a été confirmée.";
            } else {
                $message = "Erreur : commande introuvable.";
            }
        } else {
            $message = "Le paiement n'a pas été complété.";
        }
    } catch (Exception $e) {
        $message = "Erreur lors de la vérification du paiement: " . $e->getMessage();
    }
}
?>

<div class="page-header">
    <h1 class="page-title">Paiement Terminé</h1>
    <p class="page-sub">Traitement de votre paiement</p>
</div>

<div class="orders-wrap">
    <div class="card">
        <div class="card-body text-center">
            <?php if ($message): ?>
                <div class="alert alert-<?= strpos($message, 'succès') !== false ? 'success' : 'danger' ?>">
                    <h4><?= strpos($message, 'succès') !== false ? '✓ Paiement Réussi' : '✗ Erreur de Paiement' ?></h4>
                    <p><?= $message ?></p>
                </div>

                <?php if ($redirect && strpos($message, 'succès') !== false): ?>
                    <p class="text-muted">Vous serez automatiquement redirigé vers vos commandes dans quelques secondes...</p>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" id="progressBar"></div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="mt-4">
                <a href="commandes.php" class="btn btn-primary">Voir mes commandes</a>
                <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</div>

<?php if ($redirect && strpos($message, 'succès') !== false): ?>
<script>
    let progress = 0;
    const progressBar = document.getElementById('progressBar');
    const interval = setInterval(() => {
        progress += 2;
        progressBar.style.width = progress + '%';
        if (progress >= 100) {
            clearInterval(interval);
            window.location.href = 'commandes.php';
        }
    }, 100);
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>