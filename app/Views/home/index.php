<?php require __DIR__ . '/../components/header.php'; ?>

<div class="hero">
    <div class="hero-tag">Menu de la semaine</div>

    <h1 class="hero-title">Choisissez votre<br>sandwich du jour</h1>

    <p class="hero-sub">Commandez avant 11h20 pour être servi à midi.</p>
</div>

<div class="section">
    <div class="section-title">Nos sandwichs</div>

    <div class="sandwich-grid">

        <?php foreach ($sandwiches as $name => $s): ?>
        <a class="sandwich-card" href="/sandwich/<?= urlencode($name) ?>">

            <div class="sandwich-card-emoji">🥖</div>

            <div class="sandwich-card-name"><?= ucfirst($name) ?></div>

            <div class="sandwich-card-price"><?= $s['price'] ?> €</div>

            <div style="margin-top:var(--sp-sm); display:flex; gap:4px; flex-wrap:wrap;">
                <?php foreach ($s['details_sandwich'] as $detail): ?>
                    <span class="badge badge-muted"><?= htmlspecialchars($detail) ?></span>
                <?php endforeach; ?>
            </div>

            <div class="sandwich-card-arrow">→</div>
        </a>
        <?php endforeach; ?>

        <!-- Carte “Sandwich du mois” -->
        <div class="sandwich-card" style="border-style:dashed; background:var(--c-bg-subtle);">
            <div class="sandwich-card-emoji">⭐</div>
            <div class="sandwich-card-name">Sandwich du mois</div>
            <div style="color:var(--c-text-light); font-size:13px; margin-top:4px;">Bientôt disponible</div>
            <div class="sandwich-card-arrow">→</div>
        </div>

    </div>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>