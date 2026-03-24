<?php require __DIR__ . '/../components/header.php'; ?>

<div class="auth-wrap">
    <div class="auth-card">

        <div class="auth-header">
            <div class="auth-logo">🥖 Sandwich</div>
            <div class="auth-subtitle">Créez votre compte</div>
        </div>

        <div class="auth-body">

            <?php if (!empty($_SESSION['auth_error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['auth_error']) ?>
                </div>
                <?php unset($_SESSION['auth_error']); ?>
            <?php endif; ?>

            <form action="/signup" method="POST">

                <div class="form-group">
                    <label class="form-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" name="username" placeholder="Jean Dupont" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Adresse email</label>
                    <input type="email" class="form-control" name="email" placeholder="vous@exemple.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" placeholder="•••••••" required>
                </div>

                <button class="btn btn-primary" style="width:100%; margin-top:10px;">
                    Créer un compte
                </button>
            </form>

        </div>

        <div class="auth-footer">
            Déjà un compte ?
            <a href="/login">Se connecter</a>
        </div>

    </div>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>