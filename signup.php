<?php include 'includes/header.php'; ?>
<?php include 'includes/database.php'; ?>

<?php
$message = "";
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($username === "" || $email === "" || $password === "") {
        $_SESSION['message'] = "Veuillez remplir tous les champs.";
        header("Location: signup.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Email invalide.";
        header("Location: signup.php");
        exit;
    }

    // Vérifier email déjà présent
    $stmt = $conn->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    if ($count > 0) {
        $_SESSION['message'] = "Cet email est déjà utilisé.";
        header("Location: signup.php");
        exit;
    }

    $stmt->close();

    // Inscription
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO utilisateur (login, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed);
    $stmt->execute();

    $_SESSION['message'] = "Inscription réussie. Vous pouvez vous connecter.";
    header("Location: login.php");
    exit;
}
?>

<div class="auth-wrap">
    <div class="auth-card">

        <div class="auth-header">
            <div class="auth-logo">🥖 Sandwich</div>
            <div class="auth-subtitle">Créez votre compte</div>
        </div>

        <div class="auth-body">

            <?php if ($message): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form action="signup.php" method="POST">

                <div class="form-group">
                    <label class="form-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" name="username" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Adresse email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <button class="btn btn-primary" style="width:100%; margin-top:10px;">Créer mon compte</button>

            </form>
            <div class="divider">ou</div>

            <a href="index.php" style="display: block; text-align: center; color: var(--c-text); margin-top: var(--sp-md);">Continuer en tant qu'invité</a>

        </div>

        <div class="auth-footer">
            Vous avez déjà un compte ?
            <a href="login.php">Se connecter</a>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>