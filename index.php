<?php
include 'includes/header.php';
include 'includes/database.php';

// Charger sandwiches.json
$sandwiches = [];
if (file_exists("sandwiches.json")) {
    $sandwiches = json_decode(file_get_contents("sandwiches.json"), true);
}
?>

<!-- ===================== HERO ===================== -->

<div class="hero">
    <div class="hero-tag">Menu de la semaine</div>

    <h1 class="hero-title">Choisissez votre<br>sandwich du jour</h1>

    <p class="hero-sub">Commandez avant 11h20 pour être servi à midi.</p>

    <!-- Deux boutons -->
    <!--<div style="margin-top: 25px; display:flex; gap:15px;">

        <a href="login.php" class="btn btn-primary">
            Se connecter
        </a>

        <a href="signup.php" class="btn btn-secondary">
            Créer un compte
        </a>

    </div>-->
</div>

<!-- ===================== SECTION SANDWICHS ===================== -->

<div class="section">
    <div class="section-title">Nos sandwichs</div>

    <div class="sandwich-grid">

        <?php if (!empty($sandwiches)): ?>
            <?php foreach ($sandwiches as $name => $s): ?>

                <a href="sandwich.php?name=<?= urlencode($name) ?>" class="sandwich-card">

                    <div class="sandwich-card-emoji">🥖</div>

                    <div class="sandwich-card-name"><?= ucfirst($name) ?></div>

                    <div class="sandwich-card-price"><?= htmlspecialchars($s['price']) ?> €</div>

                    <div style="margin-top:var(--sp-sm); display:flex; gap:6px; flex-wrap:wrap;">
                        <?php foreach ($s['details_sandwich'] as $detail): ?>
                            <span class="badge badge-muted"><?= htmlspecialchars($detail) ?></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="sandwich-card-arrow">→</div>

                </a>

            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun sandwich disponible.</p>
        <?php endif; ?>

    </div>
</div>

<?php include 'includes/footer.php'; ?>