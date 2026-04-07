<?php include 'includes/header.php'; ?>
<?php include 'includes/database.php'; ?>
<?php include 'includes/auth.php'; ?>

<?php
if (intval($_SESSION['role'] ?? 1) !== 0) {
    echo "<p>Accès refusé.</p>";
    include 'includes/footer.php';
    exit;
}

$users = $conn->query("SELECT * FROM utilisateur ORDER BY id_utilisateur DESC");
?>

<div class="page-header">
    <h1 class="page-title">Utilisateurs</h1>
</div>

<div class="orders-wrap">
    <div class="card">
        <div class="card-body" style="overflow:auto;">

            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Login</th>
                        <th>Email</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($u = $users->fetch_assoc()): ?>
                        <tr>
                            <td><?= $u['id_utilisateur'] ?></td>
                            <td><?= $u['login'] ?></td>
                            <td><?= $u['email'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>