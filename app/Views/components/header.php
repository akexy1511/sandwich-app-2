<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sandwich</title>

    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time() ?>">
</head>
<body>
<?php if (!empty($_SESSION['message'])): ?>
<div class="alert alert-info" style="margin: 20px;">
    <?= htmlspecialchars($_SESSION['message']) ?>
</div>
<?php unset($_SESSION['message']); ?>
<?php endif; ?>
<nav class="app-header">
    <div class="app-logo">
        <div class="app-logo-icon">🥖</div>
        Sandwich
    </div>

    <div class="header-actions">
        <a href="/commandes" class="btn btn-ghost btn-sm">Mes commandes</a>
        <a href="/login" class="btn btn-primary btn-sm">Se connecter</a>
    </div>
</nav>