<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Commande;

class CommandeController extends Controller
{
    public function index()
    {
        if (empty($_SESSION['user_id'])) {
            return header("Location: /login");
        }

        $userId = $_SESSION['user_id'];

        // Charger commandes utilisateur
        $commandes = Commande::getByUser($userId);

        // Charger sandwiches.json (images + prix)
        $sandwiches = [];
        $json = __DIR__ . '/../../sandwiches.json';

        if (file_exists($json)) {
            $sandwiches = json_decode(file_get_contents($json), true) ?? [];
        }

        $this->view('commandes/index', [
            'commandes' => $commandes,
            'sandwiches' => $sandwiches
        ]);
    }
    public function delete()
    {
        if (empty($_SESSION['user_id'])) {
            return header("Location: /login");
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return header("Location: /commandes");
        }

        $commandeId = intval($_POST['id_commande'] ?? 0);

        if (!$commandeId) {
            $_SESSION['message'] = "Commande invalide.";
            return header("Location: /commandes");
        }

        \App\Models\Commande::delete($commandeId, $_SESSION['user_id']);

        $_SESSION['message'] = "Commande supprimée.";
        return header("Location: /commandes");
    }

    public function edit($idCommande)
    {
        if (empty($_SESSION['user_id'])) {
            return header("Location: /login");
        }

        $db = \App\Core\Database::db();

        // Charger la commande
        $stmt = $db->prepare("
            SELECT * FROM commandes 
            WHERE id_commande = :id 
            AND id_utilisateur = :uid
        ");

        $stmt->execute([
            'id'  => $idCommande,
            'uid' => $_SESSION['user_id']
        ]);

        $commande = $stmt->fetch();

        if (!$commande) {
            $_SESSION['message'] = "Commande introuvable.";
            return header("Location: /commandes");
        }

        // Charger sandwiches.json
        $sandwiches = \App\Models\Sandwich::all();

        $this->view('commandes/edit', [
            'commande'   => $commande,
            'sandwiches' => $sandwiches
        ]);
    }

    public function update()
    {
        if (empty($_SESSION['user_id'])) {
            return header("Location: /login");
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return header("Location: /commandes");
        }

        $idCommande = intval($_POST['id_commande'] ?? 0);
        $sandwich   = trim($_POST['sandwich'] ?? '');
        $crudites   = ($_POST['crudites'] ?? '') === 'sans' ? 'sans' : 'avec';

        if (!$idCommande || !$sandwich) {
            $_SESSION['message'] = "Modification invalide.";
            return header("Location: /commandes");
        }

        \App\Models\Commande::update(
            $idCommande,
            $_SESSION['user_id'],
            $sandwich,
            $crudites
        );

        $_SESSION['message'] = "Commande modifiée avec succès.";
        return header("Location: /commandes");
    }

}
