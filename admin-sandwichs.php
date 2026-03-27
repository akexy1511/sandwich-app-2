<?php include 'includes/header.php'; ?>
<?php include 'includes/database.php'; ?>
<?php include 'includes/auth.php'; ?>

<?php
if ($_SESSION['email'] !== "admin@cepes.be") {
    echo "<p>Accès refusé.</p>";
    include 'includes/footer.php';
    exit;
}

$json = "sandwiches.json";
$data = json_decode(file_get_contents($json), true);

// Mise à jour ?
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = strtolower($_POST['name']);
    $p = floatval($_POST['price']);

    $data[$n]['price'] = $p;
    file_put_contents($json, json_encode($data, JSON_PRETTY_PRINT));

    header("Location: admin-sandwichs.php");
    exit;
}
?>

<div class="page-header">
    <h1 class="page-title">Gestion des sandwichs</h1>
</div>

<div class="orders-wrap">
    <div class="card">
        <div class="card-body">

            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Modifier</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($data as $name => $s): ?>
                        <tr>
                            <td><?= ucfirst($name) ?></td>
                            <td><?= $s['price'] ?> €</td>
                            <td>

                                admin-sandwichs.php" method="POST">
                                    <input type="hidden" name="name" value="<?= $name ?>">
                                    <input type="number" step="0.01" name="price" value="<?= $s['price'] ?>">
                                    <button class="btn btn-primary btn-sm">OK</button>
                                </form>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>