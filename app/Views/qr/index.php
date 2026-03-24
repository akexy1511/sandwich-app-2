<?php require __DIR__ . '/../components/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">QR Code de la commande</h1>
    <p class="page-sub">Montrez ce QR à la cantine pour récupérer votre sandwich.</p>
</div>

<div class="orders-wrap">

    <div class="card">
        <div class="card-body" style="text-align:center;">

            <h3><?= htmlspecialchars($order['nom']) ?></h3>
            <p><strong>Pour le :</strong> <?= htmlspecialchars($order['jour']) ?></p>

            <img src="<?= $qr ?>" alt="QR Code" 
                 style="width:300px; margin:20px auto; display:block;">

            /commandes
                <button class="btn btn-secondary" style="margin-top:20px;">Retour</button>
            </a>
        </div>
    </div>

</div>

<?php require __DIR__ . '/../components/footer.php'; ?>