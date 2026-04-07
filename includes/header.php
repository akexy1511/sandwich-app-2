<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sandwich</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        // Initialiser le thème au chargement de la page
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
</head>
<body>

<nav class="app-header">
    <a href="index.php" class="app-logo" style="text-decoration: none; color: inherit;">
        <div class="app-logo-icon">🥖</div>
        Sandwich
    </a>

    <div class="header-actions">
        <button id="theme-toggle" class="theme-toggle" title="Mode sombre/clair">
            <span class="theme-toggle-icon">🌙</span>
        </button>

        <?php if (!isset($_SESSION['user_id'])): ?>

            <a href="signup.php" class="btn btn-outline-primary">
               Créer un compte
            </a>

            <a href="login.php" class="btn btn-primary">
               Connexion
            </a>

        <?php else: ?>

            <?php if (intval($_SESSION['role'] ?? 1) === 0): ?>
                <a href="admin-commandes.php" class="btn btn-secondary">
                    Liste des commandes
                </a>
            <?php endif; ?>

            <a href="commandes.php" class="btn btn-secondary">
                Mes commandes
            </a>

            <a href="logout.php" class="btn btn-danger">
                Déconnexion
            </a>

        <?php endif; ?>
    </div>
</nav>

<div class="content">