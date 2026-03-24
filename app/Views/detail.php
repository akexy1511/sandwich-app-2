<?php require __DIR__ . '/../components/header.php'; ?>

<div class="detail-wrap">

    <!-- Main -->
    <div class="detail-main">
        
        <span class="badge badge-brand" style="margin-bottom:8px;">
            Disponible cette semaine
        </span>

        <h1 class="detail-title"><?= htmlspecialchars($name) ?></h1>

        <p style="color:var(--c-text-muted); font-size:14px;">
            Découvrez notre sandwich <?= htmlspecialchars($name) ?> préparé avec soin.
        </p>

        <div class="detail-ingredients">
            <?php foreach ($sandwich['details_sandwich'] as $ing): ?>
                <span class="ingredient-chip"><?= htmlspecialchars($ing) ?></span>
            <?php endforeach; ?>
        </div>

        <form method="POST" action="/commandes/create">

            <input type="hidden" name="sandwich" value="<?= htmlspecialchars($name) ?>">

            <!-- CRUDITES -->
            <div class="option-group">
                <div class="option-label">Crudités</div>

                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" id="avec" name="crudites" value="avec" checked>
                        <label for="avec">🥗 Avec</label>
                    </div>

                    <div class="radio-option">
                        <input type="radio" id="sans" name="crudites" value="sans">
                        <label for="sans">❌ Sans</label>
                    </div>
                </div>
            </div>

            <!-- DAYS -->
            <div class="option-group">
                <div class="option-label">Jours de commande</div>

                <div class="days-grid">

                    <?php foreach ($days as $d): ?>
                    <div class="day-option">
                        <input type="checkbox"
                               id="<?= strtolower($d['label']) ?>"
                               name="jours[]"
                               value="<?= $d['label'] . "\n" . $d['date'] ?>"
                               <?= $d['disabled'] ? 'disabled' : '' ?>
                        >
                        <label for="<?= strtolower($d['label']) ?>">
                            <div>
                                <div class="day-name"><?= $d['label'] ?></div>
                                <div class="day-date"><?= $d['date'] ?></div>
                            </div>
                            <span style="font-size:18px; color:var(--c-border)">○</span>
                        </label>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- Submit -->
            <button class="btn btn-primary" style="width:100%; margin-top:20px;">
                Confirmer la commande
            </button>

        </form>

        <button onclick="history.back()" 
                class="btn btn-ghost" 
                style="margin-top:12px; width:100%;">
            Annuler
        </button>

    </div>

    <!-- Summary -->
    <div class="order-summary">
        <div class="card">

            <div class="card-header">Récapitulatif</div>

            <div class="card-body">

                <div class="summary-price">
                    <?= $sandwich['price'] ?> €
                </div>

                <div class="summary-row">
                    <span class="summary-row-label">Sandwich</span>
                    <span class="summary-row-value"><?= htmlspecialchars($name) ?></span>
                </div>

                <div class="summary-row">
                    <span class="summary-row-label">Crudités</span>
                    <span class="summary-row-value" id="crudites-summary">Avec</span>
                </div>

                <div class="summary-row">
                    <span class="summary-row-label">Jours</span>
                    <span class="summary-row-value" id="days-summary">Aucun</span>
                </div>

            </div>

        </div>
    </div>

</div>

<script>
// recap crudites
document.querySelectorAll('input[name="crudites"]').forEach(r => {
    r.addEventListener('change', () => {
        document.getElementById('crudites-summary').textContent =
            document.querySelector('input[name="crudites"]:checked').value === 'avec'
                ? 'Avec' : 'Sans';
    });
});

// recap jours
document.querySelectorAll('input[name="jours[]"]').forEach(cb => {
    cb.addEventListener('change', () => {
        const checked = [...document.querySelectorAll('input[name="jours[]"]:checked')]
                        .map(c => c.value.split("\n")[0]);

        document.getElementById('days-summary').textContent =
            checked.length ? checked.join(', ') : 'Aucun';

        const icon = cb.closest('.day-option').querySelector('span:last-child');
        if (cb.checked) {
            icon.textContent = '✓';
            icon.style.color = 'var(--c-accent)';
        } else {
            icon.textContent = '○';
            icon.style.color = 'var(--c-border)';
        }
    });
});
</script>

<?php require __DIR__ . '/../components/footer.php'; ?>