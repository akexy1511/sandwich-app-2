<?php include 'includes/header.php'; ?>
<?php include 'includes/database.php'; ?>
<?php include 'includes/auth.php'; ?>

<?php
if ($_SESSION['email'] !== "admin@cepes.be") {
    echo "<p>Accès refusé.</p>";
    include 'includes/footer.php';
    exit;
}

$stats_users = $conn->query("SELECT COUNT(*) AS total FROM utilisateur")->fetch_assoc()['total'];
$stats_cmd = $conn->query("SELECT COUNT(*) AS total FROM commandes")->fetch_assoc()['total'];
$stats_rev = $conn->query("SELECT SUM(montant) AS total FROM transaction")->fetch_assoc()['total'] ?? 0;
?>

<div class="page-header">
    <h1 class="page-title">Administration</h1>
</div>

<div class="orders-wrap">

    <div class="card">
        <div class="card-body">

            <h3>Statistiques</h3>

            <p><strong>Utilisateurs :</strong> <?= $stats_users ?></p>
            <p><strong>Commandes :</strong> <?= $stats_cmd ?></p>
            <p><strong>Revenus :</strong> <?= number_format($stats_rev, 2) ?> €</p>

            admin-commandes.php>Gérer commandes</a><br><br>
            admin-users.php>Gérer utilisateurs</a><br><br>
            admin-sandwichs.php>Gérer sandwichs</a>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>