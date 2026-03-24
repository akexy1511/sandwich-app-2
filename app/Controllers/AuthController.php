<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

class AuthController extends Controller
{
    public function login()
    {
        $this->view('auth/login');
    }

    public function processLogin()
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$email || !$password) {
            $_SESSION['auth_error'] = "Veuillez remplir tous les champs.";
            return header("Location: /login");
        }

        $db = Database::db();
        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['auth_error'] = "Identifiants incorrects.";
            return header("Location: /login");
        }

        // Bonne connexion
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['username'] = $user['login'];

        header("Location: /");
    }

    public function signup()
    {
        $this->view('auth/signup');
    }

    public function processSignup()
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$username || !$email || !$password) {
            $_SESSION['auth_error'] = "Veuillez remplir tous les champs.";
            return header("Location: /signup");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['auth_error'] = "Email invalide.";
            return header("Location: /signup");
        }

        $db = Database::db();

        // Vérifier doublon email
        $check = $db->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = :email");
        $check->execute(['email' => $email]);

        if ($check->fetch()) {
            $_SESSION['auth_error'] = "Cet email est déjà utilisé.";
            return header("Location: /signup");
        }

        // Hash du mot de passe
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Inscription
        $insert = $db->prepare("
            INSERT INTO utilisateur (login, email, password) 
            VALUES (:login, :email, :password)
        ");

        $insert->execute([
            'login' => $username,
            'email' => $email,
            'password' => $hashed
        ]);

        $_SESSION['auth_success'] = "Inscription réussie. Vous pouvez vous connecter.";
        header("Location: /login");
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /");
    }
}