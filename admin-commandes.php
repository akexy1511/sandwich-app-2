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
    SELECT c.*, u.login,
    CASE WHEN f.id_commande IS NOT NULL THEN 1 ELSE 0 END AS is_paid
    FROM commandes c
    JOIN utilisateur u ON c.id_utilisateur = u.id_utilisateur
    LEFT JOIN facturation f ON c.id_commande = f.id_commande
    ORDER BY date_de_commande DESC
";

$commandes = $conn->query($sql);
?>

<div class="page-header">
    <h1 class="page-title">Toutes les commandes</h1>
</div>

<div class="orders-wrap">
    <div class="card">
        <div class="card-body" style="overflow:auto;">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Utilisateur</th>
                        <th>Jour</th>
                        <th>Date</th>
                        <th>Sandwich</th>
                        <th>Crudités</th>
                        <th>Payée ?</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($c = $commandes->fetch_assoc()): ?>
                        <tr>
                            <td><?= $c['id_commande'] ?></td>
                            <td><?= $c['login'] ?></td>
                            <td><?= $c['jour'] ?></td>
                            <td><?= $c['date_de_commande'] ?></td>
                            <td><?= $c['nom'] ?></td>
                            <td><?= $c['crudites'] ?></td>
                            <td>
                                <?= $c['is_paid'] ? "<span class='badge badge-success'>Oui</span>" : "<span class='badge badge-muted'>Non</span>" ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
