<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

class AdminController extends Controller
{
    private function isAdmin()
    {
        return isset($_SESSION['user_id'], $_SESSION['username'], $_ENV['ADMIN_EMAIL'])
            && $_SESSION['username'] === $_ENV['ADMIN_EMAIL'];
    }

    private function guard()
    {
        if (!$this->isAdmin()) {
            $_SESSION['message'] = "Accès réservé à l’administrateur.";
            header("Location: /");
            exit;
        }
    }

    public function index()
    {
        $this->guard();
        $db = Database::db();

        // Statistiques
        $stats = [];

        $stats['total_commandes'] = $db->query("SELECT COUNT(*) FROM commandes")->fetchColumn();
        $stats['total_users']     = $db->query("SELECT COUNT(*) FROM utilisateur")->fetchColumn();
        $stats['revenus']         = $db->query("SELECT SUM(montant) FROM transaction")->fetchColumn();

        $this->view('admin/dashboard', [
            'stats' => $stats
        ]);
    }

    public function users()
    {
        $this->guard();

        $db = Database::db();
        $users = $db->query("SELECT * FROM utilisateur ORDER BY id_utilisateur DESC")->fetchAll();

        $this->view('admin/users', ['users' => $users]);
    }

    public function deleteUser()
    {
        $this->guard();

        $id = intval($_POST['id'] ?? 0);

        if (!$id) {
            $_SESSION['message'] = "Utilisateur invalide.";
            return header("Location: /admin/users");
        }

        $db = Database::db();
        $stmt = $db->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :id");
        $stmt->execute(['id' => $id]);

        $_SESSION['message'] = "Utilisateur supprimé.";
        header("Location: /admin/users");
    }

    public function commandes()
    {
        $this->guard();
        $db = Database::db();

        $cmd = $db->query("
            SELECT c.*, u.login, 
                CASE WHEN f.id_commande IS NOT NULL THEN 1 ELSE 0 END AS is_paid
            FROM commandes c
            JOIN utilisateur u ON c.id_utilisateur = u.id_utilisateur
            LEFT JOIN facturation f ON c.id_commande = f.id_commande
            ORDER BY date_de_commande DESC
        ")->fetchAll();

        $this->view('admin/commandes', ['commandes' => $cmd]);
    }

    public function sandwichs()
    {
        $this->guard();

        $file = __DIR__ . '/../../sandwiches.json';
        $data = json_decode(file_get_contents($file), true);

        $this->view('admin/sandwichs', [
            'sandwiches' => $data
        ]);
    }

    public function updateSandwich()
    {
        $this->guard();

        $name = strtolower($_POST['name'] ?? '');
        $price = floatval($_POST['price'] ?? 0);

        $file = __DIR__ . '/../../sandwiches.json';
        $data = json_decode(file_get_contents($file), true);

        if (isset($data[$name])) {
            $data[$name]['price'] = $price;
            file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
            $_SESSION['message'] = "Prix mis à jour.";
        }

        header("Location: /admin/sandwichs");
    }
}