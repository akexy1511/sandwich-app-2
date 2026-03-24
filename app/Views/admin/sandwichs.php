<?php require __DIR__ . '/../components/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Gestion des sandwichs</h1>
    <p class="page-sub">Modifier les prix (données JSON)</p>
</div>

<div class="orders-wrap">

    <div class="card">
        <div class="card-body" style="overflow:auto;">

            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prix (€)</th>
                        <th>Modifier</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($sandwiches as $name => $s): ?>
                    <tr>
                        <td>
                            <strong><?= ucfirst($name) ?></strong><br>
                            <small><?= count($s['details_sandwich']) ?> ingrédients</small>
                        </td>

                        <td>
                            <?= htmlspecialchars($s['price']) ?> €
                        </td>

                        <td>
                            /admin/sandwichs/update" method="POST" class="d-flex" style="gap:6px;">
                                <input type="hidden" name="name" value="<?= htmlspecialchars($name) ?>">

                                <input type="number"
                                       step="0.01"
                                       min="0"
                                       name="price"
                                       value="<?= htmlspecialchars($s['price']) ?>"
                                       class="form-control"
                                       style="width:120px;">

                                <button class="btn btn-primary btn-sm">
                                    Enregistrer
                                </button>
                            </form>
                        </td>
                    </tr>

                <?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<?php require __DIR__ . '/../components/footer.php'; ?>