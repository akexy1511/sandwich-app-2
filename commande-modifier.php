<?php include 'includes/header.php'; ?>
<?php include 'includes/database.php'; ?>
<?php include 'includes/auth.php'; ?>

<?php
if (!isset($_GET['id'])) {
    header("Location: commandes.php");
    exit;
}

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $new_sandwich = trim($_POST['sandwich']);
    $new_crudites = $_POST['crudites'] === "sans" ? "sans" : "avec";

    $stmt = $conn->prepare("
        UPDATE commandes 
        SET nom = ?, crudites = ?
        WHERE id_commande = ? AND id_utilisateur = ?
    ");

    $stmt->bind_param("ssii", $new_sandwich, $new_crudites, $id, $user_id);
    $stmt->execute();

    header("Location: commandes.php");
    exit;
}
``

// Récupération commande
$stmt = $conn->prepare("SELECT * FROM commandes WHERE id_commande = ? AND id_utilisateur = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$commande = $stmt->get_result()->fetch_assoc();

if (!$commande) {
    echo "<p>Commande introuvable.</p>";
    include 'includes/footer.php';
    exit;
}

// Charger sandwiches.json
$sandwiches = json_decode(file_get_contents("sandwiches.json"), true);
?>

<div class="page-header">
    <h1 class="page-title">Modifier la commande</h1>
</div>

<div class="detail-wrap">
    <div class="detail-main">

        commande-modifier.php?id=<?= $id ?>" method="POST">

            <div class="option-group">
                <div class="option-label">Sandwich</div>

                <select name="sandwich" class="form-control">
                    <?php foreach ($sandwiches as $name => $s): ?>
                        <option value="<?= ucfirst($name) ?>"
                            <?= ($commande['nom'] == ucfirst($name)) ? "selected" : "" ?>>
                            <?= ucfirst($name) ?> — <?= $s['price'] ?> €
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="option-group">
                <div class="option-label">Crudités</div>
                <div class="radio-group">

                    <div class="radio-option">
                        <input type="radio" name="crudites" id="avec" value="avec"
                            <?= $commande['crudites'] === "avec" ? "checked" : "" ?>>
                        <label for="avec">🥗 Avec</label>
                    </div>

                    <div class="radio-option">
                        <input type="radio" name="crudites" id="sans" value="sans"
                            <?= $commande['crudites'] === "sans" ? "checked" : "" ?>>
                        <label for="sans">❌ Sans</label>
                    </div>

                </div>
            </div>

            <button class="btn btn-primary" style="width:100%;">Enregistrer</button>
        </form>

        commandes.php
            <button class="btn btn-ghost" style="width:100%; margin-top:10px;">Retour</button>
        </a>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
