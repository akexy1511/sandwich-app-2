<?php require __DIR__.'/../components/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Tableau de bord Admin</h1>
</div>

<div class="orders-wrap">

    <div class="card">
        <div class="card-body">

            <h3>Statistiques globales</h3>

            <div class="summary-row">
                <span>Total utilisateurs</span>
                <span><?= $stats['total_users'] ?></span>
            </div>

            <div class="summary-row">
                <span>Total commandes</span>
                <span><?= $stats['total_commandes'] ?></span>
            </div>

            <div class="summary-row">
                <span>Revenus totaux</span>
                <span><?= number_format($stats['revenus'], 2) ?> €</span>
            </div>

        </div>
    </div>

</div>

<?php require __DIR__.'/../components/footer.php'; ?>