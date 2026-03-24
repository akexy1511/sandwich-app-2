<?php require __DIR__ . '/../components/header.php'; ?>

<div class="auth-wrap">
    <div class="auth-card">

        <div class="auth-header">
            <div class="auth-logo">🥖 Sandwich</div>
            <div class="auth-subtitle">Connectez-vous pour passer vos commandes</div>
        </div>

        <div class="auth-body">

            <?php if (!empty($_SESSION['auth_error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['auth_error']) ?>
                </div>
                <?php unset($_SESSION['auth_error']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['auth_success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['auth_success']) ?>
                </div>
                <?php unset($_SESSION['auth_success']); ?>
            <?php endif; ?>

            <form action="/login" method="POST">

                <div class="form-group">
                    <label class="form-label">Adresse email</label>
                    <input type="email" class="form-control" name="email" placeholder="vous@exemple.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" placeholder="•••••••" required>
                </div>

                <button class="btn btn-primary" style="width:100%; margin-top:10px;">
                    Se connecter
                </button>
            </form>

            <div class="divider">ou</div>

            <a href="/" class="btn btn-secondary" style="width:100%; justify-content:center;">
                Continuer en tant qu'invité
            </a>
        </div>

        <div class="auth-footer">
            Pas encore de compte ?
            <a href="/signup">Créer un compte</a>
        </div>

    </div>
</div>

<?php require __DIR__ . '/../components/footer.php'; ?>