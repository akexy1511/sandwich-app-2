<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Sandwich</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="app-header">
    <div class="app-logo">
        <div class="app-logo-icon">🥖</div>
        Sandwich
    </div>

    <div class="header-actions">
        <?php if (!isset($_SESSION['user_id'])): ?>

            <a href="signup.php" class="btn btn-secondary"
               style="background:#ffffff; color:var(--c-brand); border:1px solid var(--c-brand);">
               Créer un compte
            </a>

            <a href="login.php" class="btn btn-primary">
               Connexion
            </a>

        <?php else: ?>

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