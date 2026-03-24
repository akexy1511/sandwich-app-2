<?php require __DIR__ . '/../components/header.php'; ?>

<div class="detail-wrap">

    <div class="detail-main">

        <h1 class="detail-title">Modifier la commande</h1>

        <form action="/commandes/update" method="POST">

            <input type="hidden" name="id_commande" value="<?= $commande['id_commande'] ?>">

            <div class="option-group">
                <div class="option-label">Sandwich</div>

                <select name="sandwich" class="form-control">
                    <?php foreach ($sandwiches as $key => $s): ?>
                        <option value="<?= ucfirst($key) ?>"
                            <?= ($commande['nom'] === ucfirst($key)) ? 'selected' : '' ?>>
                            <?= ucfirst($key) ?> — <?= $s['price'] ?> €
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="option-group">
                <div class="option-label">Crudités</div>

                <div class="radio-group">

                    <div class="radio-option">
                        <input type="radio" id="avec" name="crudites" value="avec"
                            <?= $commande['crudites'] === 'avec' ? 'checked' : '' ?>>
                        <label for="avec">🥗 Avec</label>
                    </div>

                    <div class="radio-option">
                        <input type="radio" id="sans" name="crudites" value="sans"
                            <?= $commande['crudites'] === 'sans' ? 'checked' : '' ?>>
                        <label for="sans">❌ Sans</label>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary" style="width:100%; margin-top:20px;">
                Enregistrer les modifications
            </button>

        </form>

        <button onclick="history.back()" class="btn btn-ghost" style="margin-top:12px; width:100%;">
            Annuler
        </button>

    </div>

</div>

<?php require __DIR__ . '/../components/footer.php'; ?>