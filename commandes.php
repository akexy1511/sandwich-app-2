<?php include 'includes/header.php'; ?>
<?php include 'includes/database.php'; ?>
<?php include 'includes/auth.php'; ?>

<?php
$user_id = $_SESSION['user_id'];

$sql = "
    SELECT c.*, 
    CASE WHEN f.id_commande IS NOT NULL THEN 1 ELSE 0 END AS is_paid
    FROM commandes c
    LEFT JOIN facturation f ON c.id_commande = f.id_commande
    WHERE c.id_utilisateur = ?
    ORDER BY c.date_de_commande ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$commandes = $stmt->get_result();
?>

<div class="page-header">
    <h1 class="page-title">Mes commandes</h1>
    <p class="page-sub">Semaine actuelle / suivante</p>
</div>

<div class="orders-wrap">

    <div class="card">
        <div class="card-header">
            Mes commandes
        </div>

        <div class="card-body" style="overflow:auto;">

            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Sandwich</th>
                        <th>Crudités</th>
                        <th>Payé ?</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php while ($c = $commandes->fetch_assoc()): ?>
                    <tr>

                        <td>
                            <div class="order-name"><?= htmlspecialchars($c['jour']) ?></div>
                            <div class="order-day"><?= date('d/m/Y', strtotime($c['date_de_commande'])) ?></div>
                        </td>

                        <td><strong><?= htmlspecialchars($c['nom']) ?></strong></td>

                        <td><?= htmlspecialchars($c['crudites']) ?></td>

                        <td>
                            <?php if ($c['is_paid']): ?>
                                <span class="badge badge-success">Payée</span>
                            <?php else: ?>
                                <span class="badge badge-muted">Non payée</span>
                            <?php endif; ?>
                        </td>

                        <td class="actions-cell">

                            commande-modifier.php?id=<?= $c['id_commande'] ?>" class="btn btn-ghost btn-sm">Modifier</a>

                            commande-supprimer.php?id=<?= $c['id_commande'] ?>"
                               onclick="return confirm('Supprimer cette commande ?');"
                               class="btn btn-danger btn-sm">Supprimer</a>

                            <?php if (!$c['is_paid']): ?>
                                paiement.php?id=<?= $c['id_commande'] ?>" class="btn btn-success btn-sm">Payer</a>
                            <?php endif; ?>

                        </td>

                    </tr>
                <?php endwhile; ?>

                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>