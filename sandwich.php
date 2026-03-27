<?php include 'includes/header.php'; ?>
<?php include 'includes/database.php'; ?>
<?php include 'includes/auth.php'; ?>

<?php
// Vérifier paramètre
if (!isset($_GET['name'])) {
    header("Location: index.php");
    exit;
}

$name = strtolower($_GET['name']);

// Charger JSON
$sandwiches = json_decode(file_get_contents("sandwiches.json"), true);

if (!isset($sandwiches[$name])) {
    echo "<p style='padding:20px;'>Sandwich introuvable.</p>";
    include 'includes/footer.php';
    exit;
}

$sandwich = $sandwiches[$name];

// Gestion des jours disponibles
$joursSem = ["Lundi", "Mardi", "Jeudi", "Vendredi"];
$aujourdhui = new DateTime();
$limit_heure = new DateTime("11:20");

$nextWeekMode = false;
$weekday = (int)$aujourdhui->format("N");

// Semaine suivante => vendredi >= 16h ou samedi/dimanche
if (($weekday == 5 && $aujourdhui >= new DateTime("today 16:00")) || $weekday >= 6) {
    $nextWeekMode = true;
}

$liste_jours = [];

foreach ($joursSem as $jNom) {
    $d = clone $aujourdhui;

    if ($nextWeekMode) {
        $d->modify("next week $jNom");
        $disabled = false;
    } else {
        $d->modify("this week $jNom");

        $disabled = ($d < $aujourdhui ||
                    ($d->format("Y-m-d") == $aujourdhui->format("Y-m-d") && $aujourdhui > $limit_heure));
    }

    $liste_jours[] = [
        "label" => $jNom,
        "date"  => $d->format("d/m/Y"),
        "disabled" => $disabled
    ];
}
?>

<div class="detail-wrap">

    <div class="detail-main">

        <h1 class="detail-title"><?= ucfirst($name) ?></h1>

        <p style="color:var(--c-text-muted); font-size:14px;">
            Choisissez vos options et vos jours de commande
        </p>

        <div class="detail-ingredients">
            <?php foreach ($sandwich['details_sandwich'] as $ing): ?>
                <span class="ingredient-chip"><?= htmlspecialchars($ing) ?></span>
            <?php endforeach; ?>
        </div>

        /commande-creer.php" method="POST">

            <input type="hidden" name="sandwich" value="<?= ucfirst($name) ?>">

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

            <div class="option-group">
                <div class="option-label">Jours de commande</div>

                <div class="days-grid">

                    <?php foreach ($liste_jours as $j): ?>
                        <div class="day-option">
                            <input type="checkbox"
                                id="<?= strtolower($j['label']) ?>"
                                name="jours[]"
                                value="<?= $j['label'] . "\n" . $j['date'] ?>"
                                <?= $j['disabled'] ? 'disabled' : '' ?>>

                            <label for="<?= strtolower($j['label']) ?>">
                                <div>
                                    <div class="day-name"><?= $j['label'] ?></div>
                                    <div class="day-date"><?= $j['date'] ?></div>
                                </div>
                                <span style="font-size:18px; color:var(--c-border);">○</span>
                            </label>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

            <button class="btn btn-primary" style="width:100%; margin-top:20px;">
                Commander
            </button>

        </form>

        commandes.php
            <button class="btn btn-ghost" style="width:100%; margin-top:12px;">Annuler</button>
        </a>

    </div>

</div>

<?php include 'includes/footer.php'; ?>