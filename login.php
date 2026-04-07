<?php include 'includes/header.php'; ?>
<?php include 'includes/database.php'; ?>

<?php
// Message de session
$message = "";
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Traitement formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === "" || $password === "") {
        $_SESSION['message'] = "Veuillez remplir tous les champs.";
        header("Location: login.php");
        exit;
    }

    // Vérifier l'utilisateur
    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user || !password_verify($password, $user['password'])) {
        $_SESSION['message'] = "Identifiants incorrects.";
        header("Location: login.php");
        exit;
    }

    // Connexion OK
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id_utilisateur'];
    $_SESSION['username'] = $user['login'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = isset($user['role']) ? intval($user['role']) : 1;

    header("Location: index.php");
    exit;
}
?>

<div class="auth-wrap">
    <div class="auth-card">

        <div class="auth-header">
            <div class="auth-logo">🥖 Sandwich</div>
            <div class="auth-subtitle">Connectez-vous pour passer vos commandes</div>
        </div>

        <div class="auth-body">

            <?php if ($message): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">

                <div class="form-group">
                    <label class="form-label">Adresse email</label>
                    <input type="email" class="form-control" name="email" placeholder="vous@exemple.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" placeholder="•••••••" required>
                </div>

                <button class="btn btn-primary" style="width:100%; margin-top:10px;">Se connecter</button>

            </form>

            <div class="divider">ou</div>

            <a href="index.php" style="display: block; text-align: center; color: var(--c-text); margin-top: var(--sp-md);">Continuer en tant qu'invité</a>

        </div>

        <div class="auth-footer">
            Pas encore de compte ?  
            <a href="signup.php">S'inscrire</a>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>