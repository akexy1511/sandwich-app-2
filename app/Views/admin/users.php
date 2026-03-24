<?php require __DIR__.'/../components/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Gestion des utilisateurs</h1>
</div>

<div class="orders-wrap">
    <table class="orders-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['id_utilisateur'] ?></td>
                <td><?= htmlspecialchars($u['login']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    /admin/users/delete">
                        <input type="hidden" name="id" value="<?= $u['id_utilisateur'] ?>">
                        <button class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__.'/../components/footer.php'; ?>