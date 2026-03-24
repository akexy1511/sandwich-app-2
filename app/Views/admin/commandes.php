<?php require __DIR__ . '/../components/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Toutes les commandes</h1>
    <p class="page-sub">Vue administrateur</p>
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
                        <th>Payé</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($commandes as $c): ?>
                        <tr>

                            <td><?= $c['id_commande'] ?></td>

                            <td>
                                <strong><?= htmlspecialchars($c['login']) ?></strong><br>
                                <small><?= htmlspecialchars($c['id_utilisateur']) ?></small>
                            </td>

                            <td><?= htmlspecialchars($c['jour']) ?></td>

                            <td><?= date('d/m/Y', strtotime($c['date_de_commande'])) ?></td>

                            <td><?= htmlspecialchars($c['nom']) ?></td>

                            <td><?= htmlspecialchars($c['crudites']) ?></td>

                            <td>
                                <?php if ($c['is_paid']): ?>
                                    <span class="badge badge-success">Payée</span>
                                <?php else: ?>
                                    <span class="badge badge-muted">En attente</span>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<?php require __DIR__ . '/../components/footer.php'; ?>