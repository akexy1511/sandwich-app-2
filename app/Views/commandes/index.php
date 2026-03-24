<?php require __DIR__ . '/../components/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Mes commandes</h1>
    <p class="page-sub">
        Semaine du 
        <?= date('d/m/Y', strtotime('monday this week')) ?> 
        au 
        <?= date('d/m/Y', strtotime('friday this week')) ?>
    </p>
</div>

<div class="orders-wrap">
    <div class="card">

        <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
            <span>Commandes de la semaine</span>
            /Créer une nouvelle commande</a>
        </div>

        <div style="overflow:auto;">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Sandwich</th>
                        <th>Crudités</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($commandes as $cmd): ?>
                    <?php
                        $nom = strtolower($cmd['nom']);
                        $img = $sandwiches[$nom]['image'] ?? 'https://via.placeholder.com/100?text=?';
                        $isEditable = \App\Models\Commande::isModifiable($cmd['date_de_commande']);
                    ?>

                    <tr>
                        <td>
                            <div class="order-name"><?= htmlspecialchars($cmd['jour']) ?></div>
                            <div class="order-day"><?= date('d/m/Y', strtotime($cmd['date_de_commande'])) ?></div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="<?= htmlspecialchars($img) ?>" class="sandwich-thumb">
                                <div>
                                    <div class="fw-bold"><?= htmlspecialchars($cmd['nom']) ?></div>
                                    <?php if (!empty($sandwiches[$nom]['price'])): ?>
                                        <small class="text-muted">Prix : <?= $sandwiches[$nom]['price'] ?> €</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>

                        <td><?= htmlspecialchars($cmd['crudites']) ?></td>

                        <td>
                            <?php if ($cmd['is_paid']): ?>
                                <span class="badge badge-success">Payée</span>
                            <?php else: ?>
                                <span class="badge badge-muted">En attente</span>
                            <?php endif; ?>
                        </td>

                        <td class="actions-cell">

                            <?php if ($isEditable): ?>
                                /crud.php?action=modifier&id_commande=<?= $cmd['id_commande'] ?>" class="btn btn-ghost btn-sm">Modifier</a>
                                <form action="/commandes/delete" method="POST" style="display:inline;">
                                    <input type="hidden" name="id_commande" value="<?= $cmd['id_commande'] ?>">
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette commande ?')">
                                        Supprimer
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="badge badge-muted">Verrouillée</span>
                            <?php endif; ?>

                            <?php if (!$cmd['is_paid']): ?>
                                /paiement/<?= $cmd['id_commande'] ?>" class="btn btn-success btn-sm">Payer</a>
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