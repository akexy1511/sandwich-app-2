<?php include 'includes/header.php'; ?>
<?php include 'includes/database.php'; ?>
<?php include 'includes/auth.php'; ?>

<?php
if (intval($_SESSION['role'] ?? 1) !== 0) {
    echo "<p>Accès refusé.</p>";
    include 'includes/footer.php';
    exit;
}

$sql = "
    SELECT c.*, u.login, u.email,
    CASE WHEN f.id_commande IS NOT NULL THEN 1 ELSE 0 END AS is_paid
    FROM commandes c
    JOIN utilisateur u ON c.id_utilisateur = u.id_utilisateur
    LEFT JOIN facturation f ON c.id_commande = f.id_commande
    ORDER BY c.date_de_commande ASC, c.jour ASC
";

$commandes = $conn->query($sql);
?>

<div class="page-header">
    <h1 class="page-title">Cuisine</h1>
    <p class="page-sub">Toutes les commandes et leurs propriétaires</p>
</div>

<div class="orders-wrap">
    <div class="card">
        <div class="card-body" style="overflow:auto;">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Jour</th>
                        <th>Date</th>
                        <th>Sandwich</th>
                        <th>Crudités</th>
                        <th>Payée ?</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($commandes && $commandes->num_rows > 0): ?>
                        <?php while ($c = $commandes->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($c['id_commande']) ?></td>
                                <td><?= htmlspecialchars($c['login'] ?: 'N/A') ?></td>
                                <td><?= htmlspecialchars($c['email']) ?></td>
                                <td><?= htmlspecialchars($c['jour']) ?></td>
                                <td><?= htmlspecialchars($c['date_de_commande']) ?></td>
                                <td><?= htmlspecialchars($c['nom']) ?></td>
                                <td><?= htmlspecialchars($c['crudites']) ?></td>
                                <td>
                                    <?php if ($c['is_paid']): ?>
                                        <span class="badge badge-success">Oui</span>
                                    <?php else: ?>
                                        <span class="badge badge-muted">Non</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align:center;">Aucune commande trouvée.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
