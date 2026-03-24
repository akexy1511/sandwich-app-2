<?php require __DIR__ . '/../components/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Paiement de la commande</h1>
    <p class="page-sub">Veuillez choisir un mode de paiement</p>
</div>

<div class="orders-wrap">

    <div class="card">
        <div class="card-body">

            <h3 class="card-title">Détails commande</h3>

            <p><strong>Jour :</strong> <?= htmlspecialchars($order['jour']) ?></p>
            <p><strong>Sandwich :</strong> <?= htmlspecialchars($order['nom']) ?></p>
            <p><strong>Crudités :</strong> <?= htmlspecialchars($order['crudites']) ?></p>
            <p><strong>Prix :</strong> <?= $price ?> €</p>

        </div>
    </div>

    <form action="/paiement/process" method="post" class="card" style="margin-top:20px; padding:20px;">

        <input type="hidden" name="order_id" value="<?= $order['id_commande'] ?>">

        <div class="form-group">
            <label class="form-label">Méthode de paiement</label>
            <select class="form-control" name="payment_method" id="pmethod" required>
                <option value="">Sélectionnez...</option>
                <option value="card">Carte de crédit</option>
                <option value="paypal">PayPal</option>
                <option value="cash">Espèces à la livraison</option>
                <option value="bank">Virement bancaire</option>
            </select>
        </div>

        <!-- Bloc pour CB -->
        <div id="cardzone" style="display:none; margin-top:20px;">
            <h4>Détails carte</h4>

            <div class="form-group">
                <label class="form-label">Numéro de carte</label>
                <input type="text" class="form-control" name="card_number">
            </div>

            <div class="form-group" style="display:flex; gap:10px;">
                <div style="flex:1;">
                    <label class="form-label">Expiration</label>
                    <input type="text" class="form-control" name="expiry_date" placeholder="MM/YY">
                </div>
                <div style="flex:1;">
                    <label class="form-label">CVV</label>
                    <input type="text" class="form-control" name="cvv">
                </div>
            </div>
        </div>

        <button class="btn btn-primary" style="width:100%; margin-top:20px;">
            Payer maintenant
        </button>

    </form>

</div>

<script>
document.getElementById('pmethod').addEventListener('change', function() {
    document.getElementById('cardzone').style.display =
        this.value === 'card' ? 'block' : 'none';
});
</script>

<?php require __DIR__ . '/../components/footer.php'; ?>